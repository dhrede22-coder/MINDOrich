<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Producer;
use App\Models\SaleItem;
use App\Models\Tribe;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $qualifyingSales = function ($query) {
            $query->where(function ($query) {
                $query
                    ->where('sale_type', 'Online')
                    ->where('status', 'Delivered');
            })->orWhere(function ($query) {
                $query
                    ->where('sale_type', 'Walk-in')
                    ->where('status', 'Completed');
            });
        };

        // ============================================================
        // TOP 8 BEST-SELLING PRODUCTS
        // ============================================================

        $products = Product::query()
            ->where('status', 'Available')
            ->whereHas('saleItems.sale', $qualifyingSales)
            ->with([
                'category',
                'producer.tribe',
                'promotions',
            ])
            ->withSum([
                'saleItems as units_sold' => function ($query) use ($qualifyingSales) {
                    $query->whereHas('sale', $qualifyingSales);
                },
            ], 'quantity')
            ->orderByDesc('units_sold')
            ->limit(8)
            ->get();

        // ============================================================
        // TOP 3 FEATURED PRODUCERS
        // Based on total units sold
        // ============================================================

        $producers = Producer::query()
            ->where('status', 'Active')
            ->whereHas('products.saleItems.sale', $qualifyingSales)
            ->with('tribe')
            ->select('producers.*')
            ->selectSub(
                SaleItem::query()
                    ->join('sales', 'sales.id', '=', 'sale_items.sale_id')
                    ->join('products', 'products.id', '=', 'sale_items.product_id')
                    ->whereColumn('products.producer_id', 'producers.id')
                    ->where(function ($query) {
                        $query
                            ->where(function ($query) {
                                $query
                                    ->where('sales.sale_type', 'Online')
                                    ->where('sales.status', 'Delivered');
                            })
                            ->orWhere(function ($query) {
                                $query
                                    ->where('sales.sale_type', 'Walk-in')
                                    ->where('sales.status', 'Completed');
                            });
                    })
                    ->selectRaw('COALESCE(SUM(sale_items.quantity), 0)'),
                'units_sold'
            )
            ->orderByDesc('units_sold')
            ->limit(3)
            ->get();

        // ============================================================
        // MANGYAN TRIBES
        // ============================================================

        $tribes = Tribe::query()
            ->where('status', 'Active')
            ->orderBy('tribe_name')
            ->get();

        return view(
            'public.home',
            compact('products', 'producers', 'tribes')
        );
    }
}