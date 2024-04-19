<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        .container {
            max-width: 32rem; /* 512px */
            margin: 0 auto;
            padding: 2rem;
        }
        .card {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .customer-info {
            margin-bottom: 1rem;
        }
        .customer-info p {
            margin: 0.5rem 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }
        th, td {
            border-bottom: 1px solid #e5e7eb;
            padding: 0.5rem;
            text-align: left;
        }
        .total-row {
            background-color: #f3f4f6;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 2rem;
        }
        .footer p {
            margin: 0.5rem 0;
            font-size: 0.875rem;
            color: #4b5563;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <h2>Indo Agus</h2>
            </div>
            <div class="customer-info">
                <p>Customer Name: {{ $sale['customer']['name'] }}</p>
                <p>Customer Address: {{ $sale['customer']['address'] }}</p>
                <p>Customer Phone Number: {{ $sale['customer']['phone_number'] }}</p>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sale['saleDetail'] as $item)
                    <tr>
                        <td>{{ $item['product']['name'] }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>Rp. {{ number_format($item['product']['price'], 0, ',', '.') }}</td>
                        <td>Rp. {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="3">Price</td>
                        <td>Rp. {{ number_format($sale['price_total'], 0, ',', '.') }}</td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="3">Cash</td>
                        <td>Rp. {{ number_format($sale['customer']['cash'], 0, ',', '.') }}</td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="3">Change</td>
                        <td>Rp. {{ number_format($sale['customer']['change'], 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="footer">
                <p>{{ $sale['created_at'] }} | {{ $sale['user']['name'] }}</p>
                <p><strong>Thank you for your purchase!</strong></p>
            </div>
        </div>
    </div>
</body>
</html>
