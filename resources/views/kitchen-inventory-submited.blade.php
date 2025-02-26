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
            <h5 class="sub-title">Submitted Shopping List</h5>
            <a href="#">
          
            </a>
        </div>
    </div>
    <div class="filter">
        <div class="shopping-list-row d-flex align-items-center p-3">
            <!-- Search Input -->
            <div class="input-group search-input">
                <input type="text" class="form-control" placeholder="Search..." aria-label="Search"
                    id="search-query" />
                <button class="btn btn-srh" type="button">
                    <i class="bi bi-search"></i>
                </button>
            </div>

       
        </div>
        <div class="container-fluid px-3">
            @if(session()->get( 'user_role') == 1)
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
            @endif


            @if (session()->get('location_selected_id') != '')
              
                    @if (!empty($data_location_wise_inventory) && count($data_location_wise_inventory) > 0)
                        <div class="border-box mb-4" id="search-results">
                            @php 
                                $finalPrice = 0;
                            @endphp
                            @foreach ($data_location_wise_inventory as $category => $items)
                                <!-- Border Box -->

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
                                                <th onclick="sortTable('sortableTable_{{ $loop->index }}', 0)"><b>Sr.
                                                        No. <i class="bi bi-arrow-up"
                                                            id="arrow-0-{{ $loop->index }}"></i></b></th>
                                                <th onclick="sortTable('sortableTable_{{ $loop->index }}', 1)">
                                                    <b>Master Qty <i class="bi bi-arrow-up"
                                                            id="arrow-1-{{ $loop->index }}"></i></b></th>
                                                <th onclick="sortTable('sortableTable_{{ $loop->index }}', 2)"><b>Item
                                                        Name<i class="bi bi-arrow-up"
                                                            id="arrow-1-{{ $loop->index }}"></i></b></th>
                                                <th onclick="sortTable('sortableTable_{{ $loop->index }}', 3)">
                                                    <b>Available Qty <i class="bi bi-arrow-up"
                                                            id="arrow-2-{{ $loop->index }}"></i></b></th>
                                                <th onclick="sortTable('sortableTable_{{ $loop->index }}', 4)"><b>Buy
                                                        Qty <i class="bi bi-arrow-up"
                                                            id="arrow-3-{{ $loop->index }}"></i></b></th>
                                                <th onclick="sortTable('sortableTable_{{ $loop->index }}', 5)">
                                                    <b>Price <i class="bi bi-arrow-up"
                                                            id="arrow-3-{{ $loop->index }}"></i></b></th>
                                            </tr>
                                        </thead>
                                        <!-- Table Body -->
                                        <tbody>
                                            @php $srNo = 1;
                                            $count= 0;
                                            @endphp
                                            @foreach ($items as $item)
                                                @php $buy_qty  = $item['master_quantity'] - $item['quantity']; @endphp
                                                <input type="hidden" class="form-control" name="master_inventory_id[]"
                                                    id="master_inventory_id" value="{{ $item['id'] }}" />
                                                @if ($buy_qty > 0)
                                                    <tr>
                                                        <td> {{ $srNo++ }} </td>
                                                        <td>{{ $item['master_quantity'] }}</td>
                                                        <td>{{ $item['item_name'] }}</td>
                                                        <td>{{ $item['quantity'] }} {{ $item['unit_name'] }}</td>
                                                        <td>
                                                            @if ($buy_qty > 0)
                                                                {{ $buy_qty }} {{ $item['unit_name'] }}
                                                            @else
                                                                {{ '0' }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @php
                                                                $count = $count + 1;
                                                                $finalPrice = $finalPrice + $buy_qty * $item['price'];
                                                            @endphp
                                                            {{ $buy_qty * $item['price'] }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            @if($count == 0)
                                            <tr >
                                                    <td colspan = "6">No items were found</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            @endforeach


                        </div>
                        @if($finalPrice > 0)
                        <div class="border-box mb-4" id="search-results">
                            <!-- Header Title -->
                            <div class="grid-header text-center">
                                <h6 class="m-0 text-white"> Total Price : $ {{ $finalPrice }}</h6>
                            </div>
                        </div>
                        @endif
                        
                    @else
                        <div class="border-box mb-4" id="search-results">
                            <!-- Header Title -->
                            <div class="grid-header text-center">
                                <h6 class="m-0 text-white">No Data Found</h6>
                            </div>
                        </div>
                    @endif
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
        var locationId = this.value;
        if (locationId != '') {
            document.getElementById('locationForm').submit();
        }

    });
</script>

<script>
    $(document).ready(function() {
        var originalData = $('#search-results').html();
        // Bind keyup event to the search input
        $('#search-query').on('keyup', function() {
            var query = $(this).val().trim(); // Get the value entered in the search box

            if (query.length > 0) {
                $.ajax({
                    url: "{{ route('search-sopping-list') }}", // Define your search route here
                    method: "GET",
                    data: {
                        query: query
                    },
                    success: function(response) {
                        console.log('pppppppppppppppp', response);

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

@extends('layouts.footer')
