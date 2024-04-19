<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Sale::get()->map(function ($sales) {

            foreach ($sales['saleDetail'] as $item) {
                $product_name = $item['product']['name'];
                $product_price = $item['product']['price'];
                $product_qty = $item['quantity'];
                $product_subtotal = $item['subtotal'];
            }
            
            
            return [
                'Customer Name' => $sales['customer']['name'],
                'Address' => $sales['customer']['address'],
                'Phone Number' => $sales['customer']['phone_number'],
                'Product Name' => $product_name,
                'Price' => $product_price,
                'Quantity' => $product_qty,
                'Subtotal' => $product_subtotal,
                'Price Total' => $sales['price_total'],
                'Created By' => $sales['user']['name'],
                'Sale Date' => $sales['sale_date'],
            ];
        });
    }

    public function headings(): array
    {
        return [
            ['SALES REPORT'],
            [],
            [
            'Customer Name',
            'Address',
            'Phone Number',
            'Product Name',
            'Price',
            'Quantity',
            'Subtotal',
            'Price Total',
            'Created By',
            'Sale Date',
            ]
        ];
    }
}
