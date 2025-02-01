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
          <h5 class="sub-title">Users</h5>
          <!-- person -->
          <!-- <button class="btn btn-light add-btn">
            <i class="bi bi-plus-lg"></i>
          </button> -->
          <div class="person add-user add-btn">
            <i class="bi bi-person"></i>
            <span>Add User</span>
          </div>
        </div>
      </div>
      <div class="filter">
        <div class="shopping-list-row d-flex align-items-center p-3">
          <!-- Search Input -->
          <div class="input-group search-input">
            <input
              type="text"
              class="form-control"
              placeholder="Search..."
              aria-label="Search"
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
      <div class="user-request pb-3">
        <div class="container-fluid px-3">


        @foreach ($user_data as $item)
          <!-- User Request Box -->
          <div class="user-request-box p-3 shadow rounded mb-2">
            <!-- Top Row -->
            <div class="d-flex justify-content-between align-items-center">
              <!-- Left Section -->
              <div>
                <div class="d-flex align-items-center">
                  <span class="ur-user me-2 jost-font">{{ $item->name }}</span>
                </div>
                <p class="mb-1 fw-light">{{ $item->email }}</p>
                <p class="mb-1 fw-light">{{ $item->phone }}</p>
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
              Last active: Sun April 27, 2024 | 5:45 p.m.
            </div>
          </div>
          
          @endforeach


        </div>
      </div>

      <!-- add popup  -->
      <div id="addPopup" class="popup-container">
        <div class="popup-content">

        <form class="forms-sample" id="frm_register" name="frm_register" method="post" role="form"
          action="{{ route('add-users') }}" enctype="multipart/form-data">
          <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
          <!-- Popup Title -->
          <h4 class="popup-title">Add User Details</h4>
          <hr />

          <!-- Select Options -->
          <div class="row mb-3">
            <label class="col-6 form-label">Select Location</label>
            <div class="col-6">
              <select class="form-select" name="location">
              @foreach ($locationsData as $locationItem)
                <option value="{{ $locationItem['id'] }}">{{ $locationItem['location'] }}</option>
                @endforeach
                <!-- <option>Los Angeles</option>
                <option>Chicago</option> -->
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <label class="form-label col-6">Select Role</label>
            <div class="col-6">
              <select class="form-select" name="role">
                <option value="Admin">Admin</option>
                <option value="Editor">Editor</option>
                <option value="Viewer">Viewer</option>
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <label class="form-label col-6">Enter Name</label>
            <div class="col-6">
              <input
                type="text"
                class="form-control"
                placeholder="Enter Name"
                name="name"
              />
            </div>
          </div>
          <div class="row mb-3">
            <label class="form-label col-6">Enter Phone</label>
            <div class="col-6">
              <input
                type="text"
                class="form-control"
                placeholder="Enter Phone"
                name="phone"
              />
            </div>
          </div>
          <div class="row mb-3">
            <label class="form-label col-6">Enter mail</label>
            <div class="col-6">
              <input
                type="text"
                class="form-control"
                placeholder="Enter mail"
                name="email"
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
                name="password"
              />
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
      <div id="editPopupUser" class="popup-container">
        <div class="popup-content">

        <form class="forms-sample" id="frm_register" name="frm_register" method="post" role="form"
          action="{{ route('update-users') }}" enctype="multipart/form-data">
          <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
          <!-- Popup Title -->
          <h4 class="popup-title">Edit User Details</h4>
          <hr />
          <input type="hidden" class="form-control" placeholder="Enter Location Name" name="edit_id" id="edit-user-id"/>

          <!-- Select Options -->
          <div class="row mb-3">
            <label class="col-6 form-label">Select Location</label>
            <div class="col-6">
              <select class="form-select" name="location" id="location">
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
                <option>Admin</option>
                <option>Editor</option>
                <option>Viewer</option>
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <label class="form-label col-6">Enter Name</label>
            <div class="col-6">
              <input
                type="text"
                class="form-control"
                placeholder="Enter Name"
                name="name" id="name"
              />
            </div>
          </div>
          <div class="row mb-3">
            <label class="form-label col-6">Enter Phone</label>
            <div class="col-6">
              <input
                type="text"
                class="form-control"
                placeholder="Enter Phone"
                name="phone" id="phone"
              />
            </div>
          </div>
          <div class="row mb-3">
            <label class="form-label col-6">Enter mail</label>
            <div class="col-6">
              <input
                type="text"
                class="form-control"
                placeholder="Enter mail"
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
            <button id="cancelDelete" class="btn br">NO</button>
            <button id="confirmDeleteUser" class="btn">YES</button>
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
        alert("User deleted successfully!");
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
      url: '{{ route('edit-users') }}', // Your route to fetch the location data
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
        $('#role').val(response.user_data.role); // Set location value
        $('#email').val(response.user_data.email); // Set location value
        $('#phone').val(response.user_data.phone); // Set location value
        $('#password').val(response.user_data.password); // Set location value
        $('#edit-user-id').val(response.user_data.id); // Set role value
        // Select the correct location
        $('#location').val(response.user_data.location).change();
        
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