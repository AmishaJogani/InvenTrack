<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; }
        .invoice-box { max-width: 800px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; background: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        table { width: 100%; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: center; }
        .invoice-title { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body class="bg-light">
    <div class="container my-5">
        <div class="invoice-box">
            <h2 class="invoice-title">Invoice #{{ $sale->id }}</h2>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Customer:</strong> {{ $sale->customer->name }}</p>
                    <p><strong>Contact:</strong> {{ $sale->customer->contact }}</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p><strong>Date:</strong> {{ $sale->created_at->format('d M, Y') }}</p>
                </div>
            </div>

            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->saleItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>₹{{ $item->selling_price }}</td>
                        <td>₹{{ $item->quantity * $item->selling_price }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <h3 class="text-end">Total: ₹{{ $sale->total_amount }}</h3>
        </div>
    </div>
</body>
</html>
