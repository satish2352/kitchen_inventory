@include('layouts.header')
@include('layouts.sidebar')

@yield('content')

<style>
  .select2{
    width: 100% !important;
  }
  .select2-container--default .select2-selection--multiple {
    border: var(--bs-border-width) solid var(--bs-border-color);
    border-radius: var(--bs-border-radius);
  }

  .select2-container--default .select2-selection--multiple:after {
    content: "⌄"; 
    font-family: FontAwesome;
    font-size: 16px;
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
}

.btn_css:hover{
    color: blue;
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
          <h5 class="sub-title">Users</h5>
          <!-- person -->
          <button class="btn btn-light add-btn">
            <i class="bi bi-plus-lg"></i>
            <span>Add User</span>
          </button>
          <!-- <div class="person add-user add-btn">
            <i class="bi bi-person"></i>
            <span>Add User</span>
          </div> -->
          <!-- <button class="person add-user add-btn">
              <i class="bi bi-person"></i>
              <span>Add User</span>
          </button> -->

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
          <!-- <button class="btn btn-white mx-2">
            <i class="bi bi-geo-alt-fill"></i>
          </button> -->
        </div>
      </div>
      <!-- user requestion section  -->
      <div class="user-request pb-3">

      @if (!empty($user_data) && count($user_data) > 0)
        <div class="container-fluid px-3" id="search-results">


        @foreach ($user_data as $item)
          <!-- User Request Box -->
          <div class="user-request-box p-3 shadow rounded mb-2">
            <!-- Top Row -->
            <div class="d-flex justify-content-between align-items-center">
              <!-- Left Section -->
              <div>
                <div class="d-flex align-items-center">
                  <span class="ur-user me-2 jost-font">{{ $item->name }}
                  @if($item->user_role == '1')
                  (Super Admin)
                  @elseif($item->user_role == '2')
                  (Admin)
                  @else
                  (Night Manager)
                  @endif
                  </span>

                  @if($item->is_approved == 0)
                  <div class="status-badge ms-2 d-flex align-items-center" style="background-color:red">
                    <i class="bi bi-check-circle-fill text-success me-1"></i>
                    <span style="color:white">Unapproved</span>
                  </div>
                @elseif($item->is_approved == 1) 
                  <div class="status-badge ms-2 d-flex align-items-center">
                    <i class="bi bi-check-circle-fill text-success me-1"></i>
                    <span style="color:white">Approved</span>
                  </div>
                @endif 
                </div>
                <p class="mb-1 fw-light"><b>Email ID :</b> {{ $item->email }}</p>
                <p class="mb-1 fw-light"><b>Mobile No. :</b> {{ $item->phone }}</p>
                <p class="mb-1 fw-light"><b>Locations :</b>
                @if(!empty($item->locations))
                    {{ implode(', ', $item->locations) }}
                @else
                    N/A
                @endif
                </p>
              </div>

              <!-- Right Section -->
              <div>
                <button class="btn btn-edit text-center shadow-sm edit-btn-user" data-id="{{ $item->id }}">
                  <i class="bi bi-pencil-square"></i> <br />Edit
                </button>
              </div>
            </div>

            <!-- Divider -->
            <hr class="my-2" />

            <!-- Last Active Section -->
            <div class="text-center fw-light fs-sm">
            {{ \Carbon\Carbon::parse($item->created_at)->format('D F j, Y | g:ia') }}
            </div>
          </div>
          
          @endforeach


        </div>

        <div class="mt-3">
            {{ $user_data->links() }}
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

      <!-- add popup  -->
      <div id="addPopup" class="popup-container">
        <div class="popup-content">

        <form class="forms-sample" id="frm_register" name="frm_register" method="post" role="form"
          action="{{ route('add-admin-users') }}" enctype="multipart/form-data">
          <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
          <!-- Popup Title -->
          <h4 class="popup-title">Add User Details</h4>
          <hr />

          <!-- Select Options -->
          <!-- <div class="row mb-3">
            <label class="col-6 form-label">Select Location</label>
            <div class="col-6">
              <select class="form-select" name="location">
              <option value="">Select Location</option>
              @foreach ($locationsData as $locationItem)
                <option value="{{ $locationItem['id'] }}">{{ $locationItem['location'] }}</option>
                @endforeach
              </select>
            </div>
          </div> -->

          <!-- <div class="row mb-3">
    <label class="col-6 form-label">Select Location</label>
    <div class="col-6">
        @foreach ($locationsData as $locationItem)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="location[]" value="{{ $locationItem['id'] }}" id="location_{{ $locationItem['id'] }}">
                <label class="form-check-label" for="location_{{ $locationItem['id'] }}">
                    {{ $locationItem['location'] }}
                </label>
            </div>
        @endforeach
    </div>
</div> -->


          <!-- Select Options -->
          <!-- <div class="row mb-3">
            <label class="col-6 form-label">Select Location</label>
            <div class="col-6">
              <select class="form-select select2" name="location[]" multiple>
                <option value="" disabled>Select Location</option>
                @foreach ($locationsData as $locationItem)
                  <option value="{{ $locationItem['id'] }}">{{ $locationItem['location'] }}</option>
                @endforeach
              </select>
            </div>
          </div> -->

      <div class="row mb-3">
        <label class="col-6 form-label">Select Location</label>
        <div class="col-6">
            <select class="form-select select2" name="location[]" multiple data-placeholder="Select Location">
            <option disabled selected hidden>Select Location</option>
                @foreach ($locationsData as $locationItem)
                    <option value="{{ $locationItem['id'] }}">{{ $locationItem['location'] }}</option>
                @endforeach
            </select>
        </div>
      </div>

          <div class="row mb-3">
            <label class="form-label col-6">Select Role</label>
            <div class="col-6">
              <select class="form-select" name="role">
              <option value="">Select Role</option>
              <!-- <option value="1">Super Admin</option> -->
                <!-- <option value="2">Admin</option> -->
                <option value="3">Night Manager</option>
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <label class="form-label col-6">Enter User Name</label>
            <div class="col-6">
              <input
                type="text"
                class="form-control"
                placeholder="Enter User Name"
                name="name"
                style="text-transform: capitalize;"
              />
            </div>
          </div>
          <div class="row mb-3">
            <label class="form-label col-6">Enter Mobile Number</label>
            <div class="col-6">
              <input
                type="text"
                class="form-control"
                placeholder="Enter Mobile Number"
                name="phone"
              />
              <span id="validation-message" class="red-text"></span>
                <!-- @if ($errors->has('phone'))
                    <span class="red-text"><?php echo $errors->first('phone', ':message'); ?></span>
                @endif -->
            </div>
          </div>
          <div class="row mb-3">
            <label class="form-label col-6">Enter Email Id</label>
            <div class="col-6">
              <input
                type="text"
                class="form-control"
                placeholder="Enter Email Id"
                name="email"
              />
            </div>
            <!-- @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror -->
            @if ($errors->has('email'))
                <span class="red-text"><?php echo $errors->first('email', ':message'); ?></span>
            @endif
          </div>
          <div class="row mb-3">
            <label class="form-label col-6">Enter password</label>
            <div class="col-6">
              <input
                type="text"
                class="form-control"
                placeholder="Enter password"
                name="password"
              />
            </div>
          </div>

          <hr />
          <div class="d-flex justify-content-around">
          <a class="btn btn-secondary btn-lg w-100 me-2" id="closePopup">
              <i class="bi bi-x-circle"></i> Cancel
            </a>


            <!-- <a  class="btn btn-outline-danger btn-delete-user btn-lg w-100 me-2">
              <i class="bi bi-trash"></i> Delete
            </a> -->
            <button class="btn btn-success btn-lg w-100">
              <i class="bi bi-plus-circle"></i> Submit
            </button>
          </div>
        </form>  
        </div>
      </div>

      <!-- edit popup  -->
      <div id="editPopupUser" class="popup-container">
        <div class="popup-content">

        <form class="forms-sample" id="editUserForm" name="editUserForm" method="post" role="form"
          action="{{ route('update-admin-users') }}" enctype="multipart/form-data">
          <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
          <!-- Popup Title -->
          <h4 class="popup-title">Edit User Details</h4>
          <hr />
          <input type="hidden" class="form-control" placeholder="Enter Location Name" name="edit_id" id="edit-user-id"/>

          <!-- Select Options -->
          <!-- <div class="row mb-3">
            <label class="col-6 form-label">Select Location</label>
            <div class="col-6">
              <select class="form-select" name="location" id="location">
              @foreach ($locationsData as $locationItem)
                <option value="{{ $locationItem['id'] }}">{{ $locationItem['location'] }}</option>
                @endforeach
              </select>
            </div>
          </div> -->

          <!-- Select Options (with checkboxes) -->
<!-- <div class="row mb-3">
    <label class="col-6 form-label">Select Location</label>
    <div class="col-6">
        @foreach ($locationsData as $locationItem)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="location[]" value="{{ $locationItem['id'] }}" 
                    id="location{{ $locationItem['id'] }}">
                <label class="form-check-label" for="location{{ $locationItem['id'] }}">
                    {{ $locationItem['location'] }}
                </label>
            </div>
        @endforeach
    </div>
</div> -->

          <div class="row mb-3">
            <label class="col-6 form-label">Select Location</label>
            <div class="col-6">
              <select class="form-select select2" name="location[]" id="location" multiple>
                <option value="">Select Location</option>
                @foreach ($locationsData as $locationItem)
                  <option value="{{ $locationItem['id'] }}">{{ $locationItem['location'] }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <label class="form-label col-6">Select Role</label>
            <div class="col-6">
              <select class="form-select" name="role" id="role">
                <option value="">Select Role</option>
                <!-- <option value="1">Super Admin</option> -->
                <!-- <option value="2">Admin</option> -->
                <option value="3">Night Manager</option>
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <label class="form-label col-6">Enter User Name</label>
            <div class="col-6">
              <input
                type="text"
                class="form-control"
                placeholder="Enter User Name"
                name="name" id="name"
                style="text-transform: capitalize;"
              />
            </div>
          </div>
          <div class="row mb-3">
            <label class="form-label col-6">Enter Mobile Number</label>
            <div class="col-6">
              <input
                type="text"
                class="form-control"
                placeholder="Enter Mobile Number"
                name="phone" id="phone"
              />
            </div>
          </div>
          <div class="row mb-3">
            <label class="form-label col-6">Enter Email Id</label>
            <div class="col-6">
              <input
                type="text"
                class="form-control"
                placeholder="Enter Email Id"
                name="email" id="email"
              />
            </div>
          </div>
          <div class="row mb-3">
            <label class="form-label col-6">Enter password</label>
            <div class="col-6">
              <input
                type="text"
                class="form-control"
                placeholder="Enter password"
                name="password" id="password"
              />
            </div>
          </div>

          <hr />
          <div class="d-flex justify-content-around">
            <a  class="btn btn-outline-danger btn-delete-user btn-lg w-100 me-2">
              <i class="bi bi-trash"></i> Delete
            </a>
            <button class="btn btn-danger btn-lg w-100">
              <i class="bi bi-arrow-repeat"></i> Update
            </button>
          </div>
</form>
       </div>  
        </div>
      </div>

      <!-- Delete Confirmation Popup -->
      <div id="confirmPopupUser" class="confirm-popup-container">
        <div class="confirm-popup-content">
          <h4 class="confirm-popup-title">Please Confirm</h4>
          <p class="confirm-popup-text">
            Are you sure to delete this user? <br />
            this user wil not recover back
          </p>
          <div class="d-flex justify-content-around mt-4 confrm">
            <button id="cancelDelete" class="btn br btn_css">NO</button>
            <button id="confirmDeleteUser" class="btn btn_css">YES</button>
          </div>
        </div>
      </div>
    </div>

    <form method="POST" action="{{ url('/delete-users') }}" id="deleteform">
            @csrf
            <input type="hidden" name="delete_id" id="delete_id" value="">
        </form>
 @extends('layouts.footer')

 <script type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
      const addButton = document.querySelector(".add-btn");
      const popupadd = document.getElementById("addPopup");
      const editButtonUser = document.querySelector(".edit-btn-user");
      const popupuser = document.getElementById("editPopupUser");
      const deleteButtonUser = document.querySelector(".btn-delete-user");
      const confirmPopupUser = document.getElementById("confirmPopupUser");
      const confirmDeleteUser = document.getElementById("confirmDeleteUser");
      const cancelDeleteButton = document.getElementById("cancelDelete");

      // Close Confirmation Popup on Cancel
  if (cancelDeleteButton) {
    cancelDeleteButton.addEventListener("click", (e) => {
      e.preventDefault(); // Prevent default behavior
      confirmPopupUser.style.display = "none"; // Hide popup
    });
  }

      // Close Popup when clicking outside
      popupuser.addEventListener("click", (e) => {
        if (e.target === popupuser) {
          popupuser.style.display = "none";
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
      editButtonUser.addEventListener("click", () => {
        popupuser.style.display = "flex";
      });

      deleteButtonUser.addEventListener("click", () => {
        popupuser.style.display = "none"; // Close the bottom popup
        confirmPopupUser.style.display = "flex"; // Show the confirmation popup
      });
    
      // // Close Confirmation Popup on Cancel
      cancelDeleteButton.addEventListener("click", () => {
        confirmPopupUser.style.display = "none";
      });

      confirmDeleteUser.addEventListener("click", () => {
        confirmPopupUser.style.display = "none";
                $("#delete_id").val($("#edit-user-id").val());
                $("#deleteform").submit();
        // alert("User deleted successfully!");
        // Add delete logic here
      });
    });
 </script>

<script>
 $(document).ready(function() {
  // alert('kkkkkkkkkkkkkk');
  // Open the popup when Edit button is clicked
  $('.edit-btn-user').on('click', function() {
    var locationId = $(this).data('id'); // Get the location ID from the button
    
    // AJAX request to get location data
    $.ajax({
      url: '{{ route('edit-admin-users') }}', // Your route to fetch the location data
      type: 'GET',
      data: {
                locationId: locationId
            },
      success: function(response) {
        console.log('responseresponseresponseresponse',response.user_data);
        // alert('ppppppppppppppppppp');
        // Populate the popup with the fetched data
        // $('#location').val(response.user_data.location); // Set location value
        $('#name').val(response.user_data.name); // Set location value
        $('#role').val(response.user_data.user_role); // Set location value
        $('#email').val(response.user_data.email); // Set location value
        $('#phone').val(response.user_data.phone); // Set location value
        $('#password').val(response.user_data.password); // Set location value
        $('#edit-user-id').val(response.user_data.id); // Set role value
        // Select the correct location
        // $('#location').val(response.user_data.location).change();

        // var selectedLocations = response.user_data.location.split(','); // Split the comma-separated locations
        //         selectedLocations.forEach(function(locationId) {
        //             $('#location' + locationId).prop('checked', true); // Check the corresponding checkboxes
        //         });

        // Auto-select multiple locations
        var selectedLocations = response.user_data.location.split(','); // Convert comma-separated values into an array
        $('#location').val(selectedLocations).change(); // Set selected values and trigger change event

        
        // Show the popup
        $('#editPopupUser').show();

// Add the CSS property for flex display
document.getElementById('editPopupUser').style.display = "flex";
      },
      error: function() {
        alert('Failed to load location data.');
      }
    });
  });
});
</script> 

<script type="text/javascript">
  $(document).ready(function () {
    $.validator.addMethod("validPhone", function(value, element) {
    return /^[6-9]\d{9}$/.test(value); // Ensures 10-digit mobile number starting with 6-9
  }, "Please enter a valid 10-digit mobile number starting with 6-9.");

  // Add custom validation method
$.validator.addMethod("passwordStrength", function(value, element) {
    return this.optional(element) || /^(?=(?:[^a-zA-Z]*[a-zA-Z]){5,})(?=.*\d)(?=.*[@$!%*?&]).{6,}$/.test(value);
}, "Password must contain at least 5 letters, 1 number, and 1 special character");
    

    // Initialize validation for the add form
    $("#frm_register").validate({
      rules: {
       "location[]": {
      required: function() {
        return $("#frm_register select[name='location[]'] option:selected").length === 0;
      }
    },
        role: {
          required: true
          // minlength: 3
        },
        name: {
          required: true
          // minlength: 3
        },
        phone: {
          required: true,
          // number:true,
          minlength: 10,
          maxlength: 10,
          validPhone: true
          // pattern: /^[6-9]\d{9}$/
          // minlength: 3
        },
        email: {
          required: true,
          email:true,
          // minlength: 3
        },
        password: {
            required: true,
            minlength: 6,
            passwordStrength: true
        }
        
      },
      messages: {
        "location[]": {
      required: "Please select at least one location."
    },
        role: {
          required: "Please select the role name"
          // minlength: "Category name must be at least 3 characters long"
        },
        name: {
          required: "Please enter user name"
          // minlength: "Category name must be at least 3 characters long"
        },
        phone: {
          required: "Please enter mobile number",
          // number:"Please enter valid mobile number",
          minlength: "Phone number min length must be exactly 10 digits.",
          maxlength: "Phone number max length must be exactly 10 digits.",
          pattern: "Please enter a valid 10-digit mobile number starting with 6-9."
          // minlength: "Category name must be at least 3 characters long"
        },
        email: {
          required: "Please enter email ID",
          required: "Please Enter valid email"
          // minlength: "Category name must be at least 3 characters long"
        },
        password: {
            required: "Password is required",
            minlength: "Password must be at least 6 characters long",
            passwordStrength: "Password must contain at least 5 letters, 1 number, and 1 special character"
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
      errorPlacement: function(error, element) {
        if (element.attr("name") === "location[]") {
            error.insertAfter(element.closest(".form-select")); // Places the error message below the select field
        } else {
            error.insertAfter(element);
        }
    }
    });

    // Initialize validation for the edit form
    // Initialize validation for the add form
    $("#editUserForm").validate({
      rules: {
        location: {
          required: true
          // minlength: 3
        },
        role: {
          required: true
          // minlength: 3
        },
        name: {
          required: true
          // minlength: 3
        },
        phone: {
          required: true,
          // number:true,
          minlength: 10,
          maxlength: 10,
          validPhone: true
          // pattern: /^[6-9]\d{9}$/
          // minlength: 3
        },
        email: {
          required: true,
          email:true,
          // minlength: 3
        },
        password: {
          required: true
          // minlength: 3
        }
        
      },
      messages: {
        location: {
          required: "Please select the location name"
          // minlength: "Category name must be at least 3 characters long"
        },
        role: {
          required: "Please select the role name"
          // minlength: "Category name must be at least 3 characters long"
        },
        name: {
          required: "Please enter user name"
          // minlength: "Category name must be at least 3 characters long"
        },
        phone: {
          required: "Please enter mobbile number",
          // number:"Please enter valid mobile number",
          minlength: "Mobile number min length must be exactly 10 digits.",
          maxlength: "Mobile number max length must be exactly 10 digits.",
          pattern: "Please enter a valid 10-digit mobile number starting with 6-9."
          // minlength: "Category name must be at least 3 characters long"
        },
        email: {
          required: "Please enter email ID",
          required: "Please Enter valid email Id"
          // minlength: "Category name must be at least 3 characters long"
        },
        password: {
          required: "Please enter password"
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

<!-- <script>
            function addvalidateMobileNumber(number) {
                var mobileNumberPattern = /^\d*$/;
                var validationMessage = document.getElementById("validation-message");

                if (mobileNumberPattern.test(number)) {
                    validationMessage.textContent = "";
                } else {
                    validationMessage.textContent = "Please enter only numbers.";
                }
            }

            $.validator.addMethod("email", function(value, element) {
                    // Regular expression for email validation
                    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                    return this.optional(element) || emailRegex.test(value);
                }, "Please enter a valid email address.");
        </script> -->

        <script>
    $(document).ready(function() {
      var originalData = $('#search-results').html();
        // Bind keyup event to the search input
        $('#search-query').on('keyup', function() {
            var query = $(this).val().trim();  // Get the value entered in the search box

            if (query.length > 0) {
                $.ajax({
                    url: "{{ route('users_search_admin') }}",  // Define your search route here
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
                $('#search-results').html(originalData);
            }
        });
    });
</script>
<script>
  $(document).ready(function() {
  $('.select2').select2();
});
</script>