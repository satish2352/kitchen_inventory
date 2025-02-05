@include('layouts.header')
@include('layouts.sidebar')

@yield('content')

<div class="container-fluid p-3">
    <!-- Dashboard Title -->
    <h1 class="mb-3 fw-bold">Dashboard</h1>
    <!-- Gradient Background Box -->

    @if (is_array(session('location_for_user')) && count(session('location_for_user')) > 0)
        <form id="locationForm" method="post" action="{{ route('location_selected') }}">
            @csrf
            <div class="row mb-3">
                <label class="form-label col-6">Select Location</label>
                <div class="col-6">
                    <select class="form-select" name="location_selected" id="location_selected">
                        <option value="">Select Location</option>
                        @foreach (session('location_for_user') as $locations)
                            <option value="{{ $locations['id'] }}" @if (session('location_selected') == $locations['id']) selected @endif>
                                {{ $locations['location'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    @endif
    <div class="gradient-box d-flex align-items-center justify-content-between p-3 shadow lexend-font">


        <!-- Left Section -->
        <div>
            <h2 class="mb-1">120</h2>
            <p class="mb-1 mt-3 fw-light">Shopping lists</p>
            <div class="d-flex align-items-center dgraph fw-light">
                <i class="bi bi-graph-down me-2"></i>
                <span>-10% Less than yesterday</span>
            </div>
        </div>
        <!-- Right Section -->
        <div class="arrow-icon rounded-circle d-flex align-items-center justify-content-center">
            <i class="bi bi-chevron-right"></i>
        </div>
    </div>
</div>
<!-- box content -->
<div class="service-box jost-font">
    <div class="container-fluid p-3">
        <div class="row d-flex g-2">
            <!-- Icon Box 1 -->
            <div class="col-4">
                <div class="icon-box text-center shadow">
                    <div class="icon-circle mb-3">
                        <i class="bi bi-person-add"></i>
                    </div>
                    <div class="icon-divider"></div>
                    <span class="mt-3">Approve Users</span>
                </div>
            </div>
            <!-- Icon Box 2 -->
            <div class="col-4">
                <div class="icon-box text-center shadow">
                    <div class="icon-circle mb-3">
                        <i class="bi bi-person-add"></i>
                    </div>
                    <div class="icon-divider"></div>
                    <span class="mt-3">Activity</span>
                </div>
            </div>
            <!-- Icon Box 3 -->
            <div class="col-4">
                <div class="icon-box text-center shadow">
                    <div class="icon-circle mb-3">
                        <i class="bi bi-share-fill"></i>
                    </div>
                    <div class="icon-divider"></div>
                    <span class="mt-3">Shopping List</span>
                </div>
            </div>
            <!-- Icon Box 4 -->
            <div class="col-4">
                <div class="icon-box text-center shadow">
                    <div class="icon-circle mb-3">
                        <i class="bi bi-tools"></i>
                    </div>
                    <div class="icon-divider"></div>
                    <span class="mt-3">kitchen Inventory</span>
                </div>
            </div>
            <!-- Icon Box 5 -->
            <div class="col-4">
                <div class="icon-box text-center shadow">
                    <div class="icon-circle mb-3">
                        <i class="bi bi-journal-bookmark-fill"></i>
                    </div>
                    <div class="icon-divider"></div>
                    <span class="mt-3">Master Inventory</span>
                </div>
            </div>
            <!-- Icon Box 6 -->
            <div class="col-4">
                <div class="icon-box text-center shadow">
                    <div class="icon-circle mb-3">
                        <i class="bi bi-cart3"></i>
                    </div>
                    <div class="icon-divider"></div>
                    <span class="mt-3">Submit Shopping list</span>
                </div>
            </div>
        </div>
    </div>
</div>
<hr />
<!-- user requestion section  -->
<div class="user-request pb-3">
    <div class="container-fluid px-3">
        <!-- Section Title -->
        <h3 class="mb-4">User Requests</h3>
        <!-- User Request Box -->
        <div class="user-request-box p-3 shadow rounded mb-2">
            <!-- Top Row -->
            <div class="d-flex justify-content-between align-items-center">
                <!-- Left Section -->
                <div>
                    <div class="d-flex align-items-center">
                        <span class="ur-user me-2 jost-font">Autumn Kellar</span>
                        <div class="status-badge ms-2 d-flex align-items-center">
                            <i class="bi bi-check-circle-fill text-success me-1"></i>
                            <span>Approved</span>
                        </div>
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
                        <div class="status-badge ms-2 d-flex align-items-center">
                            <i class="bi bi-x-circle-fill text-success me-1"></i>
                            <span>Unapproved</span>
                        </div>
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
        <!-- User Details -->
        <div>
            <span class="ur-user me-2">Autumn Kellar</span>
            <p class="mb-1">johndoe@example.com</p>
            <p class="mb-1">+1 234 567 890</p>
        </div>
        <!-- Select Options -->
        <div class="row mb-3">
            <label class="col-6 form-label">Select Location:</label>
            <div class="col-6">
                <select class="form-select">
                    <option>New York</option>
                    <option>Los Angeles</option>
                    <option>Chicago</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <label class="form-label col-6">Select Role:</label>
            <div class="col-6">
                <select class="form-select">
                    <option>Admin</option>
                    <option>Editor</option>
                    <option>Viewer</option>
                </select>
            </div>
        </div>
        <!-- Action Buttons -->
        <div class="d-flex justify-content-between align-items-center">
            <button class="btn btn-outline-danger w-100">Approve</button>
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
<script>
    document.getElementById('location_selected').addEventListener('change', function() {
        document.getElementById('locationForm').submit();
    });
</script>
@extends('layouts.footer')
