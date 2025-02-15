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
            <h5 class="sub-title">Update Kitchen Inventory</h5>
            <a href="#">
                <!-- <button class="btn btn-light">
                    <i class="bi bi-check2"></i>
                </button> -->
            </a>
        </div>
    </div>
    <div class="filter">
        <div class="shopping-list-row d-flex align-items-center p-3">
            <!-- Search Input -->
            <div class="input-group search-input">
                <input type="text" class="form-control" placeholder="Search..." aria-label="Search" />
                <button class="btn btn-srh" type="button">
                    <i class="bi bi-search"></i>
                </button>
            </div>

            <!-- Location Icon -->
            <!-- <button class="btn btn-white mx-2">
                <i class="bi bi-geo-alt-fill"></i>
            </button> -->

            <!-- Bar Grid Icon -->
            <!-- <button class="btn btn-white btn-delete">
                <i class="bi bi-filter"></i>
            </button> -->
        </div>
        <div class="container-fluid px-3">
            <!-- <a href="#">
                <button type="button" class="btn btn-outline-danger fs-6">
                    Show last submitted Kitchen list
                </button>
            </a> -->
               

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

<!-- first if start -->
            @if(session()->get('location_selected_id') !='')
            <!-- <?php //print_r($InventoryData); die;?> -->
            <!-- second if start -->
            @if($InventoryData['DataType']=='MasterData')

            <form action="{{ route('add-kitchen-inventory-by-sa') }}" id="frm_register_add" method="POST">
            @csrf
            
            @if (!empty($InventoryData['data_location_wise_inventory']) && count($InventoryData['data_location_wise_inventory']) > 0)
            @foreach ($InventoryData['data_location_wise_inventory'] as $category => $items)
            <!-- Border Box -->
            <div class="border-box mb-4" id="search-results">
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
                                <th><b>Sr. No.</b></th>
                                <th><b>Req. Qty For This Location</b></th>
                                <th><b>Item</b></th>
                                <th><b>Available Qty</b></th>
                                <th><b>Unit</b></th>
                                <!-- <th><b>Price</b></th> -->
                            </tr>
                        </thead>
                        <!-- Table Body -->
                        <tbody>
                        @php $srNo = 1; @endphp
                            @foreach ($items as $item)
                            <input type="hidden" class="form-control" name="master_inventory_id[]" id="master_inventory_id" value="{{ $item['id'] }}"/>

                                <tr>
                                    <td> {{ $srNo++ }} </td>
                                    <td>{{ $item['masterQuantity'] }}</td>
                                    <td>{{ $item['item_name'] }}</td>
                                    <td>
                                        <input type="text" name="quantity[]" class="form-control qty-input-add" style="text-align: center;" placeholder="QTY" min="1" max="5"/>
                                        <span class="error-message text-danger"></span>
                                    </td>
                                    <td>{{ $item['unit_name'] }}</td>
                                    <!-- <td>{{ $item['price'] }}</td>   -->
                                </tr>
                            @endforeach
                            <tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
            <div class="text-center mt-3">
            <button type="submit" class="btn btn-success">Submit Inventory</button>
        </div>
        @else
        <div class="border-box mb-4" id="search-results">
                <!-- Header Title -->
                <div class="grid-header text-center">
                    <h6 class="m-0 text-white">Please Add Inventory For This location</h6>
                </div>
            </div>  
        @endif
            <!-- Submit Button -->
        

            </form>


            <!-- second if end and else start -->
            @elseif($InventoryData['DataType']=='LocationWiseData')
            <form action="{{ route('update-kitchen-inventory-by-super-admin') }}" id="frm_register_edit" method="POST">
            @csrf
            @if (!empty($InventoryData['data_location_wise_inventory']) && count($InventoryData['data_location_wise_inventory']) > 0)
            @foreach ($InventoryData['data_location_wise_inventory'] as $category => $items)
            <!-- Border Box -->
            <div class="border-box mb-4" id="search-results">
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
                                <th><b>Sr. No.</b></th>
                                <th><b>Req. Qty For This Location</b></th>
                                <th><b>Item</b></th>
                                <th><b>Available Qty</b></th>
                                <th><b>Unit</b></th>
                                <!-- <th><b>Price</b></th> -->
                            </tr>
                        </thead>
                        <!-- Table Body -->
                        <tbody>
                            @php $srNo = 1; @endphp
                            @foreach ($items as $item)
                            <input type="hidden" class="form-control" name="location_wise_inventory_id[]" id="location_wise_inventory_id" value="{{ $item['locationWiseId'] }}"/>
                            <input type="hidden" class="form-control" name="master_inventory_id[]" id="master_inventory_id" value="{{ $item['masterInventoryId'] }}"/>

                                <tr>
                                <td> {{ $srNo++ }} </td>
                                <td>{{ $item['masterQuantity'] }}</td>
                                    <td>{{ $item['item_name'] }}</td>
                                    <td>
                                        <input type="text" name="quantity[]" class="form-control qty-input-edit" style="text-align: center;" value="{{ $item['quantity'] }}"  placeholder="QTY" min="1" max="5"/>
                                        <span class="error-message text-danger"></span>
                                    </td>
                                    <td>{{ $item['unit_name'] }}</td>
                                    <!-- <td>{{ $item['price'] }}</td> -->
                                </tr>
                            @endforeach
                            <tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
            <div class="text-center mt-3">
            <button type="submit" class="btn btn-success">Submit Inventory</button>
        </div>
        @else
        <div class="border-box mb-4" id="search-results">
                <!-- Header Title -->
                <div class="grid-header text-center">
                    <h6 class="m-0 text-white">Please Add Inventory For This location</h6>
                </div>
            </div>  
        @endif
            <!-- Submit Button -->
        

            </form>




<!-- second if close -->
            @endif




            








            <!-- first if end and else stat -->
           @else
           <div class="border-box mb-4" id="search-results">
                <!-- Header Title -->
                <div class="grid-header text-center">
                    <h6 class="m-0 text-white">Please Select Location First</h6>
                </div>
            </div>    
            <!-- first if end and else ens -->
           @endif

        </div>
    </div>
    <!-- Delete Confirmation Popup -->
    <div id="confirmPopup" class="confirm-popup-container">
        <div class="confirm-popup-content">
            <h4 class="confirm-popup-title">ALERT!</h4>
            <p class="confirm-popup-text">Quantity is required</p>
            <div class="d-flex justify-content-around mt-4 confrm">
                <button id="confirmDelete" class="btn">Okay</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('location_selected').addEventListener('change', function() {
        var locationId= this.value;
        if(locationId !='')
        {
            document.getElementById('locationForm').submit();
        }
    });
</script>
@extends('layouts.footer')

<script>
    $(document).ready(function () {
        $("#frm_register_add").on("submit", function (e) {
            let isValid = true;

            // Loop through each quantity[] field and validate
            $(".qty-input-add").each(function () {
                let quantity = $(this).val().trim();
                let errorSpan = $(this).siblings(".error-message");
                let masterQuantity = parseFloat($(this).closest("tr").find("td:nth-child(2)").text().trim()) || 0; // Getting masterQuantity

                if (quantity === "" || isNaN(quantity) || parseFloat(quantity) < 0) {
                    errorSpan.text("Please enter a valid quantity (greater than 0).");
                    isValid = false;
                } else if (quantity.length > 5) {
                    errorSpan.text("Quantity cannot be more than 5 digits.");
                    isValid = false;
                } else if (parseFloat(quantity) > masterQuantity) {
                    errorSpan.text("Entered quantity cannot exceed required quantity!");
                    isValid = false;
                } else {
                    errorSpan.text(""); // Clear the error message
                }
            });

            if (!isValid) {
                e.preventDefault(); // Prevent form submission if validation fails
            }
        });

         // Clear error when user starts typing
         $(".qty-input-add").on("input", function () {
            let quantity = $(this).val().trim();
            let errorSpan = $(this).siblings(".error-message");

            if (quantity !== "" && !isNaN(quantity)) {
                if (quantity.length > 5) {
                    errorSpan.text("Quantity cannot be more than 5 digits.");
                } else {
                    errorSpan.text(""); // Clear the error message
                }
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        $("#frm_register_edit").on("submit", function (e) {
            let isValid = true;

            // Loop through each quantity[] field and validate
            $(".qty-input-edit").each(function () {
                let quantity = $(this).val().trim();
                let errorSpan = $(this).siblings(".error-message");
                let masterQuantity = parseFloat($(this).closest("tr").find("td:nth-child(2)").text().trim()) || 0; // Getting masterQuantity

                if (quantity === "" || isNaN(quantity) || parseFloat(quantity) < 0) {
                    errorSpan.text("Please enter a valid quantity (greater than 0).");
                    isValid = false;
                } else if (quantity.length > 5) {
                    errorSpan.text("Quantity cannot be more than 5 digits.");
                    isValid = false;
                } else if (parseFloat(quantity) > masterQuantity) {
                    errorSpan.text("Entered quantity cannot exceed required quantity!");
                    isValid = false;
                } else {
                    errorSpan.text(""); // Clear the error message
                }
            });

            if (!isValid) {
                e.preventDefault(); // Prevent form submission if validation fails
            }
        });

        // Clear error when user starts typing
        $(".qty-input-edit").on("input", function () {
            $(this).siblings(".error-message").text("");
        });
    });
</script>

<script type="text/javascript">
// $(document).ready(function () {
//     $("#frm_register").validate({
//         ignore: [], // Ensure jQuery Validate doesn't ignore hidden fields
//         rules: {
//             "quantity[]": {
//                 required: true,  // Each field is required
//                 number: true,    // Must be a valid number
//                 min: 1           // Minimum value should be 1
//             }
//         },
//         messages: {
//             "quantity[]": {
//                 required: "This field is required.",
//                 number: "Please enter a valid number.",
//                 min: "Quantity must be at least 1."
//             }
//         },
//         errorElement: "span",
//         errorClass: "error-text",
//         highlight: function (element) {
//             $(element).addClass("is-invalid").removeClass("is-valid");
//         },
//         unhighlight: function (element) {
//             $(element).addClass("is-valid").removeClass("is-invalid");
//         },
//         errorPlacement: function (error, element) {
//             error.insertAfter(element);
//         },
//         submitHandler: function (form) {
//             let allFilled = true;
//             var abc=1;
//             $("input[name='quantity[]']").each(function () {
//                 alert('ggggggggg',abc);
//                 console.log('hhhhhhhhhh',$(this).val());
                
//                 if ($(this).val().trim() === "" || $(this).val() <= 0) {
//                     allFilled = false;
//                     $(this).addClass("is-invalid").removeClass("is-valid");
//                     $(this).after('<span class="error-text">This field is required and must be at least 1.</span>');
//                 } else {
//                     $(this).removeClass("is-invalid").addClass("is-valid");
//                     $(this).next(".error-text").remove();
//                 }
//             });

//             if (allFilled) {
//                 form.submit(); // Submit only if all quantity fields are valid
//             }
//         }
//     });

//     // Trigger validation when a user types or changes the quantity fields
//     $(document).on("input", "input[name='quantity[]']", function () {
//         $(this).valid(); // Validate the specific field
//     });
// });






//   $(document).ready(function () {  
    // Initialize validation for the add form
//     $("#frm_register").validate({
//         rules: {
//         "quantity[]": {
//             required: function(element) {
//                 let isValid = true;
//                 $("input[name='quantity[]']").each(function() {
//                     // alert('kkkkkkkkkkkkk');
//                     if ($(this).val() === "" || $(this).val() <= 0) {
//                         isValid = true;
//                     }
//                 });
//                 return isValid;
//             },
//             number: true,  // Must be a valid number
//             min: 1         // Minimum value should be 1
//         }
//     },
//         messages: {
//             "quantity[]": {
//                 required: "All quantity fields are required",
//                 number: "Please enter a valid number.",
//                 // min: "Quantity must be at least 1."
//             }
//         },
//         errorElement: "span",
//         errorClass: "error-text",
//         highlight: function (element) {
//             $(element).addClass("is-invalid").removeClass("is-valid");
//         },
//         unhighlight: function (element) {
//             $(element).addClass("is-valid").removeClass("is-invalid");
//         },
//         errorPlacement: function(error, element) {
//             error.insertAfter(element); // Places error message directly after the input
//         }
//     });

//     $(document).on('change', '.qty-input', function() {
//     // Trigger validation for all quantity[] fields
//     $("#frm_register").valid(); // Validates the entire form
// });

    // Initialize validation for the edit form
    // Initialize validation for the add form
    // $("#editUserForm").validate({
    //   rules: {
    //     location: {
    //       required: true
    //       // minlength: 3
    //     },
    //     role: {
    //       required: true
    //       // minlength: 3
    //     },
    //     name: {
    //       required: true
    //       // minlength: 3
    //     },
    //     phone: {
    //       required: true,
    //       // number:true,
    //       minlength: 10,
    //       maxlength: 10,
    //       validPhone: true
    //       // pattern: /^[6-9]\d{9}$/
    //       // minlength: 3
    //     },
    //     email: {
    //       required: true,
    //       email:true,
    //       // minlength: 3
    //     },
    //     password: {
    //       required: true
    //       // minlength: 3
    //     }
        
    //   },
    //   messages: {
    //     location: {
    //       required: "Please select the location name"
    //       // minlength: "Category name must be at least 3 characters long"
    //     },
    //     role: {
    //       required: "Please select the role name"
    //       // minlength: "Category name must be at least 3 characters long"
    //     },
    //     name: {
    //       required: "Please enter user name"
    //       // minlength: "Category name must be at least 3 characters long"
    //     },
    //     phone: {
    //       required: "Please enter mobbile number",
    //       // number:"Please enter valid mobile number",
    //       minlength: "Mobile number min length must be exactly 10 digits.",
    //       maxlength: "Mobile number max length must be exactly 10 digits.",
    //       pattern: "Please enter a valid 10-digit mobile number starting with 6-9."
    //       // minlength: "Category name must be at least 3 characters long"
    //     },
    //     email: {
    //       required: "Please enter email ID",
    //       required: "Please Enter valid email Id"
    //       // minlength: "Category name must be at least 3 characters long"
    //     },
    //     password: {
    //       required: "Please enter password"
    //       // minlength: "Category name must be at least 3 characters long"
    //     }
    //   },
    //   errorElement: "span",
    //   errorClass: "error-text",
    //   highlight: function (element) {
    //     $(element).addClass("is-invalid").removeClass("is-valid");
    //   },
    //   unhighlight: function (element) {
    //     $(element).addClass("is-valid").removeClass("is-invalid");
    //   }
    // });


//   });
</script>
