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
          <h5 class="sub-title">Category</h5>
          <!-- <a href="approve-users.html"> -->
            <button class="btn btn-light add-btn">
              <i class="bi bi-plus-lg"></i>
            </button>
          <!-- </a> -->
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
                <p class="mb-1 activity-p">{{ $item->created_at }}</p>
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
      <div id="editPopupCategory" class="popup-container">
        <div class="popup-content">
        <form class="forms-sample" id="frm_register" name="frm_register" method="post" role="form"
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
                id="category_id"
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
            Are you sure to delete this user? <br />
            this user wil not recover back
          </p>
          <div class="d-flex justify-content-around mt-4 confrm">
            <button id="cancelDelete" class="btn br">NO</button>
            <button id="confirmDeleteCategory" class="btn">YES</button>
          </div>
        </div>
      </div>
    </div>
    <form method="POST" action="{{ url('/delete-locations') }}" id="deleteform">
            @csrf
            <input type="hidden" name="delete_id" id="delete_id" value="">
        </form>
    
 @extends('layouts.footer')


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