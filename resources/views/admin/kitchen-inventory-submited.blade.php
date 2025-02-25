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
            <!-- <a href="#">
                <button type="button" class="btn btn-outline-danger fs-6">
                    Show last submitted Kitchen list
                </button>
            </a> -->
            @if (is_array(session('location_for_user')) && count(session('location_for_user')) > 0)
                <form id="locationForm" method="post" action="{{ route('location-selected-admin') }}">
                    @csrf
                    <div class="row mb-3">
                        <label class="form-label col-md-6 col-sm-12 col-lg-6">Select Location</label>
                        <div class="col-md-6 col-sm-12 col-lg-6">
                            <select class="form-select" name="location_selected" id="location_selected">
                                <option value="">Select Location</option>
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


            @if(session()->get('location_selected_id') !='')
            <form action="{{ route('update-kitchen-inventory-by-admin') }}" id="updateKitchenInventory" method="POST">
            @csrf
            @if (!empty($data_location_wise_inventory) && count($data_location_wise_inventory) > 0)
            @foreach ($data_location_wise_inventory as $category => $items)
            <!-- Border Box -->
            <div class="border-box mb-4" id="search-results">
                <!-- Header Title -->
                <div class="grid-header text-center">
                    <h6 class="m-0 text-white">{{ $category }}</h6>
                </div>

                <!-- Table -->
                <div class="table-responsive" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
                    <table class="table table-striped" id="sortableTable_{{ $loop->index }}">
                        <!-- Table Head -->
                        <thead class="table-header">
                            <tr>
                                <th onclick="sortTable('sortableTable_{{ $loop->index }}', 0)"><b>Sr. No. <i class="bi bi-arrow-up" id="arrow-0-{{ $loop->index }}"></i></b></th>
                                <th onclick="sortTable('sortableTable_{{ $loop->index }}', 1)"><b>Item <i class="bi bi-arrow-up" id="arrow-1-{{ $loop->index }}"></i></b></th>
                                <th onclick="sortTable('sortableTable_{{ $loop->index }}', 2)"><b>Available Qty <i class="bi bi-arrow-up" id="arrow-2-{{ $loop->index }}"></i></b></th>
                                <th onclick="sortTable('sortableTable_{{ $loop->index }}', 3)"><b>Unit <i class="bi bi-arrow-up" id="arrow-3-{{ $loop->index }}"></i></b></th>
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
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
            <!-- <div class="text-center mt-3">
            <a type="submit" class="btn btn-success submitInventory">Submit Inventory</a>
        </div> -->
        @else
        <div class="border-box mb-4" id="search-results">
            <!-- Header Title -->
            <div class="grid-header text-center">
                <h6 class="m-0 text-white">No Data Found.</h6>
            </div>
        </div>  
        @endif
            <!-- Submit Button -->
        

            </form>
           @else
           <div class="border-box mb-4" id="search-results">
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
        // var locationId= ('#location_selected').val();
        var locationId= this.value;
        if(locationId !='')
    {
        document.getElementById('locationForm').submit();
    }
    });
</script>

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
      // const deleteButton = document.querySelector(".btn-delete");
      // const editButton = document.querySelector(".edit-btn");
      // const popup = document.getElementById("editPopup");
      const submitInventoryButton = document.querySelector(".submitInventory");
    //   const popupadd = document.getElementById("addPopup");
    //   // const confirmPopup = document.getElementById("confirmPopup");
    //   const cancelDeleteButton = document.getElementById("cancelDelete");
    //   // const confirmDeleteButton = document.getElementById("confirmDelete");

    //   const editButtonCategory = document.querySelector(".edit-btn-category");
    //   const popupcategory = document.getElementById("editPopupCategory");
    //   const deleteButtonCategory = document.querySelector(".btn-delete-category");
    //   const confirmPopupCategory = document.getElementById("confirmPopupCategory");
      const submitApproveButton = document.getElementById("submitApproveInventory");



    
      // // Open Popup
    //   addButton.addEventListener("click", () => {
    //     popupadd.style.display = "flex";
    //   });

      // Open Popup
      // editButton.addEventListener("click", () => {
      //   popup.style.display = "flex";
      // });
    
      // Close Popup when clicking outside
    //   popupcategory.addEventListener("click", (e) => {
    //     if (e.target === popupcategory) {
    //       popupcategory.style.display = "none";
    //     }
    //   });

    //   popupadd.addEventListener("click", (e) => {
    //     if (e.target === popupadd) {
    //       // document.getElementById("abc").value = '';
    //       document.getElementById("frm_register").reset();
    //       popupadd.style.display = "none";
          
    //     }
    //   });
    
      // Show Confirmation Popup
      // deleteButton.addEventListener("click", () => {
      //   popup.style.display = "none"; // Close the bottom popup
      //   confirmPopup.style.display = "flex"; // Show the confirmation popup
      // });

      submitInventoryButton.addEventListener("click", () => {
        // popupcategory.style.display = "none"; // Close the bottom popup
        confirmApprovePopup.style.display = "flex"; // Show the confirmation popup
      });
    
      // Close Confirmation Popup on Cancel
    //   cancelDeleteButton.addEventListener("click", () => {
    //     confirmPopupCategory.style.display = "none";
    //   });
    
      // Perform Action on Confirm Delete
      // confirmDeleteButton.addEventListener("click", () => {
      //   confirmPopup.style.display = "none";
      //           $("#delete_id").val($("#edit-location-id").val());
      //           $("#deleteform").submit();
      //   alert("User deleted successfully!");
      //   // Add delete logic here
      // });

      submitApproveButton.addEventListener("click", () => {
        confirmApprovePopup.style.display = "none";
                // $("#delete_id").val($("#edit-category-id").val());
                $("#updateKitchenInventory").submit();
        // alert("Category deleted successfully!");
        // Add delete logic here
      });
    });
 </script>

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
