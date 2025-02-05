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
            <h5 class="sub-title">Kitchen Inventory</h5>
            <a href="approve-users.html">
                <button class="btn btn-light">
                    <i class="bi bi-check2"></i>
                </button>
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
            <button class="btn btn-white mx-2">
                <i class="bi bi-geo-alt-fill"></i>
            </button>

            <!-- Bar Grid Icon -->
            <button class="btn btn-white btn-delete">
                <i class="bi bi-filter"></i>
            </button>
        </div>
        <div class="container-fluid px-3">
            <a href="new-shopping-list.html">
                <button type="button" class="btn btn-outline-danger fs-6">
                    Show last submitted Kitchen list
                </button>
            </a>
            @if (is_array(session('location_for_user')) && count(session('location_for_user')) > 0)
                <form id="locationForm" method="post" action="{{ route('location_selected') }}">
                    @csrf
                    <div class="row mb-3">
                        <label class="form-label col-6">Select Location</label>
                        <div class="col-6">
                            <select class="form-select" name="location_selected" id="location_selected">
                                <option value="">Select Location</option>
                                @foreach (session('location_for_user') as $locations)
                                    <option value="{{ $locations['id'] }}"
                                        @if (session('location_selected') == $locations['id']) selected @endif>{{ $locations['location'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            @endif
            <!-- Border Box -->
            <div class="border-box mb-4">
                <!-- Header Title -->
                <div class="grid-header text-center">
                    <h6 class="m-0 text-white">Sauces</h6>
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
                            </tr>
                        </thead>
                        <!-- Table Body -->
                        <tbody>
                            @foreach ($all_kitchen_inventory as $kitchen_data)
                                <tr>
                                    <td>{{ $kitchen_data['item_name'] }}</td>
                                    <td>
                                        <input type="text" class="form-control qty-input" placeholder="QTY" />
                                    </td>
                                    <td>{{ $kitchen_data['unit'] }}</td>
                                </tr>
                            @endforeach
                            <tr>
                        </tbody>
                    </table>
                </div>
            </div>
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
        document.getElementById('locationForm').submit();
    });
</script>

@extends('layouts.footer')
