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
<style>
   /* Pagination styles */
   .pagination {
   margin: 20px 0;
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
   /* Make table scrollable on small screens */
   .table-container {
   overflow-x: auto;
   width: 100%;
   }
   /* Ensure table does not wrap text in cells */
   .table-responsive table {
   white-space: nowrap;
   }
   /* Optional: Add shadow and border for better visibility */
   .table-responsive {
   border: 1px solid #ddd;
   border-radius: 5px;
   padding: 5px;
   background: #fff;
   }
   .btn_css:hover{
   color: blue;
   }
   /* .master_inventory_css{
   margin-left: 10px;
   }
   .copy_inventory_css{
   margin-right: 7px;
   }
   @media only screen and (min-width: 0px) and (max-width: 557px) {
   .master_inventory_css{
   font-size: 18px;
   }
   }
   @media (max-width: 330px) {
   .inner-top .d-flex {
   flex-direction: column;
   align-items: center;
   }
   .inner-top .d-flex > * {
   width: 100%;
   text-align: center;
   margin-bottom: 5px;
   }
   .inner-top .d-flex > .d-flex {
   flex-direction: row;
   justify-content: center;
   gap: 5px;
   }
   }
   @media only screen and (min-width: 328px) and (max-width: 464px) {
   .master_inventory_css{
   font-size: 14px;
   }
   } */
   @media (max-width: 460px) {
   .top-bar {
   flex-wrap: wrap;
   }
   .button-wrapper {
   width: 100%;
   display: flex;
   justify-content: center;
   margin-top: 8px; /* Adjust spacing */
   }
   }
   @media screen and (max-width: 768px) {
   .table-responsive {
   display: block;
   width: 100%;
   overflow-x: auto;
   -webkit-overflow-scrolling: touch;
   }
   table {
   width: 100%;
   min-width: 600px; /* Adjust as per your table content */
   }
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
   .copy_inventory_css{
   background-color: lightgrey;
   border: 1px solid lightgrey;
   }
</style>
<div class="main">
<div class="inner-top container-fluid p-3">
   <!-- Top Bar -->
   <div class="top-bar d-flex justify-content-between align-items-center flex-wrap">
      <a href="{{ route('/dashboard') }}">
      <button class="btn btn-light btn-sm">
      <i class="bi bi-arrow-90deg-left"></i>
      </button>
      </a>
      <h5 class="sub-title master_inventory_css text-center flex-grow-1 mb-0">Master Inventory</h5>
      <!-- Buttons Wrapper -->
      <div class="button-wrapper d-flex gap-2">
         <button class="btn btn-light copy-inventory-btn copy_inventory_css">Copy Inventory</button>
         <button class="btn btn-light add-btn">Add Inventory</button>
      </div>
   </div>
</div>
<!-- --------------------------- -->
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
         <label class="form-label col-md-6 col-sm-12 col-lg-6">Select Location</label>
         <div class="col-md-6 col-sm-12 col-lg-6">
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
   @if(session()->get('location_selected_id') != '')
   @if (!empty($user_data) && count($user_data) > 0)
   @foreach ($user_data as $category_id => $items)
   @php
   $category = \App\Models\Category::find($category_id); // Get category name
   @endphp
   <!-- Border Box -->
   <div class="border-box">
      <!-- Header Title -->
      <div class="grid-header text-center">
         <h6 class="m-0 text-white">{{ $category->category_name ?? 'Unknown Category' }}</h6>
      </div>
      <!-- Table -->
      <div class="table-responsive" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
         <table class="table table-striped">
            <!-- Table Head -->
            <thead class="table-header">
               <tr>
                  <th><b>Sr. No.</b></th>
                  <th><b>Item</b></th>
                  <th><b>Qty</b></th>
                  <th><b>Unit</b></th>
                  <th><b>Price</b></th>
                  <th><b>Action</b></th>
               </tr>
            </thead>
            <!-- Table Body -->
            <tbody>
               @php $srNo = 1; @endphp
               @foreach ($items as $item)
               <tr>
                  <td>{{ $srNo++ }}</td>
                  <td>{{ $item->item_name }}</td>
                  <td>{{ $item->quantity }}</td>
                  <td>{{ $item->unit_name }}</td>
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
      <!-- Pagination for this category -->
      <!-- <div class="d-flex justify-content-center">
         <div class="col-md-8 d-flex justify-content-center">
            <div class="pagination">
               @if ($items->lastPage() > 1)
               <ul class="pagination">
                  <li class="{{ ($items->currentPage() == 1) ? ' disabled' : '' }}">
                     @if ($items->currentPage() > 1)
                     <a href="{{ $items->url($items->currentPage() - 1) }}">Previous</a>
                     @else
                     <span>Previous</span>
                     @endif
                  </li>
                  @php
                  $currentPage = $items->currentPage();
                  $lastPage = $items->lastPage();
                  $startPage = max($currentPage - 5, 1);
                  $endPage = min($currentPage + 4, $lastPage);
                  @endphp
                  @if ($startPage > 1)
                  <li>
                     <a href="{{ $items->url(1) }}">1</a>
                  </li>
                  @if ($startPage > 2)
                  <li>
                     <span>...</span>
                  </li>
                  @endif
                  @endif
                  @for ($i = $startPage; $i <= $endPage; $i++)
                  <li class="{{ ($currentPage == $i) ? ' active' : '' }}">
                     <a href="{{ $items->url($i) }}">{{ $i }}</a>
                  </li>
                  @endfor
                  @if ($endPage < $lastPage)
                  @if ($endPage < $lastPage - 1)
                  <li>
                     <span>...</span>
                  </li>
                  @endif
                  <li>
                     <a href="{{ $items->url($lastPage) }}">{{ $lastPage }}</a>
                  </li>
                  @endif
                  <li class="{{ ($currentPage == $lastPage) ? ' disabled' : '' }}">
                     @if ($currentPage < $lastPage)
                     <a href="{{ $items->url($currentPage + 1) }}">Next</a>
                     @else
                     <span>Next</span>
                     @endif
                  </li>
                 
               </ul>
               @endif
            </div>
         </div>
 
      </div> -->
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
            <label class="col-md-6 col-sm-12 col-lg-6 form-label">Select Location</label>
            <div class="col-md-6 col-sm-12 col-lg-6">
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
            <label class="col-md-6 col-sm-12 col-lg-6 form-label">Select Category</label>
            <div class="col-md-6 col-sm-12 col-lg-6">
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
            <label class="form-label col-md-6 col-sm-12 col-lg-6">Item Name</label>
            <div class="col-md-6 col-sm-12 col-lg-6">
               <input
                  type="text"
                  class="form-control"
                  placeholder="Enter Name"
                  name="item_name" style="text-transform: capitalize;"
                  />
            </div>
         </div>
         <div class="row mb-3">
            <label class="form-label col-md-6 col-sm-12 col-lg-6">Quantity</label>
            <div class="col-md-6 col-sm-12 col-lg-6">
               <input
                  type="text"
                  class="form-control"
                  placeholder="Enter Quantity"
                  name="quantity"
                  />
            </div>
         </div>
         <div class="row mb-3">
            <label class="col-md-6 col-sm-12 col-lg-6 form-label">Select Unit</label>
            <div class="col-md-6 col-sm-12 col-lg-6">
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
            <label class="form-label col-md-6 col-sm-12 col-lg-6">Price</label>
            <div class="col-md-6 col-sm-12 col-lg-6">
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
            <label class="col-md-6 col-sm-12 col-lg-6 form-label">Select Location</label>
            <div class="col-md-6 col-sm-12 col-lg-6">
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
            <label class="col-md-6 col-sm-12 col-lg-6 form-label">Select Category</label>
            <div class="col-md-6 col-sm-12 col-lg-6">
               <select class="form-select" name="category" id="category">
                  <option value="">Select Category</option>
                  @foreach ($categoryData as $categoryItem)
                  <option value="{{ $categoryItem['id'] }}">{{ $categoryItem['category_name'] }}</option>
                  @endforeach
               </select>
            </div>
         </div>
         <div class="row mb-3">
            <label class="form-label col-md-6 col-sm-12 col-lg-6">Item Name</label>
            <div class="col-md-6 col-sm-12 col-lg-6">
               <input
                  type="text"
                  class="form-control" style="text-transform: capitalize;"
                  name="item_name" id="item_name"
                  />
            </div>
         </div>
         <div class="row mb-3">
            <label class="form-label col-md-6 col-sm-12 col-lg-6">Quantity</label>
            <div class="col-md-6 col-sm-12 col-lg-6">
               <input
                  type="text"
                  class="form-control"
                  placeholder="Enter Quantity"
                  name="quantity" id="quantity"
                  />
            </div>
         </div>
         <div class="row mb-3">
            <label class="form-label col-md-6 col-sm-12 col-lg-6">Select Unit</label>
            <div class="col-md-6 col-sm-12 col-lg-6">
               <select class="form-select" name="unit" id="unit">
                  <option value="">Select Unit</option>
                  @foreach ($unitData as $unitItem)
                  <option value="{{ $unitItem['id'] }}">{{ $unitItem['unit_name'] }}</option>
                  @endforeach
               </select>
            </div>
         </div>
         <div class="row mb-3">
            <label class="form-label col-md-6 col-sm-12 col-lg-6">Price</label>
            <div class="col-md-6 col-sm-12 col-lg-6">
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
            <label class="col-md-6 col-sm-12 col-lg-6 form-label">Select From Location</label>
            <div class="col-md-6 col-sm-12 col-lg-6">
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
            <label class="col-md-6 col-sm-12 col-lg-6 form-label">Select To Location</label>
            <div class="col-md-6 col-sm-12 col-lg-6">
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
            <a class="btn btn-secondary btn-lg w-100 me-2" id="closePopupCopyInventory">
            <i class="bi bi-x-circle"></i> Cancel
            </a>
            <button class="btn btn-danger btn-lg w-100">
            <i class="bi bi-plus-lg"></i> Copy
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
         <button id="cancelDeleteConfirm" class="btn br btn_css">NO</button>
         <button id="confirmDeleteItem" class="btn btn_css">YES</button>
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
     const confirmSelectButton = document.getElementById("confirmDeleteItem");
     // const cancelcategory = document.getElementById("cancelcategory");
     // const confirmcategory = document.getElementById("confirmcategory");
   
   const deleteButton = document.querySelector(".btn-delete-item");
   
     const addButton = document.querySelector(".add-btn");
     const popupadd = document.getElementById("addPopup");
     const confirmPopupDelete = document.getElementById("confirmPopupDelete");
   const cancelDeleteConfirm = document.getElementById("cancelDeleteConfirm");
   
   const copyInventoryButton = document.querySelector(".copy-inventory-btn");
   const CopyInventoryPopup = document.getElementById("CopyInventoryPopup");
   const closePopupCopyInventory = document.getElementById("closePopupCopyInventory");
   const closePopUpButton = document.getElementById("closePopup");
   
   
   
   copyInventoryButton.addEventListener("click", () => {
     CopyInventoryPopup.style.display = "flex";
     });
   
   cancelDeleteConfirm.addEventListener("click", () => {
     popup.style.display = "flex";
     });
   
      // Close Popup when clicking outside
      CopyInventoryPopup.addEventListener("click", (e) => {
       if (e.target === CopyInventoryPopup) {
         CopyInventoryPopup.style.display = "none";
       }
     });
   
     // Close Popup
     closePopupCopyInventory.addEventListener("click", () => {
     document.getElementById("frm_copy_inventory").reset();
   
     // Reset Select2 dropdowns manually
       $('.select2').val(null).trigger('change');
   
       CopyInventoryPopup.style.display = "none";
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
     // cancelSelectButton.addEventListener("click", () => {
     //   confirmPopup.style.display = "none";
     // });
   
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
     // cancelcategory.addEventListener("click", () => {
     //   filterPopup.style.display = "none";
     // });
   
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
     // confirmcategory.addEventListener("click", () => {
     //   filterPopup.style.display = "none";
     //   // alert("User deleted successfully!");
     //   // Add delete logic here
     // });
   });
</script>
<script>
   $(document).ready(function() {
    // alert('kkkkkkkkkkkkkk');
    // Open the popup when Edit button is clicked
    // $('.edit-btn-item').on('click', function() {
      $(document).on('click', '.edit-btn-item', function() {
   
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
   
     $(document).ready(function () {
     $.validator.addMethod("differentLocation", function (value, element) {
         return $("#FromLocationId").val() !== $("#ToLocationId").val();
     }, "From Location and To Location cannot be the same.");
   
     $("#frm_copy_inventory").validate({
         rules: {
             from_location_id: {
                 required: true
             },
             to_location_id: {
                 required: true,
                 differentLocation: true // Custom rule
             }
         },
         messages: {
             from_location_id: {
                 required: "Please select the from Location"
             },
             to_location_id: {
                 required: "Please select the to Location",
                 differentLocation: "The From location and To location must be different."
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