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
            <h5 class="sub-title">Update Kitchen Inventory</h5>
            <a href="#">
                
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
            <!-- <button class="btn btn-white mx-2">
                <i class="bi bi-geo-alt-fill"></i>
            </button> -->

            <!-- Bar Grid Icon -->
            <!-- <button class="btn btn-white btn-delete">
                <i class="bi bi-filter"></i>
            </button> -->
        </div>
        <div class="container-fluid px-3">
            <a href="#">
                <button type="button" class="btn btn-outline-danger fs-6">
                    Show last submitted Kitchen list
                </button>
            </a>
            @if (is_array(session('location_for_user')) && count(session('location_for_user')) > 0)
                <form id="locationForm" method="post" action="{{ route('location_selected') }}">
                    @csrf
                    <div class="row mb-3">
                        <label class="form-label col-6">Select Location</label>
                        <div class="col-6">
                            <select class="form-select" name="location_selected" id="location_selected">
                                <option value="" selected disaled>Select Location</option>
                                @foreach (session('location_for_user') as $locations)
                                    <option value="{{ $locations['id'] }}"
                                        @if (session('location_selected') == $locations['id']) selected @endif>{{ $locations['location'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            @endif

<!-- first if start -->
            @if(session()->get('location_selected_id') !='')
            <!-- <?php //print_r($InventoryData); die;?> -->
            <!-- second if start -->
            @if($InventoryData['DataType']=='MasterData')

            <form action="{{ route('add-kitchen-inventory-by-manager') }}"id="frm_register_add" method="POST">
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
                                <th><b>Sr. No.</b></th>
                                <th><b>Req. Qty For This Location </b></th>
                                <th><b>Item</b></th>
                                <th><b>Available Qty</b></th>
                                <th><b>Unit</b></th>
                                <!-- <th>Price</th> -->
                            </tr>
                        </thead>
                        <!-- Table Body -->
                        <tbody>
                        @php $srNo = 1; @endphp
                            @foreach ($items as $item)
                            <input type="hidden" class="form-control" name="master_inventory_id[]" id="master_inventory_id" value="{{ $item['id'] }}"/>

                                <tr>
                                    <td>{{ $srNo++ }}</td>
                                    <td>{{ $item['masterQuantity'] }}</td>
                                    <td>{{ $item['item_name'] }}</td>
                                    <td>
                                        <input type="text" name="quantity[]" class="form-control qty-input-add" style="text-align: center;"   placeholder="QTY" />
                                        <span class="error-message text-danger"></span>
                                    
                                    </td>
                                    <td>{{ $item['unit_name'] }}</td>
                                    <!-- <td>{{ $item['price'] }}</td> -->
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
                    <h6 class="m-0 text-white">No List Found For Kitchen Inventory. Please Contact To Super Admin</h6>
                </div>
            </div>  
        @endif
            <!-- Submit Button -->
        

            </form>


            <!-- second if end and else start -->
            @elseif($InventoryData['DataType']=='LocationWiseData')
            <form action="{{ route('update-kitchen-inventory-by-manager') }}" id="frm_register_edit" method="POST">
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
                            <th><b>Sr. No.</b></th>
                                <th><b>Req. Qty For This Location</b></th>
                                <th><b>Item</b></th>
                                <th><b>Available Qty</b></th>
                                <th><b>Unit</b></th>
                            </tr>
                        </thead>
                        <!-- Table Body -->
                        <tbody>
                        @php $srNo = 1; @endphp
                            @foreach ($items as $item)
                            <input type="hidden" class="form-control" name="location_wise_inventory_id[]" id="location_wise_inventory_id" value="{{ $item['locationWiseId'] }}"/>
                            <input type="hidden" class="form-control" name="master_inventory_id[]" id="master_inventory_id" value="{{ $item['masterInventoryId'] }}"/>

                                <tr>
                                    <td>{{ $srNo++ }}</td>
                                    <td>{{ $item['masterQuantity'] }}</td>
                                    <td>{{ $item['item_name'] }}</td>
                                    <td>
                                        <input type="text" name="quantity[]" class="form-control qty-input-edit" style="text-align: center;" value="{{ $item['quantity'] }}"  placeholder="QTY" />
                                        <span class="error-message text-danger"></span>
                                    
                                    </td>
                                    <td>{{ $item['unit_name'] }}</td>
                                    <!-- <td>{{ $item['price'] }}</td> -->
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
                    <h6 class="m-0 text-white">No List Found For Kitchen Inventory. Please Contact To Super Admin</h6>
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

<script>
    $(document).ready(function () {
        $("#frm_register_add").on("submit", function (e) {
            let isValid = true;

            // Loop through each quantity[] field and validate
            $(".qty-input-add").each(function () {
                let quantity = $(this).val().trim();
                let errorSpan = $(this).siblings(".error-message");
                let masterQuantity = parseFloat($(this).closest("tr").find("td:nth-child(2)").text().trim()) || 0; // Getting masterQuantity

                if (quantity === "" || isNaN(quantity) || parseFloat(quantity) <= 0) {
                    errorSpan.text("Please enter a valid quantity (greater than 0).");
                    isValid = false;
                } else if (quantity.length > 5) {
                    errorSpan.text("Quantity cannot be more than 5 digits.");
                    isValid = false;
                } else if (parseFloat(quantity) > masterQuantity) {
                    errorSpan.text("Entered quantity cannot exceed required quantity!");
                    isValid = false;
                } else {
                    errorSpan.text(""); // Clear the error message
                }
            });

            if (!isValid) {
                e.preventDefault(); // Prevent form submission if validation fails
            }
        });

         // Clear error when user starts typing
         $(".qty-input-add").on("input", function () {
            let quantity = $(this).val().trim();
            let errorSpan = $(this).siblings(".error-message");

            if (quantity !== "" && !isNaN(quantity)) {
                if (quantity.length > 5) {
                    errorSpan.text("Quantity cannot be more than 5 digits.");
                } else {
                    errorSpan.text(""); // Clear the error message
                }
            }
        });
    });
</script>


<script>
    $(document).ready(function () {
        $("#frm_register_edit").on("submit", function (e) {
            let isValid = true;

            // Loop through each quantity[] field and validate
            $(".qty-input-edit").each(function () {
                let quantity = $(this).val().trim();
                let errorSpan = $(this).siblings(".error-message");
                let masterQuantity = parseFloat($(this).closest("tr").find("td:nth-child(2)").text().trim()) || 0; // Getting masterQuantity

                if (quantity === "" || isNaN(quantity) || parseFloat(quantity) <= 0) {
                    errorSpan.text("Please enter a valid quantity (greater than 0).");
                    isValid = false;
                } else if (quantity.length > 5) {
                    errorSpan.text("Quantity cannot be more than 5 digits.");
                    isValid = false;
                } else if (parseFloat(quantity) > masterQuantity) {
                    errorSpan.text("Entered quantity cannot exceed required quantity!");
                    isValid = false;
                } else {
                    errorSpan.text(""); // Clear the error message
                }
            });

            if (!isValid) {
                e.preventDefault(); // Prevent form submission if validation fails
            }
        });

        // Clear error when user starts typing
        $(".qty-input-edit").on("input", function () {
            $(this).siblings(".error-message").text("");
        });
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
