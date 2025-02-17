@include('layouts.header')
@include('layouts.sidebar')
@yield('content')
<style>
    .select2 {
        width: 100% !important;
    }

    .select2-container--default .select2-selection--multiple {
        border: var(--bs-border-width) solid var(--bs-border-color);
        border-radius: var(--bs-border-radius);
    }

    .select2-container--default .select2-selection--multiple:after {
        content: "⌄";
        font-family: FontAwesome;
        font-size: 16px;
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
    }


/* Pagination styles */
.pagination {
    margin: 20px 0;
    margin-left:17px;
}

.pagination ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.pagination ul li {
    display: inline;
    margin-right: 5px;
}

.pagination ul li a,
.pagination ul li span {
    padding: 5px 10px;
    border: 1px solid #ccc;
    text-decoration: none;
    color: #333;
}

.pagination ul li.active a {
    background-color: #007bff;
    color: #fff;
    border-color: #007bff;
}

.pagination ul li.disabled span {
    color: #ccc;
}

img, svg {
    vertical-align: middle;
    width: 2%;
}

div.dataTables_wrapper div.dataTables_info {
    display: none;
}
div.dataTables_wrapper div.dataTables_paginate ul.pagination{
    display: none; 
}
.pagination .flex .flex{
    display: none; 
}

@media (max-width: 472px) {
    .pagination ul {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        padding: 0;
    }

    .pagination ul li {
        margin: 2px;
    }

    .pagination ul li:nth-child(n+1) {
        margin-top: 15px;
    }

    .pagination ul li a,
    .pagination ul li span {
        padding: 8px 12px;
        font-size: 14px;
    }

    .pagination ul li.active a {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
    }
}

    @media only screen and (min-width: 373px) and (max-width: 544px) {
    .added_by_css {
        margin-top: 2.5rem;
        margin-bottom: 0.3rem;
        margin-left: -17.5rem !important;
    }
    }

    @media only screen and (min-width: 278px) and (max-width: 282px) {
    .added_by_css {
        margin-top: 6rem;
        margin-bottom: 0.2rem;
        margin-left: -11.5rem !important;
    }
    .user_name_css{
        word-break: break-word;
        max-width: 100%;
    }
    }

.btn_css:hover{
    color: blue;
}


.select2-container--default .select2-selection--multiple .select2-selection__clear {
    margin-right: 25px !important;
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
         <h5 class="sub-title">Users</h5>
         <!-- person -->
         <button class="btn btn-light add-btn">
         <i class="bi bi-plus-lg"></i>
         <span>Add User</span>
         </button>
         <!-- <div class="person add-user add-btn">
            <i class="bi bi-person"></i>
            <span>Add User</span>
            </div> -->
         <!-- <button class="person add-user add-btn">
            <i class="bi bi-person"></i>
            <span>Add User</span>
            </button> -->
      </div>
   </div>
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
            <input type="text" class="form-control" placeholder="Search..." aria-label="Search"
               id="search-query" />
            <button class="btn btn-srh" type="button">
            <i class="bi bi-search"></i>
            </button>
         </div>
         <!-- Location Icon -->
         <!-- <button class="btn btn-white mx-2">
            <i class="bi bi-geo-alt-fill"></i>
            </button> -->
      </div>
   </div>
   <!-- user requestion section  -->
   <div class="user-request pb-3">
      @if (!empty($user_data) && count($user_data) > 0)
      <div class="container-fluid px-3" id="search-results">
         @foreach ($user_data as $item)
         <!-- User Request Box -->
         <div class="user-request-box p-3 shadow rounded mb-2">
            <!-- Top Row -->
            <div class="d-flex justify-content-between align-items-center">
               <!-- Left Section -->
               <div>
                  <div class="d-flex">
                     <span class="ur-user me-2 jost-font user_name_css">{{ $item->name }}
                     @if ($item->user_role == '1')
                     (Super Admin)
                     @elseif($item->user_role == '2')
                     (Admin)
                     @else
                     (Night Manager)
                     @endif
                     </span>
                     @if($item->is_approved == 1 && $item->added_by == 2 && $item->user_role == 3)
                     <div class="status-badge ms-2 d-flex align-items-center added_by_css">
                        <i class="bi bi-check-circle-fill text-success me-1"></i>
                        <span style="color:white">Added By Admin</span>
                     </div>
                     @endif
                  </div>
                  <p class="mb-1 fw-light"><b>Email ID :</b> {{ $item->email }}</p>
                  <p class="mb-1 fw-light"><b>Mobile No. :</b> {{ $item->phone }}</p>
                  <p class="mb-1 fw-light"><b>Locations :</b>
                     @if (!empty($item->locations))
                     {{ implode(', ', $item->locations) }}
                     @else
                     N/A
                     @endif
                  </p>
               </div>
               <!-- Right Section -->
               <div>
                  @if ($item->user_role != '1')
                  <button class="btn btn-edit text-center shadow-sm edit-btn-user"
                     data-id="{{ $item->id }}">
                  <i class="bi bi-pencil-square"></i> <br />Edit
                  </button>
                  @endif
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
      </div>
      <div class="mt-3">
         <div class="col-md-8">
            <div class="pagination">
               @if ($user_data->lastPage() > 1)
               <ul class="pagination">
                  <li class="{{ ($user_data->currentPage() == 1) ? ' disabled' : '' }}">
                     @if ($user_data->currentPage() > 1)
                     <a href="{{ $user_data->url($user_data->currentPage() - 1) }}">Previous</a>
                     @else
                     <span>Previous</span>
                     @endif
                  </li>
                  @php
                  $currentPage = $user_data->currentPage();
                  $lastPage = $user_data->lastPage();
                  $startPage = max($currentPage - 5, 1);
                  $endPage = min($currentPage + 4, $lastPage);
                  @endphp
                  @if ($startPage > 1)
                  <li>
                     <a href="{{ $user_data->url(1) }}">1</a>
                  </li>
                  @if ($startPage > 2)
                  <li>
                     <span>...</span>
                  </li>
                  @endif
                  @endif
                  @for ($i = $startPage; $i <= $endPage; $i++)
                  <li class="{{ ($currentPage == $i) ? ' active' : '' }}">
                     <a href="{{ $user_data->url($i) }}">{{ $i }}</a>
                  </li>
                  @endfor
                  @if ($endPage < $lastPage)
                  @if ($endPage < $lastPage - 1)
                  <li>
                     <span>...</span>
                  </li>
                  @endif
                  <li>
                     <a href="{{ $user_data->url($lastPage) }}">{{ $lastPage }}</a>
                  </li>
                  @endif
                  <li class="{{ ($currentPage == $lastPage) ? ' disabled' : '' }}">
                     @if ($currentPage < $lastPage)
                     <a href="{{ $user_data->url($currentPage + 1) }}">Next</a>
                     @else
                     <span>Next</span>
                     @endif
                  </li>
                  <!-- <li>
                     <span>Page {{ $currentPage }}</span>
                     </li> -->
               </ul>
               @endif
            </div>
         </div>
         <!-- Pagination for each category -->
      </div>
      @else
      <div class="border-box mb-4" id="search-results">
         <!-- Header Title -->
         <div class="grid-header text-center">
            <h6 class="m-0 text-white">No Data Found</h6>
         </div>
      </div>
      @endif
   </div>
   <!-- add popup  -->
   <div id="addPopup" class="popup-container">
      <div class="popup-content">
         <form class="forms-sample" id="frm_register_add" name="frm_register" method="post" role="form"
            action="{{ route('add-users') }}" enctype="multipart/form-data">
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
            <!-- Popup Title -->
            <h4 class="popup-title">Add User Details</h4>
            <hr />
            <!-- <div class="row mb-3">
               <label class="col-md-6 col-sm-12 col-lg-6 form-label">Select Location</label>
               <div class="col-md-6 col-sm-12 col-lg-6">
                   <select class="form-select select2" name="location[]" multiple
                       data-placeholder="Select Location">
                       <option value="">Select Location</option>
                       @foreach ($locationsData as $locationItem)
                           <option value="{{ $locationItem['id'] }}">{{ $locationItem['location'] }}</option>
                       @endforeach
                   </select>
               </div>
               </div> -->
            <div class="row mb-3">
               <label class="col-md-6 col-sm-12 col-lg-6 form-label">Select Location</label>
               <div class="col-md-6 col-sm-12 col-lg-6">
                  <select class="form-select select2" name="location[]" multiple
                     data-placeholder="Select Location" id="locationSelect">
                     <option value="">Select Location</option>
                     @foreach ($locationsData as $locationItem)
                     <option value="{{ $locationItem['id'] }}">{{ $locationItem['location'] }}</option>
                     @endforeach
                  </select>
               </div>
            </div>
            <div class="row mb-3">
               <label class="form-label col-md-6 col-sm-12 col-lg-6">Select Role</label>
               <div class="col-md-6 col-sm-12 col-lg-6">
                  <select class="form-select" name="role" id="roleid">
                     <option value="">Select Role</option>
                     <!-- <option value="1">Super Admin</option> -->
                     <option value="2">Admin</option>
                     <option value="3">Night Manager</option>
                  </select>
               </div>
            </div>
            <div class="row mb-3">
               <label class="form-label col-md-6 col-sm-12 col-lg-6">Enter User Name</label>
               <div class="col-md-6 col-sm-12 col-lg-6">
                  <input type="text" class="form-control" placeholder="Enter User Name" name="name"
                     style="text-transform: capitalize;" />
               </div>
            </div>
            <div class="row mb-3">
               <label class="form-label col-md-6 col-sm-12 col-lg-6">Enter Mobile Number</label>
               <div class="col-md-6 col-sm-12 col-lg-6">
                  <input type="text" class="form-control" placeholder="Enter Mobile Number"
                     name="phone" />
                  <span id="validation-message" class="red-text"></span>
                  <!-- @if ($errors->has('phone'))
                     <span class="red-text"><?php echo $errors->first('phone', ':message'); ?></span>
                     @endif -->
               </div>
            </div>
            <div class="row mb-3">
               <label class="form-label col-md-6 col-sm-12 col-lg-6">Enter Email Id</label>
               <div class="col-md-6 col-sm-12 col-lg-6">
                  <input type="text" class="form-control" placeholder="Enter Email Id" name="email" />
               </div>
               <!-- @error('email')
                  <div class="alert alert-danger">{{ $message }}</div>
                  @enderror -->
               @if ($errors->has('email'))
               <span class="red-text"><?php echo $errors->first('email', ':message'); ?></span>
               @endif
            </div>
            <div class="row mb-3">
               <label class="form-label col-md-6 col-sm-12 col-lg-6">Enter password</label>
               <div class="col-md-6 col-sm-12 col-lg-6">
                  <input type="text" class="form-control" placeholder="Enter password" name="password" />
               </div>
            </div>
            <hr />
            <div class="d-flex justify-content-around">
               <a class="btn btn-secondary btn-lg w-100 me-2" id="closePopup">
               <i class="bi bi-x-circle"></i> Cancel
               </a>
               <!-- <a  class="btn btn-outline-danger btn-delete-user btn-lg w-100 me-2">
                  <i class="bi bi-trash"></i> Delete
                  </a> -->
               <button class="btn btn-success btn-lg w-100">
               <i class="bi bi-plus-circle"></i> Submit
               </button>
            </div>
         </form>
      </div>
   </div>
   <!-- edit popup  -->
   <div id="editPopupUser" class="popup-container">
      <div class="popup-content">
         <form class="forms-sample" id="editUserForm" name="editUserForm" method="post" role="form"
            action="{{ route('update-users') }}" enctype="multipart/form-data">
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
            <!-- Popup Title -->
            <h4 class="popup-title">Edit User Details</h4>
            <hr />
            <input type="hidden" class="form-control" placeholder="Enter Location Name" name="edit_id"
               id="edit-user-id" />
            <div class="row mb-3">
               <label class="col-md-6 col-sm-12 col-lg-6 form-label">Select Location</label>
               <div class="col-md-6 col-sm-12 col-lg-6">
                  <select class="form-select select2" name="location[]" id="location" multiple>
                     <option value="">Select Location</option>
                     @foreach ($locationsData as $locationItem)
                     <option value="{{ $locationItem['id'] }}">{{ $locationItem['location'] }}</option>
                     @endforeach
                  </select>
               </div>
            </div>
            <div class="row mb-3">
               <label class="form-label col-md-6 col-sm-12 col-lg-6">Select Role</label>
               <div class="col-md-6 col-sm-12 col-lg-6">
                  <select class="form-select" name="role" id="role">
                     <option value="">Select Role</option>
                     <!-- <option value="1">Super Admin</option> -->
                     <option value="2">Admin</option>
                     <option value="3">Night Manager</option>
                  </select>
               </div>
            </div>
            <div class="row mb-3">
               <label class="form-label col-md-6 col-sm-12 col-lg-6">Enter User Name</label>
               <div class="col-md-6 col-sm-12 col-lg-6">
                  <input type="text" class="form-control" placeholder="Enter User Name" name="name"
                     id="name" style="text-transform: capitalize;" />
               </div>
            </div>
            <div class="row mb-3">
               <label class="form-label col-md-6 col-sm-12 col-lg-6">Enter Mobile Number</label>
               <div class="col-md-6 col-sm-12 col-lg-6">
                  <input type="text" class="form-control" placeholder="Enter Mobile Number" name="phone"
                     id="phone" />
               </div>
            </div>
            <div class="row mb-3">
               <label class="form-label col-md-6 col-sm-12 col-lg-6">Enter Email Id</label>
               <div class="col-md-6 col-sm-12 col-lg-6">
                  <input type="text" class="form-control" placeholder="Enter Email Id" name="email"
                     id="email" />
               </div>
            </div>
            <div class="row mb-3">
               <label class="form-label col-md-6 col-sm-12 col-lg-6">Enter password</label>
               <div class="col-md-6 col-sm-12 col-lg-6">
                  <input type="text" class="form-control" placeholder="Enter password" name="password"
                     id="password" />
               </div>
            </div>
            <hr />
            <div class="d-flex justify-content-around">
               <a class="btn btn-outline-danger btn-delete-user btn-lg w-100 me-2">
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
         <button id="cancelDelete" class="btn br btn_css">NO</button>
         <button id="confirmDeleteUser" class="btn btn_css">YES</button>
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
   
       const closePopUpButton = document.getElementById("closePopup");
   
       // Close Confirmation Popup on Cancel
       if (cancelDeleteButton) {
           cancelDeleteButton.addEventListener("click", (e) => {
               e.preventDefault(); // Prevent default behavior
               confirmPopupUser.style.display = "none"; // Hide popup
           });
       }
   
       // Close Popup when clicking outside
       popupuser.addEventListener("click", (e) => {
           if (e.target === popupuser) {
               popupuser.style.display = "none";
           }
       });
   
       popupadd.addEventListener("click", (e) => {
           if (e.target === popupadd) {
               document.getElementById("frm_register_add").reset();
            // Reset Select2 dropdowns manually
         $('#roleid').val(null).trigger('change');
       $('.select2').val([]).trigger('change');
               popupadd.style.display = "none";
           }
       });
   
         // Close Popup
     closePopUpButton.addEventListener("click", () => {
       document.getElementById("frm_register_add").reset();
   
       $('#roleid').val(null).trigger('change');
       $('.select2').val([]).trigger('change');
   
         popupadd.style.display = "none";
     });
   
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
           // alert("User deleted successfully!");
           // Add delete logic here
       });
   });
</script>

<script type="text/javascript">
   $(document).ready(function() {
       $.validator.addMethod("validPhone", function(value, element) {
           return /^[6-9]\d{9}$/.test(value); // Ensures 10-digit mobile number starting with 6-9
       }, "Please enter a valid 10-digit mobile number starting with 6-9.");
   
       // Add custom validation method
       $.validator.addMethod("passwordStrength", function(value, element) {
           return this.optional(element) ||
               /^(?=(?:[^a-zA-Z]*[a-zA-Z]){5,})(?=.*\d)(?=.*[@$!%*?&]).{6,}$/.test(value);
       }, "Password must contain at least 5 letters, 1 number, and 1 special character");
   
   
       // Initialize validation for the add form
       $("#frm_register_add").validate({
           rules: {
               "location[]": {
                   required: function() {
                       return $("#frm_register_add select[name='location[]'] option:selected")
                           .length === 0;
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
                   email: true,
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
                   required: "Please enter mobile number",
                   // number:"Please enter valid mobile number",
                   minlength: "Mobile number min length must be exactly 10 digits.",
                   maxlength: "Mobile number max length must be exactly 10 digits.",
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
           highlight: function(element) {
               $(element).addClass("is-invalid").removeClass("is-valid");
           },
           unhighlight: function(element) {
               $(element).addClass("is-valid").removeClass("is-invalid");
           },
           errorPlacement: function(error, element) {
               if (element.attr("name") === "location[]") {
                   error.insertAfter(element.closest(
                   ".form-select")); // Places the error message below the select field
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
                   email: true,
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
       $('.select2').select2();
   });
</script>

<script>
$(document).ready(function() {
    var originalData = $('#search-results').html();

    // Bind event using event delegation
    $(document).on('click', '.edit-btn-user', function() {
      //   alert('Edit button clicked');
        var locationId = $(this).data('id'); // Get the location ID from the button

        // AJAX request to get user data
        $.ajax({
            url: '{{ route('edit-users') }}', // Your route to fetch the user data
            type: 'GET',
            data: { locationId: locationId },
            success: function(response) {
                console.log('Response:', response.user_data);

                // Populate the edit form
                $('#name').val(response.user_data.name);
                $('#role').val(response.user_data.user_role);
                $('#email').val(response.user_data.email);
                $('#phone').val(response.user_data.phone);
                $('#password').val(response.user_data.password);
                $('#edit-user-id').val(response.user_data.id);

                // Handle multiple locations selection
                var selectedLocations = response.user_data.location.split(',');
                $('#location').val(selectedLocations).change();

                // Show the popup
                $('#editPopupUser').show();
                document.getElementById('editPopupUser').style.display = "flex";
            },
            error: function() {
                alert('Failed to load user data.');
            }
        });
    });

    // Bind keyup event to the search input
    $('#search-query').on('keyup', function() {
        var query = $(this).val().trim();

        if (query.length > 0) {
            $.ajax({
                url: "{{ route('users_search') }}",
                method: "GET",
                data: { query: query },
                success: function(response) {
                    if (response.length > 0) {
                        $('#search-results').html(response);
                    } else {
                        $('#search-results').html(`
                            <div class="border-box mb-4" id="search-results">
                                <div class="grid-header text-center">
                                    <h6 class="m-0 text-white">No Data Found</h6>
                                </div>
                            </div>
                        `);
                    }
                }
            });
        } else {
            $('#search-results').html(originalData);
        }
    });
});
</script>