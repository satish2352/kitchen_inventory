@include('layouts.header')
@include('layouts.sidebar')

@yield('content')

<!-- <style>
    /* Custom styling for select dropdown */
    .select2-dropdown {
        max-height: 200px !important; /* Set a max height */
        overflow-y: auto !important; /* Enable scrolling */
    }
</style> -->

<div class="main">
      <div class="inner-top container-fluid p-3">
        <!-- Top Bar -->
        <div class="d-flex justify-content-between align-items-center">
          <a href="{{ route('/dashboard') }}">
            <button class="btn btn-light">
              <i class="bi bi-arrow-90deg-left"></i>
            </button>
          </a>
          <h5 class="sub-title">Master Inventory</h5>

          <button class="btn btn-light copy-inventory-btn">
            <i class="bi bi-plus-lg">Copy Inventory</i>
          </button>
        </div>
      </div>
<!-- 
      @if(session('alert_status'))
    <p>Session Status: {{ session('alert_status') }}</p>
    <p>Session Message: {{ session('alert_msg') }}</p>
@endif -->
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
                  id="search-query"/>
              <button class="btn btn-srh" type="button">
                  <i class="bi bi-search"></i>
              </button>
          </div>

          <!-- Location Icon -->
          <!-- <button class="btn btn-white mx-2">
            <i class="bi bi-geo-alt-fill"></i>
          </button> -->

          <!-- Bar Grid Icon -->
          <!-- <button class="btn btn-white btn-category">
            <i class="bi bi-filter"></i>
          </button> -->
        </div>
      </div>
      <div class="container-fluid px-3">
        <!-- <div class="d-flex align-items-center justify-content-between">
          <label>Show last submitted Kitchen list</label>
          <div class="form-check form-switch">
            <input
              class="form-check-input custom-checkbox"
              type="checkbox"
              role="switch"
              checked="checked"
            />
          </div>
        </div> -->
        <!-- <div class="d-flex align-items-center justify-content-between">
          <label>Select Multiplier</label>
          <button type="button" class="btn btn-select rounded-5 btn-sm">
            Select
          </button>
        </div> -->
        <form id="locationForm" method="post" action="{{ route('location-selected-admin') }}">
                    @csrf
                    <div class="row mb-3">
                        <label class="form-label col-6">Select Location</label>
                        <div class="col-6">
                            <select class="form-select" name="location_selected" id="location_selected">
                                <option value="">Select Location</option>
                                @foreach ($locationsData as $locations)
                                    <option value="{{ $locations['id'] }}"
                                        @if (session('location_selected') == $locations['id']) selected @endif>{{ $locations['location'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
      </div>

      <div class="container-fluid px-3" id="search-results">
      @if(session()->get('location_selected_id') !='')

      @if (!empty($user_data) && count($user_data) > 0)
      
      @foreach ($user_data as $category => $items)

      
        <!-- Border Box -->
        <div class="border-box">
          <!-- Header Title -->
          <div class="grid-header text-center">
            <h6 class="m-0 text-white">{{ $category }}</h6>
          </div>

          <!-- Table -->
          <div class="table-responsive">
            <table class="table table-striped">
              <!-- Table Head -->
              <thead class="table-header">
                <tr>
                  <th>Sr. No.</th>
                  <th>Item</th>
                  <th>Qty</th>
                  <th>Unit</th>
                  <!-- <th>IX</th> -->
                  <th>Price</th>
                  <th>Action</th>
                </tr>
              </thead>
              <!-- Table Body -->
              <tbody>

              @php $srNo = 1; @endphp
              @foreach ($items as $item)
                <tr>
                <td>{{ $srNo++ }}</td>
                  <td>{{ $item->item_name }}</td>
                  <!-- <td>
                    <input type="text" name="quantity" class="form-control qty-input" />
                  </td> -->
                  <td>{{ $item->quantity }}</td>
                  <td>{{ $item->unit_name }}</td>
                  <!-- <td>7</td> -->
                  <td>${{ $item->price }}</td>
                  <td>
                    <div>
                      <button class="btn btn-edit text-center shadow-sm edit-btn-item" data-id="{{ $item->id }}">
                        <i class="bi bi-pencil-square"></i> <br />Edit
                      </button>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        @endforeach

        @else
        <div class="border-box mb-4" id="search-results">
                <!-- Header Title -->
                <div class="grid-header text-center">
                    <h6 class="m-0 text-white">Please Add Inventory For This location</h6>
                </div>
            </div>  
        @endif

        @else
           <div class="border-box mb-4" id="search-results">
                <!-- Header Title -->
                <div class="grid-header text-center">
                    <h6 class="m-0 text-white">Please Select Location First</h6>
                </div>
            </div>    
           @endif
      </div>

      <!-- edit popup  -->
      <div id="addPopup" class="popup-container">
        <div class="popup-content">

        <form class="forms-sample" id="frm_register_add" name="frm_register" method="post" role="form"
          action="{{ route('add-items') }}" enctype="multipart/form-data">
          <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
          <!-- Popup Title -->
          <h4 class="popup-title">Add Master Inventory</h4>
          <hr />

          <div class="row mb-3">
                    <label class="col-6 form-label">Select Location</label>
                    <div class="col-6">
                        <select class="form-select select2" name="location_id"
                            data-placeholder="Select Location" id="locationSelect">
                            <option value="">Select Location</option>
                            @foreach ($locationsData as $locationItem)
                                <option value="{{ $locationItem['id'] }}">{{ $locationItem['location'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


          <div class="row mb-3">
              <label class="col-6 form-label">Select Category</label>
              <div class="col-6">
                  <select class="form-select select2" name="category"
                      data-placeholder="Select Category">
                      <option value="">Select Category</option>
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
                name="item_name" style="text-transform: capitalize;"
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
                name="quantity"
              />
            </div> 
          </div>

          <div class="row mb-3">
              <label class="col-6 form-label">Select Unit</label>
              <div class="col-6">
                  <select class="form-select select2" name="unit"
                      data-placeholder="Select Unit">
                      <option value="">Select Unit</option>
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
          <a class="btn btn-secondary btn-lg w-100 me-2" id="closePopup">
              <i class="bi bi-x-circle"></i> Cancel
            </a>
            
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
        <form class="forms-sample" id="editUserForm" name="editUserForm" method="post" role="form"
          action="{{ route('update-items') }}" enctype="multipart/form-data">
          <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
          <!-- Popup Title -->
          <h4 class="popup-title">Edit items</h4>
          <hr />
          <input type="hidden" class="form-control" placeholder="Enter Location Name" name="edit_id" id="edit-item-id"/>

          <div class="row mb-3">
            <label class="col-6 form-label">Select Location</label>
            <div class="col-6">
              <select class="form-select" name="location_id" id="location_id">
                <option value="">Select Location</option>
                @foreach ($locationsData as $locationItem)
                  <option value="{{ $locationItem['id'] }}">{{ $locationItem['location'] }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <!-- Select Options -->
          <div class="row mb-3">
            <label class="col-6 form-label">Select Category</label>
            <div class="col-6">
              <select class="form-select" name="category" id="category">
                <option value="">Select Category</option>
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
                class="form-control" style="text-transform: capitalize;"
                name="item_name" id="item_name"
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
                name="quantity" id="quantity"
              />
            </div>
          </div>
          <div class="row mb-3">
            <label class="form-label col-6">Select Unit</label>
            <div class="col-6">
              <select class="form-select" name="unit" id="unit">
                <option value="">Select Unit</option>
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
                name="price" id="price"
              />
            </div>
          </div>

          <hr />
          <!-- <div class="d-flex justify-content-around">
            <button class="btn btn-danger btn-lg w-100">
              <i class="bi bi-plus-lg"></i> ADD
            </button>
          </div> -->

          <div class="d-flex justify-content-around">
            <a  class="btn btn-outline-danger btn-delete-item btn-lg w-100 me-2">
              <i class="bi bi-trash"></i> Delete
            </a>
            <button class="btn btn-danger btn-lg w-100">
              <i class="bi bi-arrow-repeat"></i> Update
            </button>
          </div>
        </form>
        </div>
      </div>

      <div id="CopyInventoryPopup" class="popup-container">
        <div class="popup-content">

        <form class="forms-sample" id="frm_copy_inventory" name="frm_copy_inventory" method="post" role="form"
          action="{{ route('copy-master-inventory') }}" enctype="multipart/form-data">
          <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
          <!-- Popup Title -->
          <h4 class="popup-title">Copy Master Inventory</h4>
          <hr />

                <div class="row mb-3">
                  <label class="col-6 form-label">Select From Location</label>
                  <div class="col-6">
                      <select class="form-select select2" name="from_location_id"
                          data-placeholder="Select Location" id="FromLocationId">
                          <option value="">Select Location</option>
                          @foreach ($locationsData as $locationItem)
                              <option value="{{ $locationItem['id'] }}">{{ $locationItem['location'] }}</option>
                          @endforeach
                      </select>
                  </div>  
                </div>

                <div class="row mb-3">
                  <label class="col-6 form-label">Select To Location</label>
                  <div class="col-6">
                      <select class="form-select select2" name="to_location_id"
                          data-placeholder="Select Location" id="ToLocationId">
                          <option value="">Select Location</option>
                          @foreach ($locationsData as $locationItem)
                              <option value="{{ $locationItem['id'] }}">{{ $locationItem['location'] }}</option>
                          @endforeach
                      </select>
                  </div>
                </div>

          <hr />
          <div class="d-flex justify-content-around">
          <a class="btn btn-secondary btn-lg w-100 me-2" id="closePopup">
              <i class="bi bi-x-circle"></i> Cancel
            </a>
            
            <button class="btn btn-danger btn-lg w-100">
              <i class="bi bi-plus-lg"></i> ADD
            </button>
          </div>
        </form>
        </div>
      </div>


      <!-- Delete Confirmation Popup -->
      <div id="confirmPopupDelete" class="confirm-popup-container">
        <div class="confirm-popup-content">
          <h4 class="confirm-popup-title">Please Confirm</h4>
          <p class="confirm-popup-text">
            Are you sure to delete this Inventory? <br />
            this Inventory will not recover back
          </p>
          <div class="d-flex justify-content-around mt-4 confrm">
            <button id="cancelDeleteConfirm" class="btn br">NO</button>
            <button id="confirmDeleteItem" class="btn">YES</button>
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

    <form method="POST" action="{{ url('/delete-items') }}" id="deleteform">
            @csrf
            <input type="hidden" name="delete_id" id="delete_id" value="">
        </form>
 @extends('layouts.footer')

 <script>
    document.getElementById('location_selected').addEventListener('change', function() {
        var locationId= this.value;
        if(locationId !='')
        {
            document.getElementById('locationForm').submit();
        }
    });
</script>

 <script type="text/javascript">
      document.addEventListener("DOMContentLoaded", () => {
        // const selectButton = document.querySelector(".btn-select");
        // const selectcategory = document.querySelector(".btn-category");
        const editButton = document.querySelector(".edit-btn-item");
        const editButtons = document.querySelectorAll(".edit-btn-item");
        const popup = document.getElementById("editPopup");
        const confirmPopup = document.getElementById("confirmPopup");
        const filterPopup = document.getElementById("filterPopup");
        const cancelSelectButton = document.getElementById("cancelDelete");
        const confirmSelectButton = document.getElementById("confirmDelete");
        const cancelcategory = document.getElementById("cancelcategory");
        const confirmcategory = document.getElementById("confirmcategory");

      const deleteButton = document.querySelector(".btn-delete-item");

        const addButton = document.querySelector(".add-btn");
        const popupadd = document.getElementById("addPopup");
        const confirmPopupDelete = document.getElementById("confirmPopupDelete");
      const cancelDeleteConfirm = document.getElementById("cancelDeleteConfirm");
      const closePopUpButton = document.getElementById("closePopup");

      const copyInventoryButton = document.querySelector(".copy-inventory-btn");
      const CopyInventoryPopup = document.getElementById("CopyInventoryPopup");


      copyInventoryButton.addEventListener("click", () => {
        CopyInventoryPopup.style.display = "flex";
        });

      cancelDeleteConfirm.addEventListener("click", () => {
        popup.style.display = "flex";
        });

      if (editButtons.length > 0) {
        editButtons.forEach(button => {
            button.addEventListener("click", function () {
              popup.style.display = "flex";
            });
        });
    }

        // Open Popup
        // editButton.addEventListener("click", () => {
        //   popup.style.display = "flex";
        // });

        addButton.addEventListener("click", () => {
          popupadd.style.display = "flex";
        });

         // Close Popup when clicking outside
         popupadd.addEventListener("click", (e) => {
          if (e.target === popupadd) {
            document.getElementById("frm_register_add").reset();
             // Reset Select2 dropdowns manually
          $('.select2').val(null).trigger('change');
            popupadd.style.display = "none";
          }
        });

        // Close Popup
      closePopUpButton.addEventListener("click", () => {
        document.getElementById("frm_register_add").reset();

        // Reset Select2 dropdowns manually
          $('.select2').val(null).trigger('change');

          popupadd.style.display = "none";
      });
        // Close Popup when clicking outside
        popup.addEventListener("click", (e) => {
          if (e.target === popup) {
            popup.style.display = "none";
          }
        });

        // Show Confirmation Popup
        // selectButton.addEventListener("click", () => {
        //   popup.style.display = "none"; // Close the bottom popup
        //   confirmPopup.style.display = "flex"; // Show the confirmation popup
        // });

        // Close Confirmation Popup on Cancel
        cancelSelectButton.addEventListener("click", () => {
          confirmPopup.style.display = "none";
        });

        // Perform Action on Confirm Delete
        confirmSelectButton.addEventListener("click", () => {
          confirmPopup.style.display = "none";
          // alert("User deleted successfully!");
          // Add delete logic here
        });
        // Show Category Popup
        // selectcategory.addEventListener("click", () => {
        //   popup.style.display = "none"; // Close the bottom popup
        //   filterPopup.style.display = "flex"; // Show the confirmation popup
        // });

        // Close Category Popup on Cancel
        cancelcategory.addEventListener("click", () => {
          filterPopup.style.display = "none";
        });

        deleteButton.addEventListener("click", () => {
        popup.style.display = "none"; // Close the bottom popup
        confirmPopupDelete.style.display = "flex"; // Show the confirmation popup
      });

      confirmDeleteItem.addEventListener("click", () => {
        confirmPopupDelete.style.display = "none";
                $("#delete_id").val($("#edit-item-id").val());
                $("#deleteform").submit();
        // alert("Item deleted successfully!");
        // Add delete logic here
      });

        // Perform Action on Category
        confirmcategory.addEventListener("click", () => {
          filterPopup.style.display = "none";
          // alert("User deleted successfully!");
          // Add delete logic here
        });
      });
    </script>

<script>
 $(document).ready(function() {
  // alert('kkkkkkkkkkkkkk');
  // Open the popup when Edit button is clicked
  $('.edit-btn-item').on('click', function() {
    var locationId = $(this).data('id'); // Get the location ID from the button
    
    // AJAX request to get location data
    $.ajax({
      url: '{{ route('edit-items') }}', // Your route to fetch the location data
      type: 'GET',
      data: {
                locationId: locationId
            },
      success: function(response) {
        console.log('responseresponseresponseresponse',response.user_data);
        // alert('ppppppppppppppppppp');
        // Populate the popup with the fetched data
        // $('#location').val(response.user_data.location); // Set location value
        $('#category').val(response.user_data.category); // Set location value
        $('#item_name').val(response.user_data.item_name); // Set location value
        $('#unit').val(response.user_data.unit); // Set location value
        $('#price').val(response.user_data.price); // Set location value
        $('#quantity').val(response.user_data.quantity); // Set quantity value
        $('#location_id').val(response.user_data.location_id); // Set location value
        $('#edit-item-id').val(response.user_data.id);
        // Show the popup
        $('#editPopup').show();

// Add the CSS property for flex display
document.getElementById('editPopup').style.display = "flex";
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

    // Initialize validation for the add form
    $("#frm_register_add").validate({
      rules: {
        location_id: {
          required: true
          // minlength: 3
        },
        category: {
          required: true
          // minlength: 3
        },
        unit: {
          required: true
          // minlength: 3
        },
        quantity: {
          required: true
          // minlength: 3
        },
        item_name: {
          required: true
          // minlength: 3
        },
        price: {
          required: true,
          number: true,
          min: 0
          // minlength: 3
        }
        
      },
      messages: {
        location_id: {
          required: "Please select the Location"
          // minlength: "Category name must be at least 3 characters long"
        },
        category: {
          required: "Please select the category name"
          // minlength: "Category name must be at least 3 characters long"
        },
        unit: {
          required: "Please select the unit"
          // minlength: "Category name must be at least 3 characters long"
        },
        quantity: {
          required: "Please select the Quantity"
          // minlength: "Category name must be at least 3 characters long"
        },
        item_name: {
          required: "Please enter item name"
          // minlength: "Category name must be at least 3 characters long"
        },
        price: {
          required: "Please enter price",
          number: "Please enter a valid number.",
          min: "Price cannot be negative."
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
    // Initialize validation for the add form
    $("#editUserForm").validate({
      rules: {
        location: {
          required: true
          // minlength: 3
        },
        unit: {
          required: true
          // minlength: 3
        },
        item_name: {
          required: true
          // minlength: 3
        },
        price: {
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

    $("#frm_register_add").validate({
      rules: {
        location_id: {
          required: true
          // minlength: 3
        },
        category: {
          required: true
          // minlength: 3
        },
        unit: {
          required: true
          // minlength: 3
        },
        quantity: {
          required: true
          // minlength: 3
        },
        item_name: {
          required: true
          // minlength: 3
        },
        price: {
          required: true,
          number: true,
          min: 0
          // minlength: 3
        }
        
      },
      messages: {
        location_id: {
          required: "Please select the Location"
          // minlength: "Category name must be at least 3 characters long"
        },
        category: {
          required: "Please select the category name"
          // minlength: "Category name must be at least 3 characters long"
        },
        unit: {
          required: "Please select the unit"
          // minlength: "Category name must be at least 3 characters long"
        },
        quantity: {
          required: "Please select the Quantity"
          // minlength: "Category name must be at least 3 characters long"
        },
        item_name: {
          required: "Please enter item name"
          // minlength: "Category name must be at least 3 characters long"
        },
        price: {
          required: "Please enter price",
          number: "Please enter a valid number.",
          min: "Price cannot be negative."
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

<script>
    $(document).ready(function() {
      var originalData = $('#search-results').html();
        // Bind keyup event to the search input
        $('#search-query').on('keyup', function() {
            var query = $(this).val().trim();  // Get the value entered in the search box

            if (query.length > 0) {
                $.ajax({
                    url: "{{ route('search-master-kitchen-inventory') }}",  // Define your search route here
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