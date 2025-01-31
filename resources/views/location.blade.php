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
          <h5 class="sub-title">Locations</h5>

          <button class="btn btn-light add-btn">
            <i class="bi bi-plus-lg"></i>
          </button>
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
      <div class="user-request">
        <div class="container-fluid px-3">
        @foreach ($locations_data as $item)
          <!-- User Request Box -->
          <div class="user-request-box p-3 shadow rounded mb-3">
            <!-- Top Row -->
            <div class="d-flex justify-content-between align-items-center">
              <!-- Left Section -->
              <div>
                <div class="d-flex align-items-center">
                  <span class="act-user me-2">{{ $item->location }}</span>
                </div>
                <p class="mb-1">{{ $item->role }}</p>
              </div>

              <!-- Right Section -->
              <div>
                <button class="btn btn-edit text-center shadow-sm edit-btn" data-id="{{ $item->id }}">
                  <i class="bi bi-pencil-square"></i> <br />Edit
                </button>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
          <!-- add popup -->

          <div id="addPopup" class="popup-container">
            <div class="popup-content">
              <form class="forms-sample" id="frm_register" name="frm_register" method="post" role="form"
                  action="{{ route('add-locations') }}" enctype="multipart/form-data">
                  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                    <!-- Popup Title -->
                    <h4 class="popup-title">Add Location</h4>
                    <hr />

                    <!-- Input Field for Location Name -->
                  <div class="row mb-3">
                    <label class="col-6 form-label">Location Name:</label>
                    <div class="col-6">
                      <input type="text" class="form-control" placeholder="Enter Location Name" name="location"/>
                    </div>
                  </div>

                    <!-- Select Role -->
                  <div class="row mb-3">
                    <label class="form-label col-6">Select Role:</label>
                    <div class="col-6">
                      <select class="form-select" name="role">
                        <option>Admin</option>
                        <option>Editor</option>
                        <option>Viewer</option>
                      </select>
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

           <!-- close add popup -->



      <!-- edit popup  -->
      <div id="editPopup" class="popup-container">
        <div class="popup-content">
        <form class="forms-sample" id="frm_register" name="frm_register" method="post" role="form"
          action="{{ route('update-locations') }}" enctype="multipart/form-data">
          <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />

          <!-- Popup Title -->
          <h4 class="popup-title">Edit Location</h4>
          <hr />

          <!-- Select Options -->
          <div class="row mb-3">
            <label class="col-6 form-label">Select Location:</label>
            <div class="col-6">
            <input type="text" class="form-control" placeholder="Enter Location Name" name="location" id="edit-location"/>
            <input type="hidden" class="form-control" placeholder="Enter Location Name" name="edit_id" id="edit-location-id"/>

              <!-- <select class="form-select" id="edit-location">
                <option>New York</option>
                <option>Los Angeles</option>
                <option>Chicago</option>
              </select> -->
            </div>
          </div>
          <div class="row mb-3">
            <label class="form-label col-6">Select Role:</label>
            <div class="col-6">
              <select class="form-select" name="role" id="edit-role">
                <option>Admin</option>
                <option>Editor</option>
                <option>Viewer</option>
              </select>
            </div>
          </div>

          <hr />
          <div class="d-flex justify-content-around">
            <a  class="btn btn-outline-danger btn-delete btn-lg w-100 me-2">
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
      <div id="confirmPopup" class="confirm-popup-container">
        <div class="confirm-popup-content">
          <h4 class="confirm-popup-title">Please Confirm</h4>
          <p class="confirm-popup-text">
            Are you sure to delete this user? <br />
            this user wil not recover back
          </p>
          <div class="d-flex justify-content-around mt-4 confrm">
            <button id="cancelDelete" class="btn br">NO</button>
            <button id="confirmDelete" class="btn">YES</button>
          </div>
        </div>
      </div>
    </div>

    <form method="POST" action="{{ url('/delete-locations') }}" id="deleteform">
            @csrf
            <input type="hidden" name="delete_id" id="delete_id" value="">
        </form>
        <script>
 @extends('layouts.footer')
 // Perform Action on Confirm Delete
      confirmDeleteButton.addEventListener("click", () => {
        confirmPopup.style.display = "none";
                $("#delete_id").val($("#edit-location-id").val());
                $("#deleteform").submit();
        alert("User deleted successfully!");
        // Add delete logic here
      });

      // Open Popup
      editButton.addEventListener("click", () => {
        popup.style.display = "flex";
      });
    
      // Close Popup when clicking outside
      popup.addEventListener("click", (e) => {
        if (e.target === popup) {
          popup.style.display = "none";
        }
      });
    
      // Show Confirmation Popup
      deleteButton.addEventListener("click", () => {
        popup.style.display = "none"; // Close the bottom popup
        confirmPopup.style.display = "flex"; // Show the confirmation popup
      });
      </script>