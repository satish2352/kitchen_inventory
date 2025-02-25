@include('layouts.header')
@include('layouts.sidebar')
@yield('content')
<style>
  
/* Pagination styles */
.pagination {
    margin: 20px 0;
}

.pagination ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.pagination ul li {
    display: inline;
    margin-right: 5px;
}

.pagination ul li a,
.pagination ul li span {
    padding: 5px 10px;
    border: 1px solid #ccc;
    text-decoration: none;
    color: #333;
}

.pagination ul li.active a {
    background-color: #007bff;
    color: #fff;
    border-color: #007bff;
}

.pagination ul li.disabled span {
    color: #ccc;
}

img, svg {
    vertical-align: middle;
    width: 2%;
}

div.dataTables_wrapper div.dataTables_info {
    display: none;
}
div.dataTables_wrapper div.dataTables_paginate ul.pagination{
    display: none; 
}
.pagination .flex .flex{
    display: none; 
}

.btn_css:hover{
    color: blue;
}

@media (max-width: 472px) {
    .pagination ul {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        padding: 0;
    }

    .pagination ul li {
        margin: 2px;
    }

    .pagination ul li:nth-child(n+1) {
        margin-top: 15px;
    }

    .pagination ul li a,
    .pagination ul li span {
        padding: 8px 12px;
        font-size: 14px;
    }

    .pagination ul li.active a {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
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
         <h5 class="sub-title">Manage Units</h5>
         <button class="btn btn-light add-btn">
         <i class="bi bi-plus-lg"></i>
         <span>Add Units</span>
         </button>
      </div>
   </div>
   <div class="filter">
      <div class="shopping-list-row d-flex align-items-center p-3">
         <!-- Search Input -->
         <!-- <div class="input-group search-input">
            <input
              type="text"
              class="form-control"
              placeholder="Search..."
              aria-label="Search"
            />
            <button class="btn btn-srh" type="button">
              <i class="bi bi-search"></i>
            </button>
            </div> -->
         <!-- Search Input -->
         <div class="input-group search-input">
            <input
               type="text"
               class="form-control"
               placeholder="Search..."
               aria-label="Search"
               id="search-query"
               />
            <button class="btn btn-srh" type="button">
            <i class="bi bi-search"></i>
            </button>
         </div>
      </div>
   </div>
   <div class="container-fluid px-3">
      <!-- Border Box -->
      <div class="border-box">
         <!-- Header Title -->
         <!-- <div class="grid-header text-center">
            <h6 class="m-0 text-white">Chicken/Proteins</h6>
            </div> -->
         <!-- Table -->
         <div class="table-responsive">
            @if (!empty($unit_data) && count($unit_data) > 0)
            <table class="table table-striped" id="inventoryTable">
               <!-- Table Head -->
               <thead class="table-header">
                  <tr>
                     <th onclick="sortTable('inventoryTable', 0)"><b>Sr. No. <i class="bi bi-arrow-up" id="arrow-0"></i></b></th>
                     <!-- <th><b>Date</b></th> -->
                     <th onclick="sortTable('inventoryTable', 1)"><b>Units <i class="bi bi-arrow-up" id="arrow-1"></i></b></th>
                     <th><b>Action</b></th>
                  </tr>
               </thead>
               <!-- Table Body -->
               <tbody id="search-results">
                  @php
                  $serialNumber = ($unit_data->currentPage() - 1) * $unit_data->perPage() + 1;
                  @endphp
                  @foreach ($unit_data as $item)
                  <tr>
                     <td>{{ $serialNumber++ }}</td>
                     <!-- <td>{{ $item->created_at }}</td> -->
                     <td>{{ $item->unit_name }}</td>
                     <td>
                        <button
                           class="btn text-center shadow-sm btn-sm edit-btn-unit mu-edit" data-id="{{ $item->id }}">
                        <i class="bi bi-pencil-square"></i> Edit
                        </button>
                     </td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
            <div class="mt-3">
               <div class="col-md-8">
                  <div class="pagination">
                     @if ($unit_data->lastPage() > 1)
                     <ul class="pagination">
                        <li class="{{ ($unit_data->currentPage() == 1) ? ' disabled' : '' }}">
                           @if ($unit_data->currentPage() > 1)
                           <a href="{{ $unit_data->url($unit_data->currentPage() - 1) }}">Previous</a>
                           @else
                           <span>Previous</span>
                           @endif
                        </li>
                        @php
                        $currentPage = $unit_data->currentPage();
                        $lastPage = $unit_data->lastPage();
                        $startPage = max($currentPage - 5, 1);
                        $endPage = min($currentPage + 4, $lastPage);
                        @endphp
                        @if ($startPage > 1)
                        <li>
                           <a href="{{ $unit_data->url(1) }}">1</a>
                        </li>
                        @if ($startPage > 2)
                        <li>
                           <span>...</span>
                        </li>
                        @endif
                        @endif
                        @for ($i = $startPage; $i <= $endPage; $i++)
                        <li class="{{ ($currentPage == $i) ? ' active' : '' }}">
                           <a href="{{ $unit_data->url($i) }}">{{ $i }}</a>
                        </li>
                        @endfor
                        @if ($endPage < $lastPage)
                        @if ($endPage < $lastPage - 1)
                        <li>
                           <span>...</span>
                        </li>
                        @endif
                        <li>
                           <a href="{{ $unit_data->url($lastPage) }}">{{ $lastPage }}</a>
                        </li>
                        @endif
                        <li class="{{ ($currentPage == $lastPage) ? ' disabled' : '' }}">
                           @if ($currentPage < $lastPage)
                           <a href="{{ $unit_data->url($currentPage + 1) }}">Next</a>
                           @else
                           <span>Next</span>
                           @endif
                        </li>
                        <!-- <li>
                           <span>Page {{ $currentPage }}</span>
                           </li> -->
                     </ul>
                     @endif
                  </div>
               </div>
               <!-- Pagination for each category -->
            </div>
            @else
            <div class="border-box mb-4" id="search-results">
                          <!-- Header Title -->
                          <div class="grid-header text-center">
                              <h6 class="m-0 text-white">No Data Found</h6>
                          </div>
                      </div> 
          
        @endif  

          </div>
        </div>
      </div>

      <div id="addPopup" class="popup-container">
   <div class="popup-content">
      <form class="forms-sample" id="frm_register" name="frm_register" method="post" role="form"
          enctype="multipart/form-data">
         <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
         <!-- Popup Title -->
         <h4 class="popup-title">Add Unit</h4>
         <hr />
         <!-- Select Options -->
         <div class="row mb-3">
            <label class="col-md-6 col-sm-12 col-lg-6 form-label">Unit</label>
            <div class="col-md-6 col-sm-12 col-lg-6">
               <input
                  type="text"
                  class="form-control"
                  placeholder="Unit"
                  name="unit_name"
                  style="text-transform: capitalize;"
                  />
                  @error('unit_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
               <!-- <select class="form-select">
                  <option value="1">1</option>
                  <option value="1">1</option>
                  <option value="1">1</option> -->
            </div>
         </div>
         <hr />
         <div class="d-flex justify-content-around">
            <!-- <button class="btn btn-secondary btn-lg w-100 me-2">
               <i class="bi bi-x-circle"></i> Cancel
               </button> -->
            <a class="btn btn-secondary btn-lg w-100 me-2" id="closePopup">
            <i class="bi bi-x-circle"></i> Cancel
            </a>
            <button class="btn btn-success btn-lg w-100">
            <i class="bi bi-plus-circle"></i> Add
            </button>
         </div>
      </form>
   </div>
</div>


<div id="editPopupUnit" class="popup-container">
   <div class="popup-content">
      <form class="forms-sample" id="editUnitForm" name="editUnitForm" method="post" role="form"
         action="{{ route('update-units') }}" enctype="multipart/form-data">
         <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
         <!-- Popup Title -->
         <h4 class="popup-title">Edit Unit</h4>
         <hr />
         <!-- Select Options -->
         <div class="row mb-3">
            <label class="col-md-6 col-sm-12 col-lg-6 form-label">Unit</label>
            <div class="col-md-6 col-sm-12 col-lg-6">
               <input
                  type="text"
                  class="form-control"
                  placeholder="Unit"
                  name="unit_name"
                  id="unit_id"
                  style="text-transform: capitalize;"
                  />
               <!-- <select class="form-select">
                  <option value="1">1</option>
                  <option value="1">1</option>
                  <option value="1">1</option> -->
            </div>
         </div>
         <input type="hidden" class="form-control" placeholder="Enter Location Name" name="edit_id" id="edit-unit-id"/>
         <hr />
         <div class="d-flex justify-content-around">
            <a  class="btn btn-outline-danger btn-delete-unit btn-lg w-100 me-2">
            <i class="bi bi-trash"></i> Delete
            </a>
            <!-- <button class="btn btn-outline-danger btn-delete-unit btn-lg w-100 me-2">
               <i class="bi bi-trash"></i> Delete
               </button> -->
            <button class="btn btn-danger btn-lg w-100">
            <i class="bi bi-arrow-repeat"></i> Update
            </button>
         </div>
      </form>
   </div>
</div>
   </div>
   <!-- edit popup  -->
   <div id="editPopupUnit" class="popup-container">
      <div class="popup-content">
         <form class="forms-sample" id="editUnitForm" name="editUnitForm" method="post" role="form"
            action="{{ route('update-units') }}" enctype="multipart/form-data">
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
            <!-- Popup Title -->
            <h4 class="popup-title">Edit Unit</h4>
            <hr />
            <!-- Select Options -->
            <div class="row mb-3">
               <label class="col-md-6 col-sm-12 col-lg-6 form-label">Unit</label>
               <div class="col-md-6 col-sm-12 col-lg-6">
                  <input
                     type="text"
                     class="form-control"
                     placeholder="Unit"
                     name="unit_name"
                     id="unit_id"
                     style="text-transform: capitalize;"
                     />
                  <!-- <select class="form-select">
                     <option value="1">1</option>
                     <option value="1">1</option>
                     <option value="1">1</option> -->
               </div>
            </div>
            <input type="hidden" class="form-control" placeholder="Enter Location Name" name="edit_id" id="edit-unit-id"/>
            <hr />
            <div class="d-flex justify-content-around">
               <a  class="btn btn-outline-danger btn-delete-unit btn-lg w-100 me-2">
               <i class="bi bi-trash"></i> Delete
               </a>
               <!-- <button class="btn btn-outline-danger btn-delete-unit btn-lg w-100 me-2">
                  <i class="bi bi-trash"></i> Delete
                  </button> -->
               <button class="btn btn-danger btn-lg w-100">
               <i class="bi bi-arrow-repeat"></i> Update
               </button>
            </div>
         </form>
      </div>
   </div>
   <!-- Delete Confirmation Popup -->
   <div id="confirmPopupUnit" class="confirm-popup-container">
      <div class="confirm-popup-content">
         <h4 class="confirm-popup-title">Please Confirm</h4>
         <p class="confirm-popup-text">
            Are you sure to delete this unit? <br />
            this unit will not recover back</p>
          <div class="d-flex justify-content-around mt-4 confrm">
            <button id="cancelDelete" class="btn br btn_css">NO</button>
            <button id="confirmDeleteUnit" class="btn btn_css">YES</button>
          </div>
        </div>
       <br/>
   </div>
</div>
<form method="POST" action="{{ url('/delete-units') }}" id="deleteform">
   @csrf
   <input type="hidden" name="delete_id" id="delete_id" value="">
</form>
@extends('layouts.footer')
<script type="text/javascript">
   document.addEventListener("DOMContentLoaded", () => {
     const addButton = document.querySelector(".add-btn");
     const popupadd = document.getElementById("addPopup");
     const editButtonUnit = document.querySelector(".edit-btn-unit");
     const popupunit = document.getElementById("editPopupUnit");
     const deleteButtonUnit = document.querySelector(".btn-delete-unit");
     const confirmPopupUnit = document.getElementById("confirmPopupUnit");
     const confirmDeleteUnit = document.getElementById("confirmDeleteUnit");
     const cancelDeleteButton = document.getElementById("cancelDelete");
     const closePopUpButton = document.getElementById("closePopup");
   
   
     // Close Popup when clicking outside
     popupunit.addEventListener("click", (e) => {
       if (e.target === popupunit) {
         popupunit.style.display = "none";
       }
     });
   
     popupadd.addEventListener("click", (e) => {
       if (e.target === popupadd) {
         popupadd.style.display = "none";
       }
     });

     // // Close Popup
     closePopUpButton.addEventListener("click", () => {
       popupadd.style.display = "none";
     });
   
     // // Open Popup
     addButton.addEventListener("click", () => {
       popupadd.style.display = "flex";
     });
   
     // Open Popup
     editButtonUnit.addEventListener("click", () => {
       popupunit.style.display = "flex";
     });
   
     deleteButtonUnit.addEventListener("click", () => {
       popupunit.style.display = "none"; // Close the bottom popup
       confirmPopupUnit.style.display = "flex"; // Show the confirmation popup
     });
   
     // // Close Confirmation Popup on Cancel
     cancelDeleteButton.addEventListener("click", () => {
       confirmPopupUnit.style.display = "none";
     });
   
     confirmDeleteUnit.addEventListener("click", () => {
       confirmPopupUnit.style.display = "none";
               $("#delete_id").val($("#edit-unit-id").val());
               $("#deleteform").submit();
       // alert("Unit deleted successfully!");
       // Add delete logic here
     });
   });
</script>
<script>
   $(document).ready(function() {
    // alert('kkkkkkkkkkkkkk');
    // Open the popup when Edit button is clicked
   //  $('.edit-btn-unit').on('click', function() {
      $(document).on('click', '.edit-btn-unit', function() {

      var locationId = $(this).data('id'); // Get the location ID from the button
      
      // AJAX request to get location data
      $.ajax({
        url: '{{ route('edit-units') }}', // Your route to fetch the location data
        type: 'GET',
        data: {
                  locationId: locationId
              },
        success: function(response) {
          // console.log('responseresponseresponseresponse',response.location_data);
          // alert('ppppppppppppppppppp');
          // Populate the popup with the fetched data
          $('#unit_id').val(response.unit_data.unit_name); // Set location value
          $('#edit-unit-id').val(response.unit_data.id); // Set role value
   
          
          // Show the popup
          $('#editPopupUnit').show();
   
   // Add the CSS property for flex display
   document.getElementById('editPopupUnit').style.display = "flex";
        },
        error: function() {
          alert('Failed to load location data.');
        }
      });
    });
    // Close the popup if clicked outside (optional)
    // $(document).on('click', function(event) {
    //   if (!$(event.target).closest('#editPopup, .edit-btn').length) {
    //     $('#editPopup').hide();
    //   }
    // });
   });
</script> 
<script type="text/javascript">
   $(document).ready(function () {
     // Initialize validation for the add form
     $("#frm_register").validate({
       rules: {
         unit_name: {
           required: true
           // minlength: 3
         }
       },
       messages: {
         unit_name: {
           required: "Please enter the unit name"
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
       },
       submitHandler: function(form) {
            // AJAX submission only if frontend validation passes
            let formData = new FormData(form);

            $.ajax({
               url: "{{ route('add-units') }}",  // Define the route directly here
               method: "POST", // POST method for form submission
               data: formData,
               processData: false,
               contentType: false,
               success: function (response) {
                   if (response.status == 'success') {
                       location.reload();
                       
                   }
               },
               error: function (xhr) {
                   // Handle validation errors here
                   var errors = xhr.responseJSON.errors;
   
                   // Clear previous errors
                   $('.text-danger').remove();
   
                   // Display new errors
                   if (errors.unit_name) {
                       $('input[name="unit_name"]').after('<span class="text-danger">' + errors.unit_name[0] + '</span>');
                   }
   
                   // Keep the popup open
                   $('#addPopup').show();
               }
           });

            return false; // Prevent default form submission
        }
     });
   
     // Initialize validation for the edit form
     $("#editUnitForm").validate({
       rules: {
         unit_name: {
           required: true
           // minlength: 3
         }
       },
       messages: {
         unit_name: {
           required: "Please enter the unit name"
           // minlength: "Location name must be at least 3 characters long"
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
   $(document).ready(function() {
     var originalData = $('#search-results').html();
       // Bind keyup event to the search input
       $('#search-query').on('keyup', function() {
           var query = $(this).val().trim();  // Get the value entered in the search box
   
           if (query.length > 0) {
               $.ajax({
                   url: "{{ route('search-units') }}",  // Define your search route here
                   method: "GET",
                   data: { query: query },
                   success: function(response) {
                       
                       if(response.length > 0)
                       {
                         // Clear the previous results
                         $('#search-results').html('');
   
                          // Append the new search results
                         $('#search-results').html(response);
                       }else{
                         // Clear the previous results
                         $('#search-results').html(`
                            <div class="border-box mb-4" id="search-results">
                                <div class="grid-header text-center">
                                    <h6 class="m-0 text-white">No Data Found</h6>
                                </div>
                            </div>
                        `);
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
    var sortDirections = {};

    function sortTable(tableId, columnIndex) {
        var table = document.getElementById(tableId);
        var tbody = table.querySelector('tbody');
        var rows = Array.from(tbody.querySelectorAll('tr'));

        if (!sortDirections[tableId]) {
            sortDirections[tableId] = [true, true, true, true, true];
        }
        var ascending = sortDirections[tableId][columnIndex];

        rows.sort(function(rowA, rowB) {
            var cellA = rowA.getElementsByTagName('td')[columnIndex].innerText.trim();
            var cellB = rowB.getElementsByTagName('td')[columnIndex].innerText.trim();

            if (!isNaN(parseFloat(cellA)) && !isNaN(parseFloat(cellB))) {
                return ascending ? cellA - cellB : cellB - cellA;
            }
            return ascending ? cellA.localeCompare(cellB) : cellB.localeCompare(cellA);
        });

        tbody.innerHTML = '';
        rows.forEach(function(row) {
            tbody.appendChild(row);
        });

        sortDirections[tableId][columnIndex] = !ascending;
        updateArrows(tableId, columnIndex, ascending);
    }

    function updateArrows(tableId, columnIndex, ascending) {
        var table = document.getElementById(tableId);
        var headerIcons = table.querySelectorAll('thead th i');
        headerIcons.forEach(function(icon) {
            icon.classList.remove('bi-arrow-up', 'bi-arrow-down');
        });

        var arrowId = `arrow-${columnIndex}`;
        var arrow = document.getElementById(arrowId);
        if (arrow) {
            arrow.classList.toggle('bi-arrow-up', ascending);
            arrow.classList.toggle('bi-arrow-down', !ascending);
        }
    }
</script>
