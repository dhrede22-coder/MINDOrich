<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Add the stock-removal movement type used by the inventory workflow.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE inventory_movements
            MODIFY movement_type ENUM(
                'Stock In',
                'Stock Out',
                'Online Sale',
                'Walk-in Sale',
                'Stock Adjustment',
                'Returned',
                'Damaged'
            ) NOT NULL
        ");
    }

    /**
     * Restore the original enum only when no Stock Out records would be lost.
     */
    public function down(): void
    {
        if (DB::table('inventory_movements')
            ->where('movement_type', 'Stock Out')
            ->exists()) {
            throw new \RuntimeException(
                'Cannot remove the Stock Out movement type while Stock Out inventory records exist.'
            );
        }

        DB::statement("
            ALTER TABLE inventory_movements
            MODIFY movement_type ENUM(
                'Stock In',
                'Online Sale',
                'Walk-in Sale',
                'Stock Adjustment',
                'Returned',
                'Damaged'
            ) NOT NULL
        ");
    }
};
