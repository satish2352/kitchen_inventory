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

          <!-- User Request Box -->
          <div class="user-request-box p-3 shadow rounded mb-2">
            <!-- Top Row -->
            <div class="d-flex justify-content-between align-items-center">
              <!-- Left Section -->
              <div>
                <div class="d-flex align-items-center">
                  <span class="ur-user me-2 jost-font">Autumn Kellar</span>
                  <div class="status-badge ms-2 d-flex align-items-center">
                    <i class="bi bi-check-circle-fill text-success me-1"></i>
                    <span>Approved</span>
                  </div>
                </div>
                <p class="mb-1 fw-light">Ribanz@buffaloboss.com</p>
                <p class="mb-1 fw-light">87900179854</p>
              </div>

              <!-- Right Section -->
              <div>
                <button class="btn btn-edit text-center shadow-sm edit-btn">
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
          <div class="user-request-box p-3 shadow rounded mb-2">
            <!-- Top Row -->
            <div class="d-flex justify-content-between align-items-center">
              <!-- Left Section -->
              <div>
                <div class="d-flex align-items-center">
                  <span class="ur-user me-2 jost-font">Autumn Kellar</span>
                  <div class="status-badge ms-2 d-flex align-items-center">
                    <i class="bi bi-x-circle-fill text-success me-1"></i>
                    <span>Unapproved</span>
                  </div>
                </div>
                <p class="mb-1 fw-light">Ribanz@buffaloboss.com</p>
                <p class="mb-1 fw-light">87900179854</p>
              </div>

              <!-- Right Section -->
              <div>
                <button class="btn btn-edit text-center shadow-sm">
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
        </div>
      </div>
      <!-- edit popup  -->
      <div id="editPopup" class="popup-container">
        <div class="popup-content">
          <!-- Popup Title -->
          <h4 class="popup-title">Edit User Details</h4>
          <hr />

          <!-- User Details -->
          <div>
            <span class="ur-user me-2">Autumn Kellar</span>
            <p class="mb-1">johndoe@example.com</p>
            <p class="mb-1">+1 234 567 890</p>
          </div>

          <!-- Select Options -->
          <div class="row mb-3">
            <label class="col-6 form-label">Select Location:</label>
            <div class="col-6">
              <select class="form-select">
                <option>New York</option>
                <option>Los Angeles</option>
                <option>Chicago</option>
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <label class="form-label col-6">Select Role:</label>
            <div class="col-6">
              <select class="form-select">
                <option>Admin</option>
                <option>Editor</option>
                <option>Viewer</option>
              </select>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="d-flex justify-content-between align-items-center">
            <button class="btn btn-outline-danger w-100">Approve</button>
          </div>
          <hr />
          <div class="d-flex justify-content-around">
            <button class="btn btn-outline-danger btn-delete btn-lg w-100 me-2">
              <i class="bi bi-trash"></i> Delete
            </button>
            <button class="btn btn-danger btn-lg w-100">
              <i class="bi bi-arrow-repeat"></i> Update
            </button>
          </div>
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

 @extends('layouts.footer')