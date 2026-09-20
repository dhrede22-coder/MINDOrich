<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | CONVERT OLD STATUSES
        |--------------------------------------------------------------------------
        |
        | Keep existing orders safe before changing the enum values.
        |
        */
        DB::table('sales')
            ->where('status', 'Confirmed')
            ->update([
                'status' => 'Processing',
            ]);

        DB::table('sales')
            ->where('status', 'Shipped')
            ->update([
                'status' => 'To Deliver',
            ]);


        /*
        |--------------------------------------------------------------------------
        | UPDATE STATUS ENUM
        |--------------------------------------------------------------------------
        |
        | Online order flow:
        | Pending -> Processing -> To Deliver -> Delivered
        |
        | Cancelled can be used for cancelled orders.
        |
        | Completed is retained for Walk-in orders.
        |
        */
        DB::statement("
            ALTER TABLE sales
            MODIFY COLUMN status ENUM(
                'Pending',
                'Processing',
                'To Deliver',
                'Delivered',
                'Cancelled',
                'Completed'
            ) NOT NULL DEFAULT 'Pending'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | CONVERT NEW STATUSES BACK
        |--------------------------------------------------------------------------
        */
        DB::table('sales')
            ->where('status', 'To Deliver')
            ->update([
                'status' => 'Shipped',
            ]);

        DB::table('sales')
            ->where('status', 'Delivered')
            ->update([
                'status' => 'Completed',
            ]);


        /*
        |--------------------------------------------------------------------------
        | RESTORE OLD STATUS ENUM
        |--------------------------------------------------------------------------
        */
        DB::statement("
            ALTER TABLE sales
            MODIFY COLUMN status ENUM(
                'Pending',
                'Confirmed',
                'Processing',
                'Shipped',
                'Delivered',
                'Cancelled',
                'Completed'
            ) NOT NULL DEFAULT 'Pending'
        ");
    }
};