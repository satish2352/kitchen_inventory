@include('layouts.header')
@include('layouts.sidebar')

@yield('content')



<style>
  .error-text {
  color: red;
  font-size: 12px;
}

.is-invalid {
  border-color: red;
}

.is-valid {
  border-color: green;
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
          <h5 class="sub-title">Category</h5>
          <!-- <a href="approve-users.html"> -->
            <button class="btn btn-light add-btn">
              <i class="bi bi-plus-lg"></i>
              <span>Add Category</span>
            </button>
          <!-- </a> -->
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

          <!-- Location Icon -->
          <button class="btn btn-white mx-2">
            <i class="bi bi-geo-alt-fill"></i>
          </button>
        </div>
      </div>
      <!-- user requestion section  -->
      <div class="user-request">
        <div class="container-fluid px-3" id="search-results">



        @foreach ($category_data as $item)
          <!-- User Request Box -->
          <div class="user-request-box p-3 shadow rounded mb-2">
            <!-- Top Row -->
            <div class="d-flex justify-content-between align-items-center">
              <!-- Left Section -->
              <div>
                <div class="d-flex flex-column">
                  <span class="act-user me-2">#{{ $loop->iteration }}</span>
                  <span class="act-user me-2">{{ $item->category_name }}</span>
                </div>
                <p class="mb-1 activity-p">{{ $item->created_at->format('Y-m-d') }}
                </p>
              </div>

              <!-- Right Section -->
              <div>
                <button class="btn btn-edit text-center shadow-sm edit-btn-category" data-id="{{ $item->id }}">
                  <i class="bi bi-pencil-square"></i> <br />Edit
                </button>
              </div>
            </div>
          </div>
        @endforeach
          
        </div>
      </div>

    <!-- Add Popup -->
     <div id="addPopup" class="popup-container">
        <div class="popup-content">
        <form class="forms-sample" id="frm_register" name="frm_register" method="post" role="form"
          action="{{ route('add-category') }}" enctype="multipart/form-data">
          <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />

          <!-- Popup Title -->
          <h4 class="popup-title">Add Category</h4>
          <hr />

          <!-- Select Options -->
          <div class="row mb-3">
            <label class="col-6 form-label">Category Name</label>
            <div class="col-6">
              <input
                type="text"
                class="form-control"
                placeholder="Category Name"
                name="category_name"
                id="abc"
                style="text-transform: capitalize;"
              />
            </div>
          </div>

          <hr />
          <div class="d-flex justify-content-around">
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


      <!-- edit popup  -->
      <div id="editPopupCategory" class="popup-container">
        <div class="popup-content">
        <form class="forms-sample" id="editCategoryForm" name="editCategoryForm" method="post" role="form"
          action="{{ route('update-category') }}" enctype="multipart/form-data">
          <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
          <!-- Popup Title -->
          <h4 class="popup-title">Edit Category</h4>
          <hr />

          <!-- Select Options -->
          <div class="row mb-3">
            <label class="col-6 form-label">Category Name</label>
            <div class="col-6">
              <input
                type="text"
                class="form-control"
                placeholder="Category Name"
                name="category_name"
                id="category_id" style="text-transform: capitalize;"
              />
            <input type="hidden" class="form-control" placeholder="Enter Location Name" name="edit_id" id="edit-category-id"/>

            </div>
          </div>

          <hr />
          <div class="d-flex justify-content-around">
            <!-- <button class="btn btn-outline-danger btn-delete btn-lg w-100 me-2">
              <i class="bi bi-trash"></i> Delete
            </button> -->

            <a  class="btn btn-outline-danger btn-delete-category btn-lg w-100 me-2">
              <i class="bi bi-trash"></i> Delete
            </a>
            <button class="btn btn-danger btn-lg w-100">
              <i class="bi bi-arrow-repeat"></i> Update
            </button>
          </div>
        </form>
        </div>
      </div>

      <!-- Delete Confirmation Popup -->
      <div id="confirmPopupCategory" class="confirm-popup-container">
        <div class="confirm-popup-content">
          <h4 class="confirm-popup-title">Please Confirm</h4>
          <p class="confirm-popup-text">
            Are you sure to delete this Category? <br />
            this Category wil not recover back
          </p>
          <div class="d-flex justify-content-around mt-4 confrm">
            <button id="cancelDelete" class="btn br">NO</button>
            <button id="confirmDeleteCategory" class="btn">YES</button>
          </div>
        </div>
      </div>
    </div>
    <form method="POST" action="{{ url('/delete-category') }}" id="deleteform">
            @csrf
            <input type="hidden" name="delete_id" id="delete_id" value="">
        </form>
    
 @extends('layouts.footer')

 <script type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
      // const deleteButton = document.querySelector(".btn-delete");
      // const editButton = document.querySelector(".edit-btn");
      // const popup = document.getElementById("editPopup");
      const addButton = document.querySelector(".add-btn");
      const popupadd = document.getElementById("addPopup");
      // const confirmPopup = document.getElementById("confirmPopup");
      const cancelDeleteButton = document.getElementById("cancelDelete");
      // const confirmDeleteButton = document.getElementById("confirmDelete");

      const editButtonCategory = document.querySelector(".edit-btn-category");
      const popupcategory = document.getElementById("editPopupCategory");
      const deleteButtonCategory = document.querySelector(".btn-delete-category");
      const confirmPopupCategory = document.getElementById("confirmPopupCategory");
      const confirmDeleteButtonCategory = document.getElementById("confirmDeleteCategory");



    
      // // Open Popup
      addButton.addEventListener("click", () => {
        popupadd.style.display = "flex";
      });

      // Open Popup
      // editButton.addEventListener("click", () => {
      //   popup.style.display = "flex";
      // });
    
      // Close Popup when clicking outside
      popupcategory.addEventListener("click", (e) => {
        if (e.target === popupcategory) {
          popupcategory.style.display = "none";
        }
      });

      popupadd.addEventListener("click", (e) => {
        if (e.target === popupadd) {
          // document.getElementById("abc").value = '';
          document.getElementById("frm_register").reset();
          popupadd.style.display = "none";
          
        }
      });
    
      // Show Confirmation Popup
      // deleteButton.addEventListener("click", () => {
      //   popup.style.display = "none"; // Close the bottom popup
      //   confirmPopup.style.display = "flex"; // Show the confirmation popup
      // });

      deleteButtonCategory.addEventListener("click", () => {
        popupcategory.style.display = "none"; // Close the bottom popup
        confirmPopupCategory.style.display = "flex"; // Show the confirmation popup
      });
    
      // Close Confirmation Popup on Cancel
      cancelDeleteButton.addEventListener("click", () => {
        confirmPopup.style.display = "none";
      });
    
      // Perform Action on Confirm Delete
      // confirmDeleteButton.addEventListener("click", () => {
      //   confirmPopup.style.display = "none";
      //           $("#delete_id").val($("#edit-location-id").val());
      //           $("#deleteform").submit();
      //   alert("User deleted successfully!");
      //   // Add delete logic here
      // });

      confirmDeleteButtonCategory.addEventListener("click", () => {
        confirmPopupCategory.style.display = "none";
                $("#delete_id").val($("#edit-category-id").val());
                $("#deleteform").submit();
        // alert("Category deleted successfully!");
        // Add delete logic here
      });
    });
 </script>
 <script>
 $(document).ready(function() {
  // alert('kkkkkkkkkkkkkk');
  // Open the popup when Edit button is clicked
  $('.edit-btn-category').on('click', function() {
    var locationId = $(this).data('id'); // Get the location ID from the button
    
    // AJAX request to get location data
    $.ajax({
      url: '{{ route('edit-category') }}', // Your route to fetch the location data
      type: 'GET',
      data: {
                locationId: locationId
            },
      success: function(response) {
        // console.log('responseresponseresponseresponse',response.location_data);
        // alert('ppppppppppppppppppp');
        // Populate the popup with the fetched data
        $('#category_id').val(response.category_data.category_name); // Set location value
        $('#edit-category-id').val(response.category_data.id); // Set role value

        
        // Show the popup
        $('#editPopupCategory').show();

// Add the CSS property for flex display
document.getElementById('editPopupCategory').style.display = "flex";
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
        category_name: {
          required: true,
          minlength: 3
        }
      },
      messages: {
        category_name: {
          required: "Please enter the category name",
          minlength: "Category name must be at least 3 characters long"
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
    $("#editCategoryForm").validate({
      rules: {
        category_name: {
          required: true,
          minlength: 3
        }
      },
      messages: {
        category_name: {
          required: "Please enter the category name",
          minlength: "Category name must be at least 3 characters long"
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
                    url: "{{ route('search-category') }}",  // Define your search route here
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