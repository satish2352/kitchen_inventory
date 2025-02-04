@include('layouts.header')
@include('layouts.sidebar')

@yield('content')


<style>
    .error-text {
        color: red;
        font-size: 12px;
    }

    .is-invalid {
        border-color: red;
    }

    .is-valid {
        border-color: green;
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
            <h5 class="sub-title">Locations</h5>
            <button class="btn btn-light add-btn">
                <i class="bi bi-plus-lg"></i>
            </button>
        </div>
    </div>
    <div class="filter">
        <div class="shopping-list-row d-flex align-items-center p-3">
            <!-- Search Input -->
            <!-- <div class="input-group search-input">
                <input type="text" class="form-control" placeholder="Search..." aria-label="Search" />
                <button class="btn btn-srh" type="button">
                    <i class="bi bi-search"></i>
                </button>
            </div> -->
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
            <button class="btn btn-white mx-2">
                <i class="bi bi-geo-alt-fill"></i>
            </button>
        </div>
    </div>

    <!-- user requestion section  -->
    <div class="user-request">
        <div class="container-fluid px-3" id="search-results">
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
                            <!-- <p class="mb-1">{{ $item->role }}</p> -->
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
                        <input type="text" class="form-control" placeholder="Enter Location Name" name="location"
                            style="text-transform: capitalize;" />
                    </div>
                </div>

                <!-- Select Role -->
                <!-- <div class="row mb-3">
                    <label class="form-label col-6">Select Role:</label>
                    <div class="col-6">
                      <select class="form-select" name="role">
                        <option>Admin</option>
                        <option>Editor</option>
                        <option>Viewer</option>
                      </select>
                    </div>
                  </div> -->

                <hr />
                <div class="d-flex justify-content-around">
                    <!-- <button class="btn btn-secondary btn-lg w-100 me-2">
                        <i class="bi bi-x-circle"></i> Cancel
                    </button> -->
                    <a class="btn btn-secondary btn-lg w-100 me-2" id="closePopup">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
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
            <form class="forms-sample" id="editLocationForm" name="editLocationForm" method="post" role="form"
                action="{{ route('update-locations') }}" enctype="multipart/form-data">
                <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />

                <!-- Popup Title -->
                <h4 class="popup-title">Edit Location</h4>
                <hr />

                <!-- Select Options -->
                <div class="row mb-3">
                    <label class="col-6 form-label">Select Location:</label>
                    <div class="col-6">
                        <input type="text" class="form-control" placeholder="Enter Location Name" name="location"
                            id="edit-location" style="text-transform: capitalize;" />
                        <input type="hidden" class="form-control" placeholder="Enter Location Name" name="edit_id"
                            id="edit-location-id" />

                        <!-- <select class="form-select" id="edit-location">
                <option>New York</option>
                <option>Los Angeles</option>
                <option>Chicago</option>
              </select> -->
                    </div>
                </div>
                <div class="row mb-3">
                    <!-- <label class="form-label col-6">Select Role:</label>
            <div class="col-6">
              <select class="form-select" name="role" id="edit-role">
                <option>Admin</option>
                <option>Editor</option>
                <option>Viewer</option>
              </select>
            </div>
          </div> -->

                    <hr />
                    <div class="d-flex justify-content-around">
                        <a class="btn btn-outline-danger btn-delete btn-lg w-100 me-2">
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
                Are you sure to delete this Location? <br />
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


@extends('layouts.footer')
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
        const deleteButton = document.querySelector(".btn-delete");
        const editButton = document.querySelector(".edit-btn");
        const popup = document.getElementById("editPopup");
        const addButton = document.querySelector(".add-btn");
        const popupadd = document.getElementById("addPopup");
        const confirmPopup = document.getElementById("confirmPopup");
        const cancelDeleteButton = document.getElementById("cancelDelete");
        const confirmDeleteButton = document.getElementById("confirmDelete");

        // Open Popup
        addButton.addEventListener("click", () => {
            popupadd.style.display = "flex";
        });

        // Perform Action on Confirm Delete
        confirmDeleteButton.addEventListener("click", () => {
            confirmPopup.style.display = "none";
            $("#delete_id").val($("#edit-location-id").val());
            $("#deleteform").submit();
            alert("Location deleted successfully!");
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

        // Close Popup when clicking outside
        popupadd.addEventListener("click", (e) => {
            if (e.target === popupadd) {
                popupadd.style.display = "none";
            }
        });

        // Show Confirmation Popup
        deleteButton.addEventListener("click", () => {
            // alert('jjjjjjjjjjjjjj');
            popup.style.display = "none"; // Close the bottom popup
            confirmPopup.style.display = "flex"; // Show the confirmation popup
        });

    });
</script>

<script>
    $(document).ready(function() {
        // Open the popup when Edit button is clicked
        $('.edit-btn').on('click', function() {
            var locationId = $(this).data('id'); // Get the location ID from the button

            // AJAX request to get location data
            $.ajax({
                url: '{{ route('edit-locations') }}', // Your route to fetch the location data
                type: 'GET',
                data: {
                    locationId: locationId
                },
                success: function(response) {
                    // console.log('responseresponseresponseresponse',response.location_data);
                    // alert('ppppppppppppppppppp');
                    // Populate the popup with the fetched data
                    $('#edit-location').val(response.location_data
                    .location); // Set location value
                    // $('#edit-role').val(response.location_data.role); // Set role value
                    $('#edit-location-id').val(response.location_data.id); // Set role value

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
        // Close the popup if clicked outside (optional)
        // $(document).on('click', function(event) {
        //   if (!$(event.target).closest('#editPopup, .edit-btn').length) {
        //     $('#editPopup').hide();
        //   }
        // });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        // Initialize validation for the add form
        $("#frm_register").validate({
            rules: {
                location: {
                    required: true,
                    minlength: 3
                }
            },
            messages: {
                location: {
                    required: "Please enter the Location name",
                    minlength: "Location name must be at least 3 characters long"
                }
            },
            errorElement: "span",
            errorClass: "error-text",
            highlight: function(element) {
                $(element).addClass("is-invalid").removeClass("is-valid");
            },
            unhighlight: function(element) {
                $(element).addClass("is-valid").removeClass("is-invalid");
            }
        });

        // Initialize validation for the edit form
        $("#editLocationForm").validate({
            rules: {
                location: {
                    required: true,
                    minlength: 3
                }
            },
            messages: {
                location: {
                    required: "Please enter the Location name",
                    minlength: "Location name must be at least 3 characters long"
                }
            },
            errorElement: "span",
            errorClass: "error-text",
            highlight: function(element) {
                $(element).addClass("is-invalid").removeClass("is-valid");
            },
            unhighlight: function(element) {
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
                    url: "{{ route('search-locations') }}",  // Define your search route here
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
                // $('#search-results').html('');
                $('#search-results').html(originalData);
            }
        });
    });
</script>
