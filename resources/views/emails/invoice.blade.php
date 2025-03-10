<!DOCTYPE html>
<html>
<head>
    <title>Your Invoice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f8f9fa; padding: 20px;">

    <div class="container">
        <div class="card shadow-sm mx-auto" style="max-width: 600px;">
            <div class="card-header bg-primary text-white text-center">
                <h2>Your Invoice</h2>
            </div>
            <div class="card-body">
                <p class="fs-5">Hello <strong>{{ $sale->customer->name }}</strong>,</p>
                <p>Thank you for your purchase! Your invoice is attached.</p>
                
                <div class="border p-3 rounded">
                    <p><strong>Order ID:</strong> {{ $sale->id }}</p>
                    <p><strong>Total Amount:</strong> <span class="text-success">₹{{ number_format($sale->total_amount, 2) }}</span></p>
                </div>

                <p class="mt-3">For any queries, feel free to contact us.</p>

                <p class="text-muted">Regards, <br><strong>Your Business Name</strong></p>
            </div>
        </div>
    </div>

</body>
</html>
