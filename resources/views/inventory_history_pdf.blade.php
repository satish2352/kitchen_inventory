<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory History</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
<h3>Inventory Report - {{ $location }} ({{ date('d-m-Y', strtotime($currentDate)) }})</h3>

    <table>
        <thead>
            <tr>
                <!-- <th>Location Name</th> -->
                <th>Sr. No.</th>
                <th>Master Qty</th>
                <th>Inventory Name</th>
                <th>Present Qty</th>
                <th>Buy Qty</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
        @php $srNo = 1; @endphp
            @foreach ($historyData as $data)
            @php
                $buyQty=$data['master_qty'] - $data['quantity'];
            @endphp
            <tr>
                <!-- <td>{{ $data['location_id'] }}</td> -->
                <td>{{ $srNo++ }}</td>
                <td>{{ $data['master_qty'] }}</td>
                <td>{{ $data['inventory_id'] }}</td>
                <td>{{ $data['quantity'] }}</td>
                <td>{{ $buyQty }}</td>
                <td>$ {{ $data['quantity'] * $data['price'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>