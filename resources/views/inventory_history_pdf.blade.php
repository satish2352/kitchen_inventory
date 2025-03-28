<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #ddd;
            font-weight: bold;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Styling for the header section */
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .header-section h3 {
            margin: 0;
        }

        .header-section .location-date {
            font-size: 14px;
        }

        /* Horizontal line styling */
        .horizontal-line {
            border-top: 2px solid black;
            width: 100%;
            margin-top: 10px;
        }

        /* Left side content */
        .left-side {
            width: 48%;
            /* Adjust width as needed */
            /* background-color: #f4f4f4; */
            padding: 20px;
            box-sizing: border-box;
        }
    </style>
</head>

<body>
    <!-- Logo Section -->
    <center><img src="data:image/png;base64,{{ $logo }}" width="50%" /></center>
    <div class="horizontal-line"></div>
    <!-- Horizontal line -->
    <div class="header-section">
        <center>
            <h3>Inventory Report</h3>
        </center>
    </div>
    <div style="width: 100%;">
        <div style="float: left;">
            Location: {{ $location }}
        </div>
        <div style="float: right;">
         @php $currentDate = now(); @endphp
            Date: {{ date('d-m-Y H:i', strtotime($currentDate)) }}
        </div>
    </div>
    <br>
    <br>
    <div style="width: 100%;">
        <div style="float: left;">
            Name: <b>{{ session()->get('user_name') }}</b>
        </div>
        <div style="float: right;">
            @if (session()->get('user_role') == '1')
                Role: Super Admin
            @elseif(session()->get('user_role') == '2')
                Role: Admin
            @elseif(session()->get('user_role') == '3')
                Role: Night Manager
            @endif
        </div>
    </div>
    <br>
    <br>
    <table>
        <thead>
            <tr>
                <!-- <th>Sr. No.</th> -->
                <th>Master Qty</th>
                <th>Item Name</th>
                <th>Present Qty</th>
                <th>Buy Qty</th>
                {{-- @if (session()->get('user_role') == '1') --}}
                    <th>Total Price</th>
                {{-- @endif --}}
            </tr>
        </thead>
        <tbody>
            @php
                $srNo = 1;
                $finalPrice = 0;
            @endphp
            @foreach ($historyData as $category => $item_data)
                @php
                    $item_to_buy_available = 0;
                @endphp
                <tr>
                    
                    <td colspan="5"><span style="font-size: 1rem;">{{$category}}</span></td>
                </tr>
                
                @foreach ($item_data as $category => $data)
                    @php
                        $buyQty = $data['master_qty'] - $data['quantity'];
                    @endphp
                    @if ($buyQty > 0)
                        <tr>
                            @php
                                $item_to_buy_available = $item_to_buy_available + 1; 
                            @endphp
                            <!-- <td>{{ $srNo++ }}</td> -->
                            <td>{{ $data['master_qty'] }} {{ $data['unit'] }}</td>
                            <td>{{ $data['item_name'] }}</td>
                            <td>{{ $data['quantity'] }} {{ $data['unit'] }}</td>
                            <td>{{ $buyQty }} {{ $data['unit'] }}</td>
                            {{-- @if (session()->get('user_role') == '1') --}}
                                <td>
                                    @php
                                        $finalPrice = $finalPrice + $buyQty * $data['price'];
                                    @endphp
                                    $ {{ $buyQty * $data['price'] }}</td>
                            {{-- @endif --}}
                        </tr>
                    @endif
                @endforeach
                @if($item_to_buy_available == 0)
                <tr>
                    <td colspan="5"><span style="font-size: 0.85rem;">No items were found for this category </span></td>
                </tr>
                @endif
            @endforeach
            {{-- @if (session()->get('user_role') == '1') --}}
                @if($finalPrice > 0)
                <td colspan="4">Total Price: </td>
                <td>$ {{ $finalPrice }}</td>
                @else
                <td colspan="5">No items were found for buy </td>
                @endif
            {{-- @endif --}}
            
        </tbody>
    </table>
</body>

</html>
