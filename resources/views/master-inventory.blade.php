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
          <h5 class="sub-title">Master Inventory</h5>

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

          <!-- Bar Grid Icon -->
          <button class="btn btn-white btn-category">
            <i class="bi bi-filter"></i>
          </button>
        </div>
      </div>
      <div class="container-fluid px-3">
        <div class="d-flex align-items-center justify-content-between">
          <label>Show last submitted Kitchen list</label>
          <div class="form-check form-switch">
            <input
              class="form-check-input custom-checkbox"
              type="checkbox"
              role="switch"
              checked="checked"
            />
          </div>
        </div>
        <div class="d-flex align-items-center justify-content-between">
          <label>Select Multiplier</label>
          <button type="button" class="btn btn-select rounded-5 btn-sm">
            Select
          </button>
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
                  <th>Item</th>
                  <!-- <th>Qty</th> -->
                  <th>Unit</th>
                  <!-- <th>IX</th> -->
                  <th>Price</th>
                  <!-- <th>Total</th> -->
                </tr>
              </thead>
              <!-- Table Body -->
              <tbody>


              @foreach ($user_data as $item)
                <tr>
                  <td>{{ $item->item_name }}</td>
                  <!-- <td>
                    <input type="text" name="quantity" class="form-control qty-input" />
                  </td> -->
                  <td>{{ $item->unit_name }}</td>
                  <!-- <td>7</td> -->
                  <td>${{ $item->price }}</td>
                  <!-- <td>$123</td> -->
                </tr>
                @endforeach



              </tbody>
            </table>
          </div>
        </div>
        <!-- Border Box -->
        <div class="border-box mb-4">
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
                  <th>Item</th>
                  <th>Qty</th>
                  <th>Unit</th>
                  <th>IX</th>
                  <th>Price</th>
                  <th>Total</th>
                </tr>
              </thead>
              <!-- Table Body -->
              <tbody>
                <tr>
                  <td>Wings</td>
                  <td>
                    <input type="text" class="form-control qty-input" />
                  </td>
                  <td>Pans</td>
                  <td>7</td>
                  <td>$1.65</td>
                  <td>$123</td>
                </tr>
                <tr>
                  <td>Wings</td>
                  <td>
                    <input type="text" class="form-control qty-input" />
                  </td>
                  <td>Pans</td>
                  <td>7</td>
                  <td>$1.65</td>
                  <td>$123</td>
                </tr>
                <tr>
                  <td>Wings</td>
                  <td>
                    <input type="text" class="form-control qty-input" />
                  </td>
                  <td>Pans</td>
                  <td>7</td>
                  <td>$1.65</td>
                  <td>$123</td>
                </tr>
                <tr>
                  <td>Wings</td>
                  <td>
                    <input type="text" class="form-control qty-input" />
                  </td>
                  <td>Pans</td>
                  <td>7</td>
                  <td>$1.65</td>
                  <td>$123</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- edit popup  -->
      <div id="addPopup" class="popup-container">
        <div class="popup-content">

        <form class="forms-sample" id="frm_register" name="frm_register" method="post" role="form"
          action="{{ route('add-items') }}" enctype="multipart/form-data">
          <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
          <!-- Popup Title -->
          <h4 class="popup-title">Add items</h4>
          <hr />

          <!-- Select Options -->
          <div class="row mb-3">
            <label class="col-6 form-label">Select Category</label>
            <div class="col-6">
              <select class="form-select" name="category">
              @foreach ($categoryData as $categoryItem)
                <option value="{{ $categoryItem['id'] }}">{{ $categoryItem['category_name'] }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <label class="form-label col-6">Item Name</label>
            <div class="col-6">
              <input
                type="text"
                class="form-control"
                placeholder="Enter Name"
                name="item_name"
              />
            </div>
          </div>
          <!-- <div class="row mb-3">
            <label class="form-label col-6">Quantity</label>
            <div class="col-6">
              <input
                type="text"
                class="form-control"
                placeholder="Enter Quantity"
                name="quantity"
              />
            </div> -->
          </div>
          <div class="row mb-3">
            <label class="form-label col-6">Select Unit</label>
            <div class="col-6">
              <select class="form-select" name="unit">
              @foreach ($unitData as $unitItem)
                <option value="{{ $unitItem['id'] }}">{{ $unitItem['unit_name'] }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <label class="form-label col-6">Price</label>
            <div class="col-6">
              <input
                type="text"
                class="form-control"
                placeholder="Enter Price"
                name="price"
              />
            </div>
          </div>

          <hr />
          <div class="d-flex justify-content-around">
            <button class="btn btn-danger btn-lg w-100">
              <i class="bi bi-plus-lg"></i> ADD
            </button>
          </div>
</form>
        </div>
      </div>



      <!-- edit popup  -->
      <div id="editPopup" class="popup-container">
        <div class="popup-content">
          <!-- Popup Title -->
          <h4 class="popup-title">Add items</h4>
          <hr />

          <!-- Select Options -->
          <div class="row mb-3">
            <label class="col-6 form-label">Select Category</label>
            <div class="col-6">
              <select class="form-select">
                <option>New York</option>
                <option>Los Angeles</option>
                <option>Chicago</option>
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <label class="form-label col-6">Item Name</label>
            <div class="col-6">
              <input
                type="text"
                class="form-control"
                placeholder="Enter Name"
              />
            </div>
          </div>
          <div class="row mb-3">
            <label class="form-label col-6">Quantity</label>
            <div class="col-6">
              <input
                type="text"
                class="form-control"
                placeholder="Enter Quantity"
              />
            </div>
          </div>
          <div class="row mb-3">
            <label class="form-label col-6">Select Unit</label>
            <div class="col-6">
              <select class="form-select">
                <option>Admin</option>
                <option>Editor</option>
                <option>Viewer</option>
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <label class="form-label col-6">Price</label>
            <div class="col-6">
              <input
                type="text"
                class="form-control"
                placeholder="Enter Price"
              />
            </div>
          </div>

          <hr />
          <div class="d-flex justify-content-around">
            <button class="btn btn-danger btn-lg w-100">
              <i class="bi bi-plus-lg"></i> ADD
            </button>
          </div>
        </div>
      </div>

      <!-- Select Multiplier Popup -->
      <div id="confirmPopup" class="confirm-popup-container">
        <div class="confirm-popup-content">
          <h4 class="confirm-popup-title">Select Multiplier</h4>
          <hr />
          <div class="confirm-popup-text px-3">
            <div class="d-flex align-items-center justify-content-between pb-2">
              <label>1x All Quantity</label>
              <input type="radio" name="multiplier" id="" />
            </div>
            <div class="d-flex align-items-center justify-content-between pb-2">
              <label>2x All Quantity</label>
              <input type="radio" name="multiplier" id="" />
            </div>
            <div class="d-flex align-items-center justify-content-between pb-2">
              <label>3x All Quantity</label>
              <input type="radio" name="multiplier" id="" />
            </div>
            <div class="d-flex align-items-center justify-content-between pb-2">
              <label>4x All Quantity</label>
              <input type="radio" name="multiplier" id="" />
            </div>
            <div class="d-flex align-items-center justify-content-between">
              <label>5x All Quantity</label>
              <input type="radio" name="multiplier" id="" />
            </div>
          </div>
          <div class="d-flex justify-content-around mt-4 confrm">
            <button id="cancelDelete" class="btn br">Cancel</button>
            <button id="confirmDelete" class="btn">Confirm</button>
          </div>
        </div>
      </div>

      <!-- filter ccategory Popup -->
      <div id="filterPopup" class="confirm-popup-container">
        <div class="confirm-popup-content">
          <h4 class="confirm-popup-title">Filter Category</h4>
          <hr />
          <div class="confirm-popup-text px-3">
            <div class="d-flex align-items-center justify-content-between pb-2">
              <label>All </label>
              <input type="radio" name="category" id="" />
            </div>
            <div class="d-flex align-items-center justify-content-between pb-2">
              <label>Chicken/ Protiens</label>
              <input type="radio" name="category" id="" />
            </div>
            <div class="d-flex align-items-center justify-content-between pb-2">
              <label>Chicken/ Protiens</label>
              <input type="radio" name="category" id="" />
            </div>
            <div class="d-flex align-items-center justify-content-between pb-2">
              <label>Side Items</label>
              <input type="radio" name="category" id="" />
            </div>
            <div class="d-flex align-items-center justify-content-between">
              <label>Side Items</label>
              <input type="radio" name="category" id="" />
            </div>
          </div>
          <div class="d-flex justify-content-around mt-4 confrm">
            <button id="cancelcategory" class="btn br">Cancel</button>
            <button id="confirmcategory" class="btn">Confirm</button>
          </div>
        </div>
      </div>
    </div>
 @extends('layouts.footer')

 <script type="text/javascript">
      document.addEventListener("DOMContentLoaded", () => {
        const selectButton = document.querySelector(".btn-select");
        const selectcategory = document.querySelector(".btn-category");
        const editButton = document.querySelector(".edit-btn");
        const popup = document.getElementById("editPopup");
        const confirmPopup = document.getElementById("confirmPopup");
        const filterPopup = document.getElementById("filterPopup");
        const cancelSelectButton = document.getElementById("cancelDelete");
        const confirmSelectButton = document.getElementById("confirmDelete");
        const cancelcategory = document.getElementById("cancelcategory");
        const confirmcategory = document.getElementById("confirmcategory");

        const addButton = document.querySelector(".add-btn");
        const popupadd = document.getElementById("addPopup");

        // Open Popup
        // editButton.addEventListener("click", () => {
        //   popup.style.display = "flex";
        // });

        addButton.addEventListener("click", () => {
          popupadd.style.display = "flex";
        });

        // Close Popup when clicking outside
        popup.addEventListener("click", (e) => {
          if (e.target === popup) {
            popup.style.display = "none";
          }
        });

        // Show Confirmation Popup
        selectButton.addEventListener("click", () => {
          popup.style.display = "none"; // Close the bottom popup
          confirmPopup.style.display = "flex"; // Show the confirmation popup
        });

        // Close Confirmation Popup on Cancel
        cancelSelectButton.addEventListener("click", () => {
          confirmPopup.style.display = "none";
        });

        // Perform Action on Confirm Delete
        confirmSelectButton.addEventListener("click", () => {
          confirmPopup.style.display = "none";
          alert("User deleted successfully!");
          // Add delete logic here
        });
        // Show Category Popup
        selectcategory.addEventListener("click", () => {
          popup.style.display = "none"; // Close the bottom popup
          filterPopup.style.display = "flex"; // Show the confirmation popup
        });

        // Close Category Popup on Cancel
        cancelcategory.addEventListener("click", () => {
          filterPopup.style.display = "none";
        });

        // Perform Action on Category
        confirmcategory.addEventListener("click", () => {
          filterPopup.style.display = "none";
          alert("User deleted successfully!");
          // Add delete logic here
        });
      });
    </script>