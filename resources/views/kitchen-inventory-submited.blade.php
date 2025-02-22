@include('layouts.header')
@include('layouts.sidebar')

@yield('content')

<style>
    @media screen and (max-width: 768px) {
    .table-responsive {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    table {
        width: 100%;
        min-width: 600px; /* Adjust as per your table content */
    }
}
</style>
<div class="main">
    <div class="inner-top container-fluid p-3">
        <!-- Top Bar -->
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('/dashboard') }}">
                <button class="btn btn-light">
                    <i class="bi bi-arrow-90deg-left"></i>
                </button>
            </a>
            <h5 class="sub-title">Submit Shopping List</h5>
            <a href="#">
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
                <input type="text" class="form-control" placeholder="Search..." aria-label="Search"  id="search-query"/>
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
            <!-- <a href="#">
                <button type="button" class="btn btn-outline-danger fs-6">
                    Show last submitted Kitchen list
                </button>
            </a> -->
                <form id="locationForm" method="post" action="{{ route('location-selected-admin') }}">
                    @csrf
                    <div class="row mb-3">
                        <label class="form-label col-md-6 col-sm-12 col-lg-6">Select Location</label>
                        <div class="col-md-6 col-sm-12 col-lg-6">
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


            @if(session()->get('location_selected_id') !='')
            <form action="{{ route('update-kitchen-inventory-by-admin') }}" id="updateKitchenInventory" method="POST">
            @csrf
            @if (!empty($data_location_wise_inventory) && count($data_location_wise_inventory) > 0)
            <div class="border-box mb-4" id="search-results">
            @foreach ($data_location_wise_inventory as $category => $items)
            <!-- Border Box -->
            
                <!-- Header Title -->
                <div class="grid-header text-center">
                    <h6 class="m-0 text-white">{{ $category }}</h6>
                </div>

                <!-- Table -->
                <div class="table-responsive" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
                    <table class="table table-striped">
                        <!-- Table Head -->
                        <thead class="table-header">
                            <tr>
                                <th><b>Sr. No.</b></th>
                                <th><b>Item</b></th>
                                <th><b>Available Qty</b></th>
                                <th><b>Unit</b></th>
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
                                    <td>{{ $item['quantity'] }}</td>
                                    <!-- <td>
                                        <input type="text" name="quantity[]" class="form-control qty-input" value="{{ $item['quantity'] }}" placeholder="QTY" />
                                    </td> -->
                                    <td>{{ $item['unit_name'] }}</td>
                                    
                                </tr>
                            @endforeach
                            <tr>
                        </tbody>
                    </table>
                </div>
            
            @endforeach
            </div>
            <!-- <div class="text-center mt-3">
            <a type="submit" class="btn btn-success submitInventory">Submit Inventory</a>
        </div> -->
        @else
            <div class="border-box mb-4" id="search-results">
                <!-- Header Title -->
                <div class="grid-header text-center">
                    <h6 class="m-0 text-white">No Data Found</h6>
                </div>
            </div>  
        @endif
            <!-- Submit Button -->
        

            </form>
           @else
           <div class="border-box mb-4">
                <!-- Header Title -->
                <div class="grid-header text-center">
                    <h6 class="m-0 text-white">Please Select Location First</h6>
                </div>
            </div>    
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

    <!-- Delete Confirmation Popup -->
    <div id="confirmApprovePopup" class="confirm-popup-container">
        <div class="confirm-popup-content">
          <h4 class="confirm-popup-title">Please Confirm</h4>
          <p class="confirm-popup-text">
            Are you sure to Approve this Inventory? <br />
            <!-- this Category wil not recover back -->
          </p>
          <div class="d-flex justify-content-around mt-4 confrm">
            <button id="cancelDelete" class="btn br">NO</button>
            <button id="submitApproveInventory" class="btn">YES</button>
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
   $(document).ready(function() {
     var originalData = $('#search-results').html();
       // Bind keyup event to the search input
       $('#search-query').on('keyup', function() {
           var query = $(this).val().trim();  // Get the value entered in the search box
   
           if (query.length > 0) {
               $.ajax({
                   url: "{{ route('search-sopping-list') }}",  // Define your search route here
                   method: "GET",
                   data: { query: query },
                   success: function(response) {
                    console.log('pppppppppppppppp',response);
                    
                        if (response.length > 0) {
                            // Clear the previous results
                            $('#search-results').html('');

                            // Append the new search results
                            $('#search-results').html(response);
                        } else {
                            $('#search-results').html(`<div class="border-box mb-4" id="search-results">
                <!-- Header Title -->
                <div class="grid-header text-center">
                    <h6 class="m-0 text-white">No Data Found</h6>
                </div>
            </div> `);
                        }
                    }
               });
           } else {
               // Clear the results if input is empty
               // $('#search-results').html('');
               $('#search-results').html(originalData);
           }
       });
   });
</script>

@extends('layouts.footer')
