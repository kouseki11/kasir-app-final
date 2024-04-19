<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::get()->map(function ($product) {
            
            return [
                'Name' => $product->name,
                'Price' => $product->price,
                'Stock' => $product->stock,
            ];
        });
    }

    public function headings(): array
    {
        return [
            ['PRODUCTS REPORT'],
            [],
            [
            'Name',
            'Price',
            'Stock',
            ],
        ];
    }
}
