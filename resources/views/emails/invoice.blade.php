<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Receipt</title>
</head>
<body>
    <table style="width: 100%; border: none; padding: 20px; font-family: Arial, sans-serif;">
        <tr>
            <td>
                <img src="cid:logo.png" alt="Company Logo" style="width: 200px;"/>
            </td>
        </tr>
        <tr>
            <td>
                <h1>Invoice Receipt</h1>
                <p>Thank you for your purchase. Here is the receipt for your invoice:</p>
                <p>Invoice ID: {{ $invoice->id }}</p>
                <p>Invoice Date: {{ $invoice->invoice_date->format('Y-m-d') }}</p>
                <p>Due Date: {{ $invoice->due_date->format('Y-m-d') }}</p>
                <p>Status: {{ ucfirst($invoice->status) }}</p>
                <p>Amount: ₱{{ number_format($invoice->amount, 2) }}</p>
                <h2>Invoice Details:</h2>
                
                <p>Thank you for choosing Highland Vets</p>
            </td>
        </tr>
    </table>
</body>
</html>
