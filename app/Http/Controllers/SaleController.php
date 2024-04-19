<?php

namespace App\Http\Controllers;

use App\Exports\SalesExport;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     //Sale View Page
    public function index()
    {
        $sales = Sale::latest()->where('status', 0)->paginate(5);
        return view('admin.sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */

    //Sale View for create page
    public function create()
    {
        $products = Product::all();
        return view('admin.sales.create', compact('products'));
    }

    //Execute Invoice for save session
    public function invoice(Request $request)
    {
        try {

        $products = [];
        $productIds = $request->product_id;
        $quantitys = $request->quantity;

        foreach ($productIds as $index => $productId) {
            $products[] = [
                "product_id" => $productId,
                "quantity" => $quantitys[$index],
            ];
        }

        $productIdsToSearch = array_column($products, 'product_id');
        $items = Product::whereIn('id', $productIdsToSearch)->get();


        $errorMessages = '';

        foreach ($products as $product) {
            $found = false;
            foreach ($items as $item) {
                if ($product["product_id"] == $item->id) {
                    $found = true;
                    if ($product["quantity"] > $item->stock) {
                        $errorMessages = "Stock product " . $item['name'] . " Insufficient";
                    }
                    break;
                }
            }
            if (!$found) {
                $errorMessages = "Product dengan ID '" . $product["product_id"] . "' tidak tersedia";
            }
        }

        if (!empty($errorMessages)) {
            return back()->with("error", $errorMessages);
        }

        // dd($products);

        session([
            "product" => $products,
        ]);

        return view("admin.sales.invoice", compact(
            "products",
            "items",
        ));

        } catch(Exception $e) {
            dd($e);
        }
    }

    //Show Invoice and get session
    public function invoiceData(Request $request)
    {
            $products = session("product");
            $productIdsToSearch = array_column($products, 'product_id');
            $items = Product::whereIn('id', $productIdsToSearch)->get();
            $price_total = 0;

            foreach ($items as $item) {
                foreach ($products as $product) {
                    if ($product["product_id"] == $item->id) {
                        $price = $product["quantity"] * $item->price;
                        $price_total += $price;
                    }
                }
            }

            $name = $request->name;
            $phone_number = $request->phone_number;
            $cash = $request->cash;
            $address = $request->address;

            if ($cash < $price_total) {
                return redirect()->route('sale.create')->with("error", "Your money is not enough");
            }

            $change = $cash - $price_total;

            $customer = Customer::create([
                "name" => $name,
                "phone_number" => $phone_number,
                "address" => $address,
                "cash" => $cash,
                "change" => $change
            ]);

            $sale = Sale::create([
                "customer_id" => $customer->id,
                'sale_date' => now(),
                'price_total' => $price_total,
                'user_id' => Auth::user()->id
            ]);

            foreach ($items as $item) {
                foreach ($products as $product) {
                    if ($product["product_id"] == $item->id) {
                        SaleDetail::create([
                            'sale_id' => $sale->id,
                            'product_id' => $item->id,
                            'quantity' => $product["quantity"],
                            'subtotal' => $product["quantity"] * $item->price
                        ]);

                        $productUpdate = Product::find($item->id);
                        $stock = $productUpdate->stock - $product["quantity"];
                        $productUpdate->update([
                            "stock" => $stock
                        ]);
                    }
                }
            }

        $sales = Sale::where('id', $sale->id)->first();

        // dd($sales['customer']);

        return view("admin.sales.invoice-data", compact(
            "sales"
        ));
    }

    //Execute print pdf for invoice
    public function export(Sale $sale)
    {
        $pdf = Pdf::loadView('admin.sales.pdf-print', ['sale' => $sale]);
    
        return $pdf->download('invoice_' . $sale->customer->name . '.pdf');
    }

    //Execute Sales Report Generate
    public function exportExcel()
    {
        return Excel::download(new SalesExport, 'sales.xlsx');
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        $sale->update([
            'status' => 1,
        ]);

        return redirect()->back()->with('success', 'Sale delete successfully!');
    }
}
