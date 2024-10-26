<!DOCTYPE html>
<html>
<head>
    <title>Invoice {{ $invoice->invoice_no }}</title>
    <style>
        /* Add CSS styles for your PDF */
    </style>
</head>
<body>
    <h1>Invoice #{{ $invoice->invoice_no }}</h1>
    <h5 style="color:red;">TODO: format to be fixed!</h5>
    <p>Date: {{ $invoice->invoice_date }}</p>
    <p>Customer: {{ $invoice->customer->company_name }}</p>
    
    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Rate</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->invoiceItems as $item)
                <tr>
                    <td>{{ $item->particulars }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ $item->rate }}</td>
                    <td>{{ $item->amount }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <p>Gross Amount: {{ $invoice->gross_amt }}</p>
    <p>VAT Amount: {{ $invoice->vat_amt }}</p>
    <p>Net Amount: {{ $invoice->net_amt }}</p>
</body>
</html>
