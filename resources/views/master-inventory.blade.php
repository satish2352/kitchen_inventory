@include('layouts.header')
@include('layouts.sidebar')
@yield('content')

<style>
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

    img,
    svg {
        vertical-align: middle;
        width: 2%;
    }

    div.dataTables_wrapper div.dataTables_info {
        display: none;
    }

    div.dataTables_wrapper div.dataTables_paginate ul.pagination {
        display: none;
    }

    .pagination .flex .flex {
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

    .btn_css:hover {
        color: blue;
    }


    @media (max-width: 460px) {
        .top-bar {
            flex-wrap: wrap;
        }

        .button-wrapper {
            width: 100%;
            display: flex;
            justify-content: center;
            margin-top: 8px;
            /* Adjust spacing */
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
            min-width: 600px;
            /* Adjust as per your table content */
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

    .copy_inventory_css {
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
   @if (session('alert_status'))
<p>Session Status: {{ session('alert_status') }}</p>
   <p>Session Message: {{ session('alert_msg') }}</p>
@endif -->
    <div class="filter">
        <div class="shopping-list-row d-flex align-items-center p-3">

            <div class="input-group search-input">
                <input type="text" class="form-control" placeholder="Search..." aria-label="Search"
                    id="search-query" />
                <button class="btn btn-srh" type="button">
                    <i class="bi bi-search"></i>
                </button>
            </div>

        </div>
    </div>
    <div class="container-fluid px-3">

        <form id="locationForm" method="post" action="{{ route('location-selected-admin') }}">
            @csrf
            <div class="row mb-3">
                <label class="form-label col-md-6 col-sm-12 col-lg-6">Select Location</label>
                <div class="col-md-6 col-sm-12 col-lg-6">
                    <select class="form-select" name="location_selected" id="location_selected">
                        <option value="">Select Location</option>
                        @foreach ($locationsData as $locations)
                            <option value="{{ $locations['id'] }}" @if (session('location_selected') == $locations['id']) selected @endif>
                                {{ $locations['location'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </div>
    <div class="container-fluid px-3" id="search-results">
        @if (session()->get('location_selected_id') != '')
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
                            <table class="table table-striped" id="sortableTable_{{ $loop->index }}">
                                <!-- Table Head -->
                                <thead class="table-header">
                                    <tr>
                                        <th onclick="sortTable('sortableTable_{{ $loop->index }}', 0)"><b>Sr. No. <i
                                                    class="bi bi-arrow-up" id="arrow-0-{{ $loop->index }}"></i></b>
                                        </th>
                                        <th onclick="sortTable('sortableTable_{{ $loop->index }}', 1)"><b>Item <i
                                                    class="bi bi-arrow-up" id="arrow-1-{{ $loop->index }}"></i></b>
                                        </th>
                                        <th onclick="sortTable('sortableTable_{{ $loop->index }}', 2)"><b>Qty <i
                                                    class="bi bi-arrow-up" id="arrow-2-{{ $loop->index }}"></i></b>
                                        </th>
                                        <th onclick="sortTable('sortableTable_{{ $loop->index }}', 3)"><b>Unit <i
                                                    class="bi bi-arrow-up" id="arrow-3-{{ $loop->index }}"></i></b>
                                        </th>
                                        <th onclick="sortTable('sortableTable_{{ $loop->index }}', 4)"><b>Price <i
                                                    class="bi bi-arrow-up" id="arrow-4-{{ $loop->index }}"></i></b>
                                        </th>

                                        <th onclick="sortTable('sortableTable_{{ $loop->index }}', 5)"><b>Priority <i
                                                    class="bi bi-arrow-up" id="arrow-5-{{ $loop->index }}"></i></b>
                                        </th>

                                        <th><b>Action</b></th>
                                    </tr>
                                </thead>
                                <!-- Table Body -->
                                <tbody>
                                    @php $srNo = 1; @endphp
                                    @foreach ($items as $item)
                                        <tr>
                                            <td style="word-wrap: break-word; white-space: normal;">{{ $srNo++ }}
                                            </td>
                                            <td style="word-wrap: break-word; white-space: normal;">
                                                {{ $item->item_name }}</td>
                                            <td style="word-wrap: break-word; white-space: normal;">
                                                {{ $item->quantity }}</td>
                                            <td style="word-wrap: break-word; white-space: normal;">
                                                {{ $item->unit_name }}</td>
                                            <td style="word-wrap: break-word; white-space: normal;">
                                                ${{ $item->price }}</td>
                                            <td style="word-wrap: break-word; white-space: normal;">
                                                {{ $item->priority }}</td>
                                            <td>

                                                <div>
                                                    <button class="btn btn-edit text-center shadow-sm edit-btn-item"
                                                        data-id="{{ $item->id }}">
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
                        <h6 class="m-0 text-white">No Data Found</h6>
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
                        <select class="form-select select2" name="location_id" data-placeholder="Select Location"
                            id="locationSelect">
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
                        <select class="form-select select2" name="category" data-placeholder="Select Category">
                            <option value="">Select Category</option>
                            @foreach ($categoryData as $categoryItem)
                                <option value="{{ $categoryItem['id'] }}">{{ $categoryItem['category_name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="form-label col-md-6 col-sm-12 col-lg-6">Item Name</label>
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <input type="text" class="form-control" placeholder="Enter Name" name="item_name"
                            style="text-transform: capitalize;" />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="form-label col-md-6 col-sm-12 col-lg-6">Quantity</label>
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <input type="text" class="form-control" placeholder="Enter Quantity" name="quantity" />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-md-6 col-sm-12 col-lg-6 form-label">Select Unit</label>
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <select class="form-select select2" name="unit" data-placeholder="Select Unit">
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
                        <input type="text" class="form-control" placeholder="Enter Price" name="price" />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="form-label col-md-6 col-sm-12 col-lg-6">Priority
                    </label>
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <input type="text" class="form-control" placeholder="" name="priority" value="0" />
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
                <input type="hidden" class="form-control" placeholder="Enter Location Name" name="edit_id"
                    id="edit-item-id" />
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
                                <option value="{{ $categoryItem['id'] }}">{{ $categoryItem['category_name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="form-label col-md-6 col-sm-12 col-lg-6">Item Name</label>
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <input type="text" class="form-control" style="text-transform: capitalize;"
                            name="item_name" id="item_name" />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="form-label col-md-6 col-sm-12 col-lg-6">Quantity</label>
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <input type="text" class="form-control" placeholder="Enter Quantity" name="quantity"
                            id="quantity" />
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
                        <input type="text" class="form-control" placeholder="Enter Price" name="price"
                            id="price" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="form-label col-md-6 col-sm-12 col-lg-6">Priority
                    </label>
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <input type="text" class="form-control" placeholder="" id="priority" name="priority"
                            value="0" />
                    </div>
                </div>

                <hr />
                <div class="d-flex justify-content-around">
                    <a class="btn btn-outline-danger btn-delete-item btn-lg w-100 me-2">
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
            <form class="forms-sample" id="frm_copy_inventory" name="frm_copy_inventory" method="post"
                role="form" action="{{ route('copy-master-inventory') }}" enctype="multipart/form-data">
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
                        <select class="form-select select2" name="to_location_id" data-placeholder="Select Location"
                            id="ToLocationId">
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
            var locationId = this.value;
            if (locationId != '') {
                document.getElementById('locationForm').submit();
            }
        });
    </script>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", () => {
            const editButton = document.querySelector(".edit-btn-item");
            const editButtons = document.querySelectorAll(".edit-btn-item");
            const popup = document.getElementById("editPopup");
            const confirmPopup = document.getElementById("confirmPopup");
            const filterPopup = document.getElementById("filterPopup");
            const cancelSelectButton = document.getElementById("cancelDelete");
            const confirmSelectButton = document.getElementById("confirmDeleteItem");

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
                    button.addEventListener("click", function() {
                        popup.style.display = "flex";
                    });
                });
            }


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


            // Perform Action on Confirm Delete
            confirmSelectButton.addEventListener("click", () => {
                confirmPopup.style.display = "none";
            });

            deleteButton.addEventListener("click", () => {
                popup.style.display = "none"; // Close the bottom popup
                confirmPopupDelete.style.display = "flex"; // Show the confirmation popup
            });

            confirmDeleteItem.addEventListener("click", () => {
                confirmPopupDelete.style.display = "none";
                $("#delete_id").val($("#edit-item-id").val());
                $("#deleteform").submit();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.edit-btn-item', function() {
                showLoader();
                var locationId = $(this).data('id'); // Get the location ID from the button
                $.ajax({
                    url: '{{ route('edit-items') }}', // Your route to fetch the location data
                    type: 'GET',
                    data: {
                        locationId: locationId
                    },
                    success: function(response) {
                        $('#category').val(response.user_data.category);
                        $('#item_name').val(response.user_data.item_name);
                        $('#unit').val(response.user_data.unit);
                        $('#price').val(response.user_data.price);
                        $('#priority').val(response.user_data.priority);
                        $('#quantity').val(response.user_data.quantity);
                        $('#location_id').val(response.user_data.location_id);
                        $('#edit-item-id').val(response.user_data.id);
                        $('#editPopup').show();
                        document.getElementById('editPopup').style.display = "flex";
                        hideLoader();
                    },
                    error: function() {
                        alert('Failed to load location data.');
                        hideLoader();
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {

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
                highlight: function(element) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function(element) {
                    $(element).addClass("is-valid").removeClass("is-invalid");
                }
            });

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
                highlight: function(element) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function(element) {
                    $(element).addClass("is-valid").removeClass("is-invalid");
                }
            });

            $(document).ready(function() {
                $.validator.addMethod("differentLocation", function(value, element) {
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
                    highlight: function(element) {
                        $(element).addClass("is-invalid").removeClass("is-valid");
                    },
                    unhighlight: function(element) {
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
                showLoader();
                var query = $(this).val().trim(); // Get the value entered in the search box

                if (query.length > 0) {
                    $.ajax({
                        url: "{{ route('search-master-kitchen-inventory') }}", // Define your search route here
                        method: "GET",
                        data: {
                            query: query
                        },
                        success: function(response) {

                            if (response.length > 0) {
                                // Clear the previous results
                                $('#search-results').html('');

                                // Append the new search results
                                $('#search-results').html(response);
                                hideLoader();
                            } else {
                                // Clear the previous results
                                $('#search-results').html('No Data Found');
                                hideLoader();
                            }

                        }
                    });
                } else {
                    // Clear the results if input is empty
                    // $('#search-results').html('');
                    $('#search-results').html(originalData);
                    hideLoader();
                }
            });
        });
    </script>


    <script>
        // Store sort directions for each table by its ID
        var sortDirections = {};

        function sortTable(tableId, columnIndex) {
            var table = document.getElementById(tableId);
            var tbody = table.querySelector('tbody');
            var rows = Array.from(tbody.querySelectorAll('tr'));

            // Initialize sort directions for the table if not set yet
            if (!sortDirections[tableId]) {
                // Assuming 5 sortable columns
                sortDirections[tableId] = [true, true, true, true, true];
            }
            var ascending = sortDirections[tableId][columnIndex];

            rows.sort(function(rowA, rowB) {
                var cellA = rowA.getElementsByTagName('td')[columnIndex].innerText.trim();
                var cellB = rowB.getElementsByTagName('td')[columnIndex].innerText.trim();

                // Check if numeric sort
                if (!isNaN(parseFloat(cellA)) && !isNaN(parseFloat(cellB))) {
                    return ascending ? cellA - cellB : cellB - cellA;
                }
                // Otherwise, do text sort
                return ascending ? cellA.localeCompare(cellB) : cellB.localeCompare(cellA);
            });

            // Clear and re-append sorted rows
            tbody.innerHTML = '';
            rows.forEach(function(row) {
                tbody.appendChild(row);
            });

            // Toggle sort direction for this column in this table
            sortDirections[tableId][columnIndex] = !ascending;
            updateArrows(tableId, columnIndex, ascending);
        }

        function updateArrows(tableId, columnIndex, ascending) {
            var table = document.getElementById(tableId);
            // Reset all arrow icons in the table header
            var headerIcons = table.querySelectorAll('thead th i');
            headerIcons.forEach(function(icon) {
                icon.classList.remove('bi-arrow-up', 'bi-arrow-down');
                icon.classList.add('bi-arrow-up');
            });

            // Extract unique table index from the tableId (assuming format sortableTable_INDEX)
            var parts = tableId.split('_');
            var tableIndex = parts[1];
            var arrowId = 'arrow-' + columnIndex + '-' + tableIndex;
            var arrow = document.getElementById(arrowId);
            if (arrow) {
                arrow.classList.toggle('bi-arrow-up', ascending);
                arrow.classList.toggle('bi-arrow-down', !ascending);
            }
        }
    </script>
