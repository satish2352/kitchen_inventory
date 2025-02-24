<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Inventory History</title>
      <style>
         body { font-family: Arial, sans-serif; }
         table { width: 100%; border-collapse: collapse; margin-top: 10px; }
         th, td { border: 1px solid black; padding: 10px; text-align: center; }
         th { background-color: #ddd; font-weight: bold; text-transform: uppercase; }
         tr:nth-child(even) { background-color: #f9f9f9; }
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
         width: 48%; /* Adjust width as needed */
         /* background-color: #f4f4f4; */
         padding: 20px;
         box-sizing: border-box;
         }
      </style>
   </head>
   <body>
      <!-- Logo Section -->
      <center><img src="data:image/png;base64,{{ $historyData[0]['logimg'] }}" width="50%" /></center>
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
            Date: {{ date('d-m-Y', strtotime($currentDate)) }}
         </div>
      </div>
      <br>
      <br>
      <div style="width: 100%;">
         <div style="float: left;">
         Name: <b>{{ session()->get('user_name') }}</b>
         </div>
         <div style="float: right;">
            @if(session()->get('user_role') =='1')
           Role: Super Admin
            @elseif(session()->get('user_role') =='2')
            Role: Admin
            @elseif(session()->get('user_role') =='3')
            Role: Night Manager
            @endif
         </div>
      </div>
      <br>
      <br>
      <table>
         <thead>
            <tr>
               <th>Sr. No.</th>
               <th>Master Qty</th>
               <th>Item Name</th>
               <th>Present Qty</th>
               <th>Buy Qty</th>
               @if(session()->get('user_role') =='1')
               <th>Total Price</th>
               @endif
            </tr>
         </thead>
         <tbody>
            @php 
            $srNo = 1; 
            $finalPrice = 0
            @endphp
            @foreach ($historyData as $data)
            @php
            $buyQty = $data['master_qty'] - $data['quantity'];
            @endphp
            @if($buyQty  > 0 )
            <tr>
               <td>{{ $srNo++ }}</td>
               <td>{{ $data['master_qty'] }}</td>
               <td>{{ $data['inventory_id'] }}</td>
               <td>{{ $data['quantity'] }}</td>
               <td>{{ $buyQty }}</td>
               @if(session()->get('user_role') =='1')
               <td>
                  @php 
                  $finalPrice = $finalPrice + $buyQty * $data['price'];
                  @endphp
                  $ {{ $buyQty * $data['price'] }}</td>
               @endif
            </tr>
            @endif
            @endforeach
            @if(session()->get('user_role') =='1')
            <td colspan="5"></td>
               <td>$ {{ $finalPrice }}</td>
               @endif
         </tbody>
      </table>
   </body>
</html>