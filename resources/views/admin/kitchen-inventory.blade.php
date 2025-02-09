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
            <a href="approve-users.html">
                <!-- <button class="btn btn-light">
                    <i class="bi bi-check2"></i>
                </button> -->
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

            <form action="{{ route('add-kitchen-inventory-by-admin') }}" method="POST">
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
                                <th><b>Item</b></th>
                                <th><b>Qty</b></th>
                                <th><b>Unit</b></th>
                                <th><b>Price</b></th>
                            </tr>
                        </thead>
                        <!-- Table Body -->
                        <tbody>
                            @php $srNo = 1; @endphp
                            @foreach ($items as $item)
                            <input type="hidden" class="form-control" name="master_inventory_id[]" id="master_inventory_id" value="{{ $item['id'] }}"/>

                                <tr>
                                <td> {{ $srNo++ }} </td>
                                    <td>{{ $item['item_name'] }}</td>
                                    <td>
                                        <input type="text" name="quantity[]" class="form-control qty-input" placeholder="QTY" style="justify-self: center;">
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
                    <h6 class="m-0 text-white">No List Found For Kitchen Inventory. Please Contact To Super Admin</h6>
                </div>
            </div>  
        @endif
            <!-- Submit Button -->
        

            </form>


            <!-- second if end and else start -->
            @elseif($InventoryData['DataType']=='LocationWiseData')
            <form action="{{ route('update-kitchen-inventory-by-admin') }}" method="POST">
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
                                <th><b>Item</b></th>
                                <th><b>Qty</b></th>
                                <th><b>Unit</b></th>
                                <th><b>Price</b></th>
                            </tr>
                        </thead>
                        <!-- Table Body -->
                        <tbody>
                        @php $srNo = 1; @endphp
                            @foreach ($items as $item)
                            <input type="hidden" class="form-control" name="location_wise_inventory_id[]" id="location_wise_inventory_id" value="{{ $item['locationWiseId'] }}"/>
                            <!-- <input type="hidden" class="form-control" name="master_inventory_id[]" id="master_inventory_id" value="{{ $item['id'] }}"/> -->

                                <tr>
                                    <td> {{ $srNo++ }} </td>
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

@extends('layouts.footer')
<script>
$(document).ready(function () {
    $("#locationForm").submit(function (e) {
        let isValid = true; // Assume the form is valid initially

        $(".qty-input").each(function () {
            let value = $(this).val().trim();
            
            if (value === "" || isNaN(value) || parseFloat(value) <= 0) {
                isValid = false;
                $(this).addClass("is-invalid"); // Add Bootstrap invalid class for styling
                $(this).after('<span class="error text-danger">Please enter a valid quantity.</span>');
            } else {
                $(this).removeClass("is-invalid");
                $(this).next(".error").remove(); // Remove error message if input is valid
            }
        });

        if (!isValid) {
            e.preventDefault(); // Prevent form submission if validation fails
        }
    });

    // Remove error message when user starts typing
    $(document).on("input", ".qty-input", function () {
        $(this).removeClass("is-invalid");
        $(this).next(".error").remove();
    });
});
</script>