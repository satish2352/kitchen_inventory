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
        margin-top: 15px; /* Add margin to the second row */
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
          <h5 class="sub-title">Activity</h5>
          <!-- person -->
          <div></div>
          <!-- <div class="person edit-btn">
            <i class="bi bi-person"></i>
            <span>Amar Deep</span>
          </div> -->
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
          <!-- <button class="btn btn-white mx-2">
            <i class="bi bi-geo-alt-fill"></i>
          </button> -->
        </div>
      </div>
      <!-- user requestion section  -->
      <div class="user-request">
    <div class="container-fluid px-3">
    @if (!empty($ActiviyLogData) && count($ActiviyLogData) > 0)
        @foreach ($ActiviyLogData as $item)
            <!-- User Activity Box -->
            <div class="user-request-box p-3 shadow rounded mb-2">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="bdr-left">
                        <div class="d-flex align-items-center">
                            <span class="act-user me-2">{{ $item->activity_message }}</span>
                        </div>
                        <p class="mb-1 activity-p">
                            {{ \Carbon\Carbon::parse($item->created_at)->format('D F j, Y | g:ia') }}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach  

        <!-- Pagination Links -->
        <div class="mt-3">
        <div class="col-md-8">
                                                    <div class="pagination">
                                                        @if ($ActiviyLogData->lastPage() > 1)
                                                            <ul class="pagination">
                                                                <li class="{{ ($ActiviyLogData->currentPage() == 1) ? ' disabled' : '' }}">
                                                                    @if ($ActiviyLogData->currentPage() > 1)
                                                                        <a href="{{ $ActiviyLogData->url($ActiviyLogData->currentPage() - 1) }}">Previous</a>
                                                                    @else
                                                                        <span>Previous</span>
                                                                    @endif
                                                                </li>
                                                                @php
                                                                    $currentPage = $ActiviyLogData->currentPage();
                                                                    $lastPage = $ActiviyLogData->lastPage();
                                                                    $startPage = max($currentPage - 5, 1);
                                                                    $endPage = min($currentPage + 4, $lastPage);
                                                                @endphp
                                                                @if ($startPage > 1)
                                                                    <li>
                                                                        <a href="{{ $ActiviyLogData->url(1) }}">1</a>
                                                                    </li>
                                                                    @if ($startPage > 2)
                                                                        <li>
                                                                            <span>...</span>
                                                                        </li>
                                                                    @endif
                                                                @endif
                                                                @for ($i = $startPage; $i <= $endPage; $i++)
                                                                    <li class="{{ ($currentPage == $i) ? ' active' : '' }}">
                                                                        <a href="{{ $ActiviyLogData->url($i) }}">{{ $i }}</a>
                                                                    </li>
                                                                @endfor
                                                                @if ($endPage < $lastPage)
                                                                    @if ($endPage < $lastPage - 1)
                                                                        <li>
                                                                            <span>...</span>
                                                                        </li>
                                                                    @endif
                                                                    <li>
                                                                        <a href="{{ $ActiviyLogData->url($lastPage) }}">{{ $lastPage }}</a>
                                                                    </li>
                                                                @endif
                                                                <li class="{{ ($currentPage == $lastPage) ? ' disabled' : '' }}">
                                                                    @if ($currentPage < $lastPage)
                                                                        <a href="{{ $ActiviyLogData->url($currentPage + 1) }}">Next</a>
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
                                                </div><!-- Pagination for each category -->
        </div>
    @else
        <div class="border-box mb-4" id="search-results">
            <!-- Header Title -->
            <div class="grid-header text-center">
                <h6 class="m-0 text-white">No Activity Data Found</h6>
            </div>
        </div>    
    @endif
        
    </div>
</div>

      <!-- edit popup  -->
      <div id="editPopup" class="popup-container">
        <div class="popup-content">
          <!-- Popup Title -->
          <h4 class="popup-title">Select User</h4>
          <hr />
          <!-- User Activity Box -->
          <div class="user-request-box p-3 shadow rounded mb-2 user-active">
            <!-- Top Row -->
            <div class="d-flex align-items-center">
              <!-- Left Section -->
              <div class="user-icon"></div>
              <div class="bdr-left-clr">
                <div class="d-flex align-items-center">
                  <span class="act-user me-2">Jammar White</span>
                </div>
                <p class="mb-1 activity-p">Super Admin</p>
              </div>
            </div>
          </div>
          <div class="user-request-box p-3 shadow rounded mb-2">
            <!-- Top Row -->
            <div class="d-flex align-items-center">
              <!-- Left Section -->
              <div class="user-icon"></div>
              <div class="bdr-left-clr">
                <div class="d-flex align-items-center">
                  <span class="act-user me-2">Jammar White</span>
                </div>
                <p class="mb-1 activity-p">Super Admin</p>
              </div>
            </div>
          </div>
          <div class="user-request-box p-3 shadow rounded mb-2">
            <!-- Top Row -->
            <div class="d-flex align-items-center">
              <!-- Left Section -->
              <div class="user-icon"></div>
              <div class="bdr-left-clr">
                <div class="d-flex align-items-center">
                  <span class="act-user me-2">Jammar White</span>
                </div>
                <p class="mb-1 activity-p">Super Admin</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
 @extends('layouts.footer')