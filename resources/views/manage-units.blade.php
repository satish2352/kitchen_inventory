@include('layouts.header')
@include('layouts.sidebar')

@yield('content')


<div class="main">
      <div class="inner-top container-fluid p-3">
        <!-- Top Bar -->
        <div class="d-flex justify-content-between align-items-center">
          <a href="dashboard.html">
            <button class="btn btn-light">
              <i class="bi bi-arrow-90deg-left"></i>
            </button>
          </a>
          <h5 class="sub-title">Manage Units</h5>

          <button class="btn btn-light add-btn">
            <i class="bi bi-plus-lg"></i>
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
          <div class="grid-header text-center">
            <h6 class="m-0 text-white">Chicken/Proteins</h6>
          </div>

          <!-- Table -->
          <div class="table-responsive">
            <table class="table table-striped">
              <!-- Table Head -->
              <thead class="table-header">
                <tr>
                  <th>#</th>
                  <th>Date</th>
                  <th>Units</th>
                  <th>Edit</th>
                </tr>
              </thead>
              <!-- Table Body -->
              <tbody id="search-results">

              @foreach ($unit_data as $item)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->created_at }}</td>
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
          </div>
        </div>
      </div>

      <!-- add popup  -->
      <div id="addPopup" class="popup-container">
        <div class="popup-content">

        <form class="forms-sample" id="frm_register" name="frm_register" method="post" role="form"
          action="{{ route('add-units') }}" enctype="multipart/form-data">
          <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
          <!-- Popup Title -->
          <h4 class="popup-title">Add Unit</h4>
          <hr />

          <!-- Select Options -->
          <div class="row mb-3">
            <label class="col-6 form-label">Unit</label>
            <div class="col-6">
            <input
                type="text"
                class="form-control"
                placeholder="Unit"
                name="unit_name"
                style="text-transform: capitalize;"
              />
           <!-- <select class="form-select">
            <option value="1">1</option>
            <option value="1">1</option>
            <option value="1">1</option> -->
            </div>
          </div>

          <hr />
          <div class="d-flex justify-content-around">
            <button class="btn btn-secondary btn-lg w-100 me-2">
              <i class="bi bi-x-circle"></i> Cancel
            </button>
            <button class="btn btn-success btn-lg w-100">
              <i class="bi bi-plus-circle"></i> Add
            </button>
          </div>
        </form>  
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
            <label class="col-6 form-label">Unit</label>
            <div class="col-6">
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
            this unit wil not recover back
          </p>
          <div class="d-flex justify-content-around mt-4 confrm">
            <button id="cancelDelete" class="btn br">NO</button>
            <button id="confirmDeleteUnit" class="btn">YES</button>
          </div>
        </div>
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
        confirmPopup.style.display = "none";
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
  $('.edit-btn-unit').on('click', function() {
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
                          $('#search-results').html('No Data Found');
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