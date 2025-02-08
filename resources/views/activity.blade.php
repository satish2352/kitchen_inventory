@include('layouts.header')
@include('layouts.sidebar')

@yield('content')

<style>
  .pagination {
    justify-content: center;
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
          <button class="btn btn-white mx-2">
            <i class="bi bi-geo-alt-fill"></i>
          </button>
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
            {{ $ActiviyLogData->links() }}
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