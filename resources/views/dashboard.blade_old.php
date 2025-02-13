@include('layouts.header')
@include('layouts.sidebar')

@yield('content')

 <div class="container-fluid p-3">
    <!-- Dashboard Title -->
    <h1 class="mb-3 fw-bold">Dashboard</h1>
    <!-- Gradient Background Box -->
    <div
       class="gradient-box d-flex align-items-center justify-content-between p-3 shadow lexend-font"
       >
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
       <div
          class="arrow-icon rounded-circle d-flex align-items-center justify-content-center"
          >
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

 @extends('layouts.footer')