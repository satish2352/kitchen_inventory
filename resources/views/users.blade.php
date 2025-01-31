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
          <div class="person add-user">
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
          <!-- User Request Box -->
          <div class="user-request-box p-3 shadow rounded mb-2">
            <!-- Top Row -->
            <div class="d-flex justify-content-between align-items-center">
              <!-- Left Section -->
              <div>
                <div class="d-flex align-items-center">
                  <span class="ur-user me-2 jost-font">Autumn Kellar</span>
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

          <!-- Select Options -->
          <div class="row mb-3">
            <label class="col-6 form-label">Select Location</label>
            <div class="col-6">
              <select class="form-select">
                <option>New York</option>
                <option>Los Angeles</option>
                <option>Chicago</option>
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <label class="form-label col-6">Select Role</label>
            <div class="col-6">
              <select class="form-select">
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
              />
            </div>
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