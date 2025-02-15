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
          <h5 class="sub-title">Approve/Unapprove User</h5>
          <a href="#"> 
            <!-- <button class="btn btn-light">
            <i class="bi bi-check2"></i>
          </button> -->
          </a>
        </div>
      </div>

      <!-- user requestion section  -->
      <div class="user-request pb-3">
        <div class="container-fluid px-3">
          <!-- Section Title -->
          <h3 class="mb-4">User Requests</h3>

          @if (!empty($user_data) && count($user_data) > 0)

          @foreach ($user_data as $item)
          <!-- User Request Box -->
          <div class="user-request-box p-3 shadow rounded mb-2">
            <!-- Top Row -->
            <div class="d-flex justify-content-between align-items-center">
              <!-- Left Section -->
              <div>
                <div class="d-flex align-items-center">
                  <span class="ur-user me-2 jost-font">{{ $item->name }}</span>
                @if($item->is_approved == 0)
                  <!-- <div class="status-badge ms-2 d-flex align-items-center approve-btn" style="background-color:red" dataId="{{ $item->id }}">
                    <i class="bi bi-check-circle-fill text-success me-1"></i>
                    <span style="color:white">Unapprove</span>
                  </div> -->

                  <div class="status-badge ms-2 d-flex align-items-center approve-btn" 
     style="background-color:red; cursor:pointer; padding:8px 12px; border-radius:5px;"
     role="button" dataId="{{ $item->id }}">
    <i class="bi bi-check-circle-fill text-success me-1"></i>
    <span style="color:white">Unapproved</span>
</div>
                @endif  
                </div>
                <p class="mb-1 fw-light"><b>Email ID :</b> {{ $item->email }}</p>
                <p class="mb-1 fw-light"><b>Mobile No. :</b>{{ $item->phone }}</p>
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
      




      <!-- edit popup  -->
      <div id="editPopupUser" class="popup-container">
        <div class="popup-content">

        <form class="forms-sample" id="editUserForm" name="editUserForm" method="post" role="form"
          action="{{ route('update-approve-users-all-data') }}" enctype="multipart/form-data">
          <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
          <!-- Popup Title -->
          <h4 class="popup-title">Edit User Details</h4>
          <hr />
          <input type="hidden" class="form-control" placeholder="Enter Location Name" name="edit_id" id="edit-user-id"/>

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

      <!-- Approve Confirmation Popup -->
      <div id="confirmPopup" class="confirm-popup-container">
        <div class="confirm-popup-content">
          <h4 class="confirm-popup-title">Please Confirm</h4>
          <p class="confirm-popup-text">
            Are you sure to Approve this user? <br />
          </p>
          <div class="d-flex justify-content-around mt-4 confrm">
            <button id="cancelDelete" class="btn br">NO</button>
            <button id="confirmDelete" class="btn">YES</button>
          </div>
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
            <button id="cancelDeleteUser" class="btn br">NO</button>
            <button id="confirmDeleteUser" class="btn">YES</button>
          </div>
        </div>
      </div>
    </div>

    <form method="POST" action="{{ url('/update-approve-users') }}" id="submitForm">
            @csrf
            <input type="hidden" name="activid" id="activid" value="">
        </form>

        <form method="POST" action="{{ url('/delete-approve-users') }}" id="deleteform">
            @csrf
            <input type="hidden" name="delete_id" id="delete_id" value="">
        </form>
 @extends('layouts.footer')

 <!-- <script>
    $('.active-btn').click(function(e) {
        $("#active_id").val($(this).attr("data-id"));
        $("#activeform").submit();
    })
</script> -->

 <script type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
      // const approveButton = document.querySelector(".approve-btn");
      // const popupadd = document.getElementById("addPopup");
      const editButtonUser = document.querySelector(".edit-btn-user");
      
      const approveButton = document.querySelector(".approve-btn");
      const confirmPopup = document.getElementById("confirmPopup");
      const confirmDelete = document.getElementById("confirmDelete");
      const cancelDeleteButton = document.getElementById("cancelDelete");

      const popupuser = document.getElementById("editPopupUser");
      const deleteButtonUser = document.querySelector(".btn-delete-user");
      const confirmPopupUser = document.getElementById("confirmPopupUser");
      const confirmDeleteUser = document.getElementById("confirmDeleteUser");
      const cancelDeleteUserButton = document.getElementById("cancelDeleteUser");



      // Close Confirmation Popup on Cancel
  if (cancelDeleteButton) {
    cancelDeleteButton.addEventListener("click", (e) => {
      e.preventDefault(); // Prevent default behavior
      confirmPopup.style.display = "none"; // Hide popup
    });
  }


      // // Open Popup
      document.querySelectorAll(".approve-btn").forEach(button => {
    button.addEventListener("click", function () { // Use function() instead of () => {}
        var xyz = this.getAttribute("dataId"); // Correctly gets the dataId attribute
        document.getElementById("activid").value = xyz;
        confirmPopup.style.display = "flex";
        // document.getElementById("popupadd").style.display = "flex";
    });
});


      // approveButton.addEventListener("click", () => {
      //   // popupuser.style.display = "none"; // Close the bottom popup
      //   confirmPopup.style.display = "flex"; // Show the confirmation popup
      // });
    
      // // Close Confirmation Popup on Cancel
      cancelDeleteButton.addEventListener("click", () => {
        confirmPopup.style.display = "none";
      });

      confirmDelete.addEventListener("click", () => {
        confirmPopup.style.display = "none";
                $("#submitForm").submit();
        // alert("User deleted successfully!");
        // Add delete logic here
      });



      if (cancelDeleteButton) {
    cancelDeleteButton.addEventListener("click", (e) => {
      e.preventDefault(); // Prevent default behavior
      confirmPopupUser.style.display = "none"; // Hide popup
    });
  }

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
  $('.edit-btn-user').on('click', function() {
    var locationId = $(this).data('id'); // Get the location ID from the button
    
    $.ajax({
      url: '{{ route('edit-users') }}', // Your route to fetch the location data
      type: 'GET',
      data: {
                locationId: locationId
            },
      success: function(response) {
        $('#name').val(response.user_data.name); // Set location value
        $('#role').val(response.user_data.user_role); // Set location value
        $('#email').val(response.user_data.email); // Set location value
        $('#phone').val(response.user_data.phone); // Set location value
        $('#password').val(response.user_data.password); // Set location value
        $('#edit-user-id').val(response.user_data.id); // Set role value

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
          required: "Please enter phone number",
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