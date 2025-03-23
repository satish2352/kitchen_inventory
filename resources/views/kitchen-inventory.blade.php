@include('layouts.header')
@include('layouts.sidebar')

@yield('content')

<style>
    .submit_inventory_css {
        margin-top: 12px;
    }

    @media screen and (max-width: 768px) {
        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        table {
            width: 100%;
            min-width: 600px;
            /* Adjust as per your table content */
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
            <h5 class="sub-title">Update Kitchen Inventory</h5>
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
            {{-- <div class="input-group search-input">
                <input type="text" class="form-control" placeholder="Search..." aria-label="Search"
                    id="search-query" />
                <button class="btn btn-srh" type="button">
                    <i class="bi bi-search"></i>
                </button>
            </div> --}}


        </div>
        <div class="container-fluid px-3">
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
            <!-- first if start -->
            <div class="border-box mb-4" id="search-results">
                @if (session()->get('location_selected_id') != '')
                    @if ($InventoryData['DataType'] == 'MasterData')
                        <form action="{{ route('add-kitchen-inventory-by-sa') }}" id="frm_register_add" method="POST">
                            @csrf

                            @if (!empty($InventoryData['data_location_wise_inventory']) && count($InventoryData['data_location_wise_inventory']) > 0)
                                @foreach ($InventoryData['data_location_wise_inventory'] as $category => $items)
                                    <div class="grid-header text-center">
                                        <h6 class="m-0 text-white">{{ $category }}</h6>
                                    </div>

                                    <div class="table-responsive"
                                        style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
                                        <table class="table table-striped" id="sortableTable_{{ $loop->index }}">
                                            <!-- Table Head -->
                                            <thead class="table-header">
                                                <tr>
                                                    <!-- <th onclick="sortTable('sortableTable_{{ $loop->index }}', 0)">
                                                        <b>Sr. No. <i class="bi bi-arrow-up"
                                                                id="arrow-0-{{ $loop->index }}"></i></b>
                                                    </th>
                                                    <th onclick="sortTable('sortableTable_{{ $loop->index }}', 1)">
                                                        <b>Req. Qty For This Location <i class="bi bi-arrow-up"
                                                                id="arrow-1-{{ $loop->index }}"></i></b> -->
                                                    </th>
                                                    <th onclick="sortTable('sortableTable_{{ $loop->index }}', 2)">
                                                        <b>Item <i class="bi bi-arrow-up"
                                                                id="arrow-2-{{ $loop->index }}"></i></b>
                                                    </th>
                                                    <th onclick="sortTable('sortableTable_{{ $loop->index }}', 3)">
                                                        <b>Available Qty <i class="bi bi-arrow-up"
                                                                id="arrow-3-{{ $loop->index }}"></i></b>
                                                    </th>
                                                    <th onclick="sortTable('sortableTable_{{ $loop->index }}', 4)">
                                                        <b>Unit <i class="bi bi-arrow-up"
                                                                id="arrow-4-{{ $loop->index }}"></i></b>
                                                    </th>
                                                    <!-- <th><b>Price</b></th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $srNo = 1; @endphp
                                                @foreach ($items as $item)
                                                    <input type="hidden" class="form-control"
                                                        name="master_inventory_id[]" id="master_inventory_id"
                                                        value="{{ $item['id'] }}" />

                                                    <input type="hidden" class="form-control"
                                                        name="master_quantity[]" id="master_quantity"
                                                        value="{{ $item['masterQuantity'] }}" />

                                                    <input type="hidden" class="form-control"
                                                        name="master_price[]" id="master_price"
                                                        value="{{ $item['price'] }}" />

                                                    <input type="hidden" class="form-control"
                                                        name="category_name[]" id="category_name"
                                                        value="{{ $item['category_name'] }}" />

                                                    <input type="hidden" class="form-control"
                                                        name="unit_name[]" id="unit_name"
                                                        value="{{ $item['unit_name'] }}" />

                                                    <input type="hidden" class="form-control"
                                                        name="item_name[]" id="item_name"
                                                        value="{{ $item['item_name'] }}" />

                                                    <tr>
                                                        <!-- <td> {{ $srNo++ }} </td>
                                                        <td>{{ $item['masterQuantity'] }}</td> -->
                                                        <td>{{ $item['item_name'] }}</td>
                                                        <td>
                                                            <input type="text" name="quantity[]"
                                                                class="form-control qty-input-add"
                                                                style="text-align: center;" placeholder="QTY"
                                                                inputmode="decimal" pattern="[0-9]+(\.[0-9]+)?"
                                                                onkeypress="return isNumberKey(event)">
                                                            <span class="error-message text-danger"></span>
                                                        </td>
                                                        <td>{{ $item['unit_name'] }}</td>
                                                        <!-- <td>{{ $item['price'] }}</td>   -->
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endforeach
                                <div class="text-center submit_inventory_css">
                                    <button type="submit" class="btn btn-success">Submit Inventory</button>
                                </div>
                            @else
                                <div class="border-box mb-4" id="search-results">
                                    <!-- Header Title -->
                                    <div class="grid-header text-center">
                                        <h6 class="m-0 text-white">Please Add Inventory For This location</h6>
                                    </div>
                                </div>
                            @endif
                        </form>

                        <!-- second if end and else start -->
                    @elseif($InventoryData['DataType'] == 'LocationWiseData')
                        <form action="{{ route('update-kitchen-inventory-by-super-admin') }}" id="frm_register_edit"
                            method="POST">
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
                                        <div class="table-responsive"
                                            style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
                                            <table class="table table-striped" id="sortableTable_{{ $loop->index }}">
                                                <!-- Table Head -->
                                                <thead class="table-header">
                                                    <tr>
                                                        <!-- <th
                                                            onclick="sortTable('sortableTable_{{ $loop->index }}', 0)">
                                                            <b>Sr. No.
                                                                <i class="bi bi-arrow-up"
                                                                    id="arrow-0-{{ $loop->index }}"></i></b></th>
                                                        <th
                                                            onclick="sortTable('sortableTable_{{ $loop->index }}', 1)">
                                                            <b>Req.
                                                                Qty For This Location <i class="bi bi-arrow-up"
                                                                    id="arrow-1-{{ $loop->index }}"></i></b></th> -->
                                                        <th
                                                            onclick="sortTable('sortableTable_{{ $loop->index }}', 2)">
                                                            <b>Item <i class="bi bi-arrow-up"
                                                                    id="arrow-2-{{ $loop->index }}"></i></b></th>
                                                        <th
                                                            onclick="sortTable('sortableTable_{{ $loop->index }}', 3)">
                                                            <b>Available Qty <i class="bi bi-arrow-up"
                                                                    id="arrow-3-{{ $loop->index }}"></i></b>
                                                        </th>
                                                        <th
                                                            onclick="sortTable('sortableTable_{{ $loop->index }}', 4)">
                                                            <b>Unit <i class="bi bi-arrow-up"
                                                                    id="arrow-4-{{ $loop->index }}"></i></b></th>
                                                        <!-- <th><b>Price</b></th> -->
                                                    </tr>
                                                </thead>
                                                <!-- Table Body -->
                                                <tbody>
                                                    @php $srNo = 1; @endphp
                                                    @foreach ($items as $item)
                                                    
                                                        <input type="hidden" class="form-control"
                                                            name="location_wise_inventory_id[]"
                                                            id="location_wise_inventory_id"
                                                            value="{{ $item['locationWiseId'] }}" />
                                                        <input type="hidden" class="form-control"
                                                            name="master_inventory_id[]" id="master_inventory_id"
                                                            value="{{ $item['masterInventoryId'] }}" />


                                                        <input type="hidden" class="form-control"
                                                            name="master_quantity[]" id="master_quantity"
                                                            value="{{ $item['masterQuantity'] }}" />

                                                        <input type="hidden" class="form-control"
                                                            name="master_price[]" id="master_price"
                                                            value="{{ $item['price'] }}" />

                                                        <input type="hidden" class="form-control"
                                                            name="category_name[]" id="category_name"
                                                            value="{{ $item['category_name'] }}" />

                                                        <input type="hidden" class="form-control"
                                                            name="unit_name[]" id="unit_name"
                                                            value="{{ $item['unit_name'] }}" />

                                                        <input type="hidden" class="form-control"
                                                            name="item_name[]" id="item_name"
                                                            value="{{ $item['item_name'] }}" />

                                                        <tr>
                                                            <!-- <td> {{ $srNo++ }} </td>
                                                            <td>{{ $item['masterQuantity'] }}</td> -->
                                                            <td>{{ $item['item_name'] }}</td>
                                                            <td>
                                                                <!-- <input type="text" name="quantity[]" class="form-control qty-input-edit" style="text-align: center;" value="{{ $item['quantity'] }}"  placeholder="QTY" min="1" max="5"/> -->
                                                                <input type="text" name="quantity[]"
                                                                    class="form-control qty-input-edit"
                                                                    value="{{ $item['quantity'] }}"
                                                                    style="text-align: center;" placeholder="QTY"
                                                                    inputmode="decimal" pattern="[0-9]+(\.[0-9]+)?"
                                                                    onkeypress="return isNumberKey(event)">
                                                                <span class="error-message text-danger"></span>
                                                            </td>
                                                            <td>{{ $item['unit_name'] }}</td>
                                                            <!-- <td>{{ $item['price'] }}</td> -->
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="text-center submit_inventory_css">
                                    <button type="submit" class="btn btn-success">Update Inventory</button>
                                </div>
                            @else
                                <div class="border-box mb-4" id="search-results">
                                    <!-- Header Title -->
                                    <div class="grid-header text-center">
                                        <h6 class="m-0 text-white">Please Add Inventory For This location</h6>
                                    </div>
                                </div>
                            @endif
                        </form>
                    @endif
                @else
                    <div class="border-box mb-4" id="search-results">
                        <!-- Header Title -->
                        <div class="grid-header text-center">
                            <h6 class="m-0 text-white">Please Select Location First</h6>
                        </div>

                @endif
            </div>
            <!-- first if end and else ens -->
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
        var locationId = this.value;
        if (locationId != '') {
            document.getElementById('locationForm').submit();
        }
    });
</script>
@extends('layouts.footer')

<script>
  $(document).ready(function() {
    $("#frm_register_add").on("submit", function(e) {
        let isValid = true;
        showLoader();
        $("button[type='submit']").prop("disabled", true); 

        // Loop through each quantity[] field and validate
        $(".qty-input-add").each(function() {
            let quantity = $(this).val().trim();
            let errorSpan = $(this).siblings(".error-message");

            // Check if quantity is valid
            if (quantity === "" || isNaN(quantity)) {
                errorSpan.text("Please enter a valid quantity.");
                isValid = false;
                hideLoader();
            } else {
                errorSpan.text(""); // Clear the error message
            }
        });

        if (!isValid) {
            e.preventDefault();
            $("button[type='submit']").prop("disabled", false);
        }
        
    });

    $(".qty-input-add").on("input", function() {
        let quantity = $(this).val().trim();
        let errorSpan = $(this).siblings(".error-message");

        if (quantity === "" || isNaN(quantity)) {
                hideLoader();
                errorSpan.text("Please enter a valid quantity.");
                isValid = false;
            } else if (quantity.length > 5) {
                hideLoader();
                errorSpan.text("Quantity cannot be more than 5 digits.");
                isValid = false;
            } else {
                errorSpan.text(""); 
            }
    });
});

</script>

<script>
$(document).ready(function() {
    $("#frm_register_edit").on("submit", function(e) {
        let isValid = true;
        showLoader();
        $("button[type='submit']").prop("disabled", true); // Disable button
        
        $(".qty-input-edit").each(function() {
            let quantity = $(this).val().trim();
            let errorSpan = $(this).siblings(".error-message");
            if (quantity === "" || isNaN(quantity)) {
                hideLoader();
                errorSpan.text("Please enter a valid quantity");
                isValid = false;
            } else if (quantity.length > 5) {
                hideLoader();
                errorSpan.text("Quantity cannot be more than 5 digits.");
                isValid = false;
            } else {
                errorSpan.text(""); 
            }
        });

        if (!isValid) {
            e.preventDefault();
            $("button[type='submit']").prop("disabled", false); // Re-enable if validation fails
        }
    });

    // Clear error when user starts typing
    $(".qty-input-edit").on("input", function() {
        let quantity = $(this).val().trim();
        let errorSpan = $(this).siblings(".error-message");

        if (quantity !== "" && !isNaN(quantity)) {
            if (quantity.length > 5) {
                errorSpan.text("Quantity cannot be more than 5 digits.");
            } else {
                errorSpan.text(""); // Clear error message
            }
        } else {
            errorSpan.text(""); // Clear error message if input is empty
        }
    });
});
</script>

<script>
    $(document).ready(function() {
        
        var originalData = $('#search-results').html();
        // Bind keyup event to the search input
        $('#search-query').on('keyup', function() {
            showLoader();
            var query = $(this).val().trim(); // Get the value entered in the search box

            if (query.length > 0) {
                $.ajax({
                    url: "{{ route('search-update-kitchen-inventory-super-admin') }}", // Define your search route here
                    method: "GET",
                    data: {
                        query: query
                    },
                    success: function(response) {
                        if (response.length > 0) {
                            $('#search-results').html('');
                            $('#search-results').html(response);
                            hideLoader();
                        } else {
                            $('#search-results').html('No Data Found');
                            hideLoader();
                        }
                    }
                });
            } else {
                $('#search-results').html(originalData);
                hideLoader();
            }
        });
    });
</script>

<script>
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>


<script>
    // Store sort directions for each table by its ID
    var sortDirections = {};

    function sortTable(tableId, columnIndex) {
        var table = document.getElementById(tableId);
        var tbody = table.querySelector('tbody');
        var rows = Array.from(tbody.querySelectorAll('tr'));

        // Initialize sort directions for the table if not set yet
        if (!sortDirections[tableId]) {
            // Assuming 5 sortable columns
            sortDirections[tableId] = [true, true, true, true, true];
        }
        var ascending = sortDirections[tableId][columnIndex];

        rows.sort(function(rowA, rowB) {
            var cellA = rowA.getElementsByTagName('td')[columnIndex].innerText.trim();
            var cellB = rowB.getElementsByTagName('td')[columnIndex].innerText.trim();

            // Check if numeric sort
            if (!isNaN(parseFloat(cellA)) && !isNaN(parseFloat(cellB))) {
                return ascending ? cellA - cellB : cellB - cellA;
            }
            // Otherwise, do text sort
            return ascending ? cellA.localeCompare(cellB) : cellB.localeCompare(cellA);
        });

        // Clear and re-append sorted rows
        tbody.innerHTML = '';
        rows.forEach(function(row) {
            tbody.appendChild(row);
        });

        // Toggle sort direction for this column in this table
        sortDirections[tableId][columnIndex] = !ascending;
        updateArrows(tableId, columnIndex, ascending);
    }

    function updateArrows(tableId, columnIndex, ascending) {
        var table = document.getElementById(tableId);
        // Reset all arrow icons in the table header
        var headerIcons = table.querySelectorAll('thead th i');
        headerIcons.forEach(function(icon) {
            icon.classList.remove('bi-arrow-up', 'bi-arrow-down');
            icon.classList.add('bi-arrow-up');
        });

        // Extract unique table index from the tableId (assuming format sortableTable_INDEX)
        var parts = tableId.split('_');
        var tableIndex = parts[1];
        var arrowId = 'arrow-' + columnIndex + '-' + tableIndex;
        var arrow = document.getElementById(arrowId);
        if (arrow) {
            arrow.classList.toggle('bi-arrow-up', ascending);
            arrow.classList.toggle('bi-arrow-down', !ascending);
        }
    }
</script>
