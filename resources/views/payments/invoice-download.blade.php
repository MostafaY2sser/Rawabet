<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>فاتورة {{ $payment->transaction_reference ?: 'INV-' . $payment->id }}</title>
    <style>
        body { font-family: Tahoma, Arial, sans-serif; padding: 24px; color: #111; }
        h1 { font-size: 20px; margin-bottom: 24px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #e5e7eb; padding: 10px; text-align: right; }
        th { background: #f9fafb; width: 35%; }
    </style>
</head>
<body>
    <h1>فاتورة دفع</h1>
    @include('payments.partials.invoice-details', ['payment' => $payment])
</body>
</html>
