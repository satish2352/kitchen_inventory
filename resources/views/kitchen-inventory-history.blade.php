@include('layouts.header')
@include('layouts.sidebar')

@yield('content')

<style>
  @media (max-width: 410px) {
    .sub-title {
      margin-left: 10px 
    }
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
        min-width: 600px; /* Adjust as per your table content */
    }
}

.copy_inventory_css{
  background-color: lightgrey;
  border: 1px solid lightgrey;
}
</style>
<!-- <style>
    /* Custom styling for select dropdown */
    .select2-dropdown {
        max-height: 200px !important; /* Set a max height */
        overflow-y: auto !important; /* Enable scrolling */
    }
</style> -->

<div class="main">
      <div class="inner-top container-fluid p-3">
        <!-- Top Bar -->
        <div class="d-flex justify-content-between align-items-center">
          <a href="{{ route('/dashboard') }}">
            <button class="btn btn-light">
              <i class="bi bi-arrow-90deg-left"></i>
            </button>
          </a>
          <h5 class="sub-title">Inventory History Details</h5>

          <button class="btn btn-light add-btn copy_inventory_css">
                  Search History
                </button>
        </div>
      </div>
<!-- 
      @if(session('alert_status'))
    <p>Session Status: {{ session('alert_status') }}</p>
    <p>Session Message: {{ session('alert_msg') }}</p>
@endif -->
      <div class="filter">
        <div class="shopping-list-row d-flex align-items-center p-3">
          <!-- Search Input -->
           <!-- Search Input -->
           <!-- <div class="input-group search-input">
              <input
                  type="text"
                  class="form-control"
                  placeholder="Search..."
                  aria-label="Search"
                  id="search-query"/>
              <button class="btn btn-srh" type="button">
                  <i class="bi bi-search"></i>
              </button>
          </div> -->

        </div>
      </div>
      

      <div class="container-fluid px-3" id="search-results">


        @if (!empty($user_data) && count($user_data) > 0)
        
        <div class="row">
            <div class="col-md-6">
                <span><b>Location</b> : {{ $LocationName }} </span>
            </div>
            <div class="col-md-6">
                <span><b>Date</b> : {{ date('d-m-Y', strtotime($DateValData)) }} </span>
            </div>
        </div>
       
        @foreach ($user_data as $category => $items)

      
        <!-- Border Box -->
        <div class="border-box">
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
                    <th onclick="sortTable('sortableTable_{{ $loop->index }}', 1)"><b>Item  <i class="bi bi-arrow-up" id="arrow-1-{{ $loop->index }}"></i></b></th>
                    <th onclick="sortTable('sortableTable_{{ $loop->index }}', 2)"><b>Available Qty  <i class="bi bi-arrow-up" id="arrow-2-{{ $loop->index }}"></i></b></th>
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

        @else
        <div class="border-box mb-4" id="search-results">
                <!-- Header Title -->
                <div class="grid-header text-center">
                    <h6 class="m-0 text-white">No Data Found</h6>
                </div>
            </div>  
        @endif

       
      </div>


      <div id="addPopup" class="popup-container">
        <div class="popup-content">

        <form class="forms-sample" id="frm_register_add" name="frm_register" method="post" role="form"
          action="{{ route('search-master-kitchen-inventory-history') }}" enctype="multipart/form-data">
          <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
          <!-- Popup Title -->
          <h4 class="popup-title">Search Inventory History</h4>
          <hr />

                <div class="row mb-3">
                    <label class="col-md-6 col-sm-12 col-lg-6 form-label">Select Location</label>
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <select class="form-select select2" name="location_id"
                            data-placeholder="Select Location" id="locationSelect">
                            <option value="">Select Location</option>
                            @foreach ($locationsData as $locationItem)
                                <option value="{{ $locationItem['id'] }}">{{ $locationItem['location'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Date Picker Field -->
                <div class="row mb-3">
                    <label class="col-md-6 col-sm-12 col-lg-6 form-label">Select Date</label>
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <input type="date" class="form-control" name="inventory_date" id="datePicker" required />
                    </div>
                </div>


          <hr />
          <div class="d-flex justify-content-around">
          <a class="btn btn-secondary btn-lg w-100 me-2" id="closePopup">
              <i class="bi bi-x-circle"></i> Cancel
            </a>
            
            <button class="btn btn-danger btn-lg w-100" id="search-query-btn">
              <i class="bi bi-plus-lg"></i> Search
            </button>
          </div>
        </form>
        </div>
      </div>


      <!-- Delete Confirmation Popup -->
      <div id="confirmPopupDelete" class="confirm-popup-container">
        <div class="confirm-popup-content">
          <h4 class="confirm-popup-title">Please Confirm</h4>
          <p class="confirm-popup-text">
            Are you sure to delete this Inventory? <br />
            this Inventory will not recover back
          </p>
          <div class="d-flex justify-content-around mt-4 confrm">
            <button id="cancelDeleteConfirm" class="btn br">NO</button>
            <button id="confirmDeleteItem" class="btn">YES</button>
          </div>
        </div>
      </div>

    </div>


 @extends('layouts.footer')

 <script>
    document.getElementById('location_selected').addEventListener('change', function() {
        var locationId= this.value;
        if(locationId !='')
        {
            document.getElementById('locationForm').submit();
        }
    });
</script>

<script type="text/javascript">
      document.addEventListener("DOMContentLoaded", () => {
        const addButton = document.querySelector(".add-btn");
        const popupadd = document.getElementById("addPopup");
      const closePopUpButton = document.getElementById("closePopup");


        addButton.addEventListener("click", () => {
          popupadd.style.display = "flex";
        });

        // Close Popup when clicking outside
        popupadd.addEventListener("click", (e) => {
          if (e.target === popupadd) {
            document.getElementById("frm_register_add").reset();
             // Reset Select2 dropdowns manually
          $('.select2').val(null).trigger('change');
            popupadd.style.display = "none";
          }
        });

        // Close Popup
      closePopUpButton.addEventListener("click", () => {
        document.getElementById("frm_register_add").reset();

        // Reset Select2 dropdowns manually
          $('.select2').val(null).trigger('change');

          popupadd.style.display = "none";
      });

      });
</script>

<script type="text/javascript">
  $(document).ready(function () {

    // Initialize validation for the add form
    $("#frm_register_add").validate({
      rules: {
        location_id: {
          required: true
          // minlength: 3
        },
        inventory_date: {
          required: true
          // minlength: 3
        }
        
      },
      messages: {
        location_id: {
          required: "Please select the Location"
          // minlength: "Category name must be at least 3 characters long"
        },
        inventory_date: {
          required: "Please select the date"
          // minlength: "Category name must be at least 3 characters long"
        }
      },
      errorElement: "span",
      errorClass: "error-text",
      highlight: function (element) {
        $(element).addClass("is-invalid").removeClass("is-valid");
      },
      unhighlight: function (element) {
        $(element).addClass("is-valid").removeClass("is-invalid");
      }
    });



  });
</script>

<script>
    document.getElementById('datePicker').setAttribute('max', new Date().toISOString().split('T')[0]);
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