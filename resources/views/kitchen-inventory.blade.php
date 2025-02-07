@include('layouts.header')
@include('layouts.sidebar')

@yield('content')
<div class="main">
    <div class="inner-top container-fluid p-3">
        <!-- Top Bar -->
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('/dashboard') }}">
                <button class="btn btn-light">
                    <i class="bi bi-arrow-90deg-left"></i>
                </button>
            </a>
            <h5 class="sub-title">Add Kitchen Inventory</h5>
            <a href="approve-users.html">
                <button class="btn btn-light">
                    <i class="bi bi-check2"></i>
                </button>
            </a>
        </div>
    </div>
    <div class="filter">
        <div class="shopping-list-row d-flex align-items-center p-3">
            <!-- Search Input -->
            <div class="input-group search-input">
                <input type="text" class="form-control" placeholder="Search..." aria-label="Search" />
                <button class="btn btn-srh" type="button">
                    <i class="bi bi-search"></i>
                </button>
            </div>

            <!-- Location Icon -->
            <button class="btn btn-white mx-2">
                <i class="bi bi-geo-alt-fill"></i>
            </button>

            <!-- Bar Grid Icon -->
            <button class="btn btn-white btn-delete">
                <i class="bi bi-filter"></i>
            </button>
        </div>
        <div class="container-fluid px-3">
            <a href="new-shopping-list.html">
                <button type="button" class="btn btn-outline-danger fs-6">
                    Show last submitted Kitchen list
                </button>
            </a>
               

                <form id="locationForm" method="post" action="{{ route('location-selected-admin') }}">
                    @csrf
                    <div class="row mb-3">
                        <label class="form-label col-6">Select Location</label>
                        <div class="col-6">
                            <select class="form-select" name="location_selected" id="location_selected">
                                <option value="">Select Location</option>
                                @foreach ($locationsData as $locations)
                                    <option value="{{ $locations['id'] }}"
                                        @if (session('location_selected') == $locations['id']) selected @endif>{{ $locations['location'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>

<!-- first if start -->
            @if(session()->get('location_selected_id') !='')
            <!-- <?php //print_r($InventoryData); die;?> -->
            <!-- second if start -->
            @if($InventoryData['DataType']=='MasterData')

            <form action="{{ route('add-kitchen-inventory-by-sa') }}" method="POST">
            @csrf
            
            @if (!empty($InventoryData['data_location_wise_inventory']) && count($InventoryData['data_location_wise_inventory']) > 0)
            @foreach ($InventoryData['data_location_wise_inventory'] as $category => $items)
            <!-- Border Box -->
            <div class="border-box mb-4" id="search-results">
                <!-- Header Title -->
                <div class="grid-header text-center">
                    <h6 class="m-0 text-white">{{ $category }}</h6>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <!-- Table Head -->
                        <thead class="table-header">
                            <tr>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Unit</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <!-- Table Body -->
                        <tbody>
                            @foreach ($items as $item)
                            <input type="hidden" class="form-control" name="master_inventory_id[]" id="master_inventory_id" value="{{ $item['id'] }}"/>

                                <tr>
                                    <td>{{ $item['item_name'] }}</td>
                                    <td>
                                        <input type="text" name="quantity[]" class="form-control qty-input"   placeholder="QTY" />
                                    </td>
                                    <td>{{ $item['unit_name'] }}</td>
                                    <td>{{ $item['price'] }}</td>
                                </tr>
                            @endforeach
                            <tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
            <div class="text-center mt-3">
            <button type="submit" class="btn btn-success">Submit Inventory</button>
        </div>
        @else
        <div class="border-box mb-4" id="search-results">
                <!-- Header Title -->
                <div class="grid-header text-center">
                    <h6 class="m-0 text-white">Please Enter Inventory For This location</h6>
                </div>
            </div>  
        @endif
            <!-- Submit Button -->
        

            </form>


            <!-- second if end and else start -->
            @elseif($InventoryData['DataType']=='LocationWiseData')
            <form action="{{ route('update-kitchen-inventory-by-super-admin') }}" method="POST">
            @csrf
            @if (!empty($InventoryData['data_location_wise_inventory']) && count($InventoryData['data_location_wise_inventory']) > 0)
            @foreach ($InventoryData['data_location_wise_inventory'] as $category => $items)
            <!-- Border Box -->
            <div class="border-box mb-4" id="search-results">
                <!-- Header Title -->
                <div class="grid-header text-center">
                    <h6 class="m-0 text-white">{{ $category }}</h6>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <!-- Table Head -->
                        <thead class="table-header">
                            <tr>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Unit</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <!-- Table Body -->
                        <tbody>
                            @foreach ($items as $item)
                            <input type="hidden" class="form-control" name="master_inventory_id[]" id="master_inventory_id" value="{{ $item['id'] }}"/>

                                <tr>
                                    <td>{{ $item['item_name'] }}</td>
                                    <td>
                                        <input type="text" name="quantity[]" class="form-control qty-input" value="{{ $item['quantity'] }}"  placeholder="QTY" />
                                    </td>
                                    <td>{{ $item['unit_name'] }}</td>
                                    <td>{{ $item['price'] }}</td>
                                </tr>
                            @endforeach
                            <tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
            <div class="text-center mt-3">
            <button type="submit" class="btn btn-success">Submit Inventory</button>
        </div>
        @else
        <div class="border-box mb-4" id="search-results">
                <!-- Header Title -->
                <div class="grid-header text-center">
                    <h6 class="m-0 text-white">Please Enter Inventory For This location</h6>
                </div>
            </div>  
        @endif
            <!-- Submit Button -->
        

            </form>




<!-- second if close -->
            @endif




            








            <!-- first if end and else stat -->
           @else
           <div class="border-box mb-4" id="search-results">
                <!-- Header Title -->
                <div class="grid-header text-center">
                    <h6 class="m-0 text-white">Please Select Location First</h6>
                </div>
            </div>    
            <!-- first if end and else ens -->
           @endif

        </div>
    </div>
    <!-- Delete Confirmation Popup -->
    <div id="confirmPopup" class="confirm-popup-container">
        <div class="confirm-popup-content">
            <h4 class="confirm-popup-title">ALERT!</h4>
            <p class="confirm-popup-text">Quantity is required</p>
            <div class="d-flex justify-content-around mt-4 confrm">
                <button id="confirmDelete" class="btn">Okay</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('location_selected').addEventListener('change', function() {
        var locationId= this.value;
        if(locationId !='')
        {
            document.getElementById('locationForm').submit();
        }
    });
</script>

<!-- <script>
    document.getElementById('location_selected').addEventListener('change', function() {
        document.getElementById('locationForm').submit();
    });
</script> -->

<!-- <script>
 $(document).ready(function() {
  $('#location_selected').on('change', function() {
    var locationId = $(this).val(); // Get the location ID from the button
    // alert(locationId);
    $.ajax({
      url: '{{ route('get-location-wise-inventory') }}', // Your route to fetch the location data
      type: 'GET',
      data: {
                locationId: locationId
            },
      success: function(response) {
        var searchResultsContainer = $('#search-results');
        searchResultsContainer.empty(); // Clear previous results

        $.each(response, function(category, items) {
                    var borderBox = `
                        <div class="border-box">
                            <div class="grid-header text-center">
                                <h6 class="m-0 text-white">${category}</h6>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead class="table-header">
                                        <tr>
                                            <th>Item</th>
                                            <th>Qty</th>
                                            <th>Unit</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;

                    $.each(items, function(index, item) {
                        borderBox += `
                            <tr>
                                <td>${item.item_name}</td>
                                <td>
                                    <input type="text" name="quantity" class="form-control qty-input" />
                                </td>
                                <td>${item.unit_name}</td>
                                <td>$${item.price}</td>
                            </tr>`;
                    });

                    borderBox += `</tbody></table></div></div>`;
                    searchResultsContainer.append(borderBox);
                });
      },
      error: function() {
        alert('Failed to load location data.');
      }
    });
  });
});
</script>  -->
@extends('layouts.footer')
