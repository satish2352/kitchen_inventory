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

          <button class="btn btn-light">
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
              <tbody>
                <tr>
                  <td>1</td>
                  <td>9/2/2023</td>
                  <td>Rolls</td>
                  <td>
                    <button
                      class="btn text-center shadow-sm btn-sm edit-btn mu-edit"
                    >
                      <i class="bi bi-pencil-square"></i> Edit
                    </button>
                  </td>
                </tr>
                <tr>
                  <td>1</td>
                  <td>9/2/2023</td>
                  <td>Rolls</td>
                  <td>
                    <button class="btn text-center shadow-sm btn-sm mu-edit">
                      <i class="bi bi-pencil-square"></i> Edit
                    </button>
                  </td>
                </tr>
                <tr>
                  <td>1</td>
                  <td>9/2/2023</td>
                  <td>Rolls</td>
                  <td>
                    <button class="btn text-center shadow-sm btn-sm mu-edit">
                      <i class="bi bi-pencil-square"></i> Edit
                    </button>
                  </td>
                </tr>
                <tr>
                  <td>1</td>
                  <td>9/2/2023</td>
                  <td>Rolls</td>
                  <td>
                    <button class="btn text-center shadow-sm btn-sm mu-edit">
                      <i class="bi bi-pencil-square"></i> Edit
                    </button>
                  </td>
                </tr>
                <tr>
                  <td>1</td>
                  <td>9/2/2023</td>
                  <td>Rolls</td>
                  <td>
                    <button class="btn text-center shadow-sm btn-sm mu-edit">
                      <i class="bi bi-pencil-square"></i> Edit
                    </button>
                  </td>
                </tr>
                <tr>
                  <td>1</td>
                  <td>9/2/2023</td>
                  <td>Rolls</td>
                  <td>
                    <button class="btn text-center shadow-sm btn-sm mu-edit">
                      <i class="bi bi-pencil-square"></i> Edit
                    </button>
                  </td>
                </tr>
                <tr>
                  <td>1</td>
                  <td>9/2/2023</td>
                  <td>Rolls</td>
                  <td>
                    <button class="btn text-center shadow-sm btn-sm mu-edit">
                      <i class="bi bi-pencil-square"></i> Edit
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- edit popup  -->
      <div id="editPopup" class="popup-container">
        <div class="popup-content">
          <!-- Popup Title -->
          <h4 class="popup-title">Add Unit</h4>
          <hr />

          <!-- Select Options -->
          <div class="row mb-3">
            <label class="col-6 form-label">Unit</label>
            <div class="col-6">
           
           <select class="form-select">
            <option value="1">1</option>
            <option value="1">1</option>
            <option value="1">1</option>
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