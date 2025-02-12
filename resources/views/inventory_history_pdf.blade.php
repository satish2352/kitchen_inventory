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
                <th>Inventory Name</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
          
            @foreach ($historyData as $data)
            <tr>
                <!-- <td>{{ $data['location_id'] }}</td> -->
                <td>{{ $data['inventory_id'] }}</td>
                <td>{{ $data['quantity'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>