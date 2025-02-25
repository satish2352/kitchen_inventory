@include('layouts.header')
@include('layouts.sidebar')

@yield('content')

<style>
   @media  (min-width: 376px) and (max-width: 440px) {
      .icon-box {
      height: 25vh;
   }
   }

   @media (max-width: 375px) {
      .icon-box {
      height: 30vh;
   }
   }

   .icon-box {
   min-height: 205px !important;
   }

   @media  (min-width: 278px) and (max-width: 282px) {
      .icon-box {
      height: 35vh;
   }
   }
</style>

<div class="container-fluid p-3">
    <h1 class="mb-3 fw-bold">Dashboard</h1>
 </div>
 @if (session()->get('user_role') =='1')
 <div class="service-box jost-font">
    <div class="container-fluid p-3">
       <div class="row d-flex g-2">
          <div class="col-4">
            <a class="nav-link" href="{{ route('list-users') }}">
            <div class="icon-box text-center shadow">
               <div class="icon-circle mb-3">
                     <i class="bi bi-person-add"></i>
               </div>
               <h4 class="mt-2">{{ $return_data['users_count'] }}</h4> <!-- Moved below the icon -->
               <div class="icon-divider"></div>
               <span class="mt-3">All Users</span>
            </div>
            </a>
         </div>
         
          <div class="col-4">
            <a class="nav-link" href="{{ route('get-activity-log') }}">
            <div class="icon-box text-center shadow">
               <div class="icon-circle mb-3">
                     <i class="bi bi-person-add"></i>
               </div>
               <h4 class="mt-2">{{ $return_data['ActivityLogCount'] }}</h4> <!-- Moved below the icon -->
               <div class="icon-divider"></div>
               <span class="mt-3">Activity</span>
            </div>
            </a>
         </div>
         
          <!-- Icon Box 3 -->
         
          <div class="col-4">
            <a class="nav-link" href="{{ route('get-submited-shopping-list-super-admin') }}">
            <div class="icon-box text-center shadow">
               <div class="icon-circle mb-3">
                     <i class="bi bi-share-fill"></i>
               </div>
               <h4 class="mt-2">{{ $return_data['LocationWiseInventoryCount'] }}</h4> <!-- Moved below the icon -->
               <div class="icon-divider"></div>
               <span class="mt-3">Shopping List</span>
            </div>
            </a>
         </div>
         

          <!-- Icon Box 4 -->
          <div class="col-4">
            <a class="nav-link" href="{{ route('get-location-wise-inventory-sa') }}">
             <div class="icon-box text-center shadow">
                <div class="icon-circle mb-3">
                   <i class="bi bi-tools"></i>
                </div>
               <h4 class="mt-2">{{ $return_data['LocationWiseInventoryCount'] }}</h4> <!-- Moved below the icon -->
                <div class="icon-divider"></div>
                <span class="mt-3">For Update Kitchen Inventory</span>
             </div>
             </a>
          </div>
         
          
          <div class="col-4">
            <a class="nav-link" href="{{ route('list-items') }}">
            <div class="icon-box text-center shadow">
               <div class="icon-circle mb-3">
                     <i class="bi bi-person-add"></i>
               </div>
               <h4 class="mt-2">{{ $return_data['master_inventory_count'] }}</h4> <!-- Moved below the icon -->
               <div class="icon-divider"></div>
               <span class="mt-3">Master Inventory</span>
            </div>
            </a>
         </div>
          


          <div class="col-4">
            <a class="nav-link" href="{{ route('list-category') }}">
            <div class="icon-box text-center shadow">
               <div class="icon-circle mb-3">
                     <i class="bi bi-person-add"></i>
               </div>
               <h4 class="mt-2">{{ $return_data['CategoryCount'] }}</h4> <!-- Moved below the icon -->
               <div class="icon-divider"></div>
               <span class="mt-3">Category</span>
            </div>
            </a>
         </div>
         

          <div class="col-4">
            <a class="nav-link" href="{{ route('list-locations') }}">
            <div class="icon-box text-center shadow">
               <div class="icon-circle mb-3">
                     <i class="bi bi-person-add"></i>
               </div>
               <h4 class="mt-2">{{ $return_data['LocationCount'] }}</h4> <!-- Moved below the icon -->
               <div class="icon-divider"></div>
               <span class="mt-3">Locations</span>
            </div>
            </a>
         </div>
         

          
       </div>
    </div>
 </div>
 @elseif (session()->get('user_role') =='2')
 <div class="service-box jost-font">
    <div class="container-fluid p-3">
       <div class="row d-flex g-2">
          <!-- Icon Box 1 -->
          <div class="col-4">
            <a class="nav-link" href="{{ route('list-admin-users') }}">
            <div class="icon-box text-center shadow">
               <div class="icon-circle mb-3">
                     <i class="bi bi-person-add"></i>
               </div>
               <h4 class="mt-2">{{ $return_data['alluserCount'] }}</h4> <!-- Moved below the icon -->
               <div class="icon-divider"></div>
               <span class="mt-3">All Users</span>
            </div>
            </a>
         </div>

          <!-- Icon Box 3 -->
          <div class="col-4">
            <a class="nav-link" href="{{ route('get-submited-shopping-list-super-admin') }}">
            <div class="icon-box text-center shadow">
               <div class="icon-circle mb-3">
                     <i class="bi bi-share-fill"></i>
               </div>
               <h4 class="mt-2">{{ $return_data['LocationWiseInventoryCount'] }}</h4> <!-- Moved below the icon -->
               <div class="icon-divider"></div>
               <span class="mt-3">Shopping List</span>
            </div>
            </a>
         </div>
         
          <!-- Icon Box 4 -->
          <div class="col-4">
               <a class="nav-link" href="{{ route('get-submited-shopping-list-super-admin') }}">
             <div class="icon-box text-center shadow">
                <div class="icon-circle mb-3">
                   <i class="bi bi-tools"></i>
                </div>
               <h4 class="mt-2">{{ $return_data['LocationWiseInventoryCount'] }}</h4> <!-- Moved below the icon -->
                <div class="icon-divider"></div>
                <span class="mt-3">For Update Kitchen Inventory</span>
             </div>
             </a>
          </div>
          
          <!-- Icon Box 6 -->
          <!-- <div class="col-4">
             <div class="icon-box text-center shadow">
                <div class="icon-circle mb-3">
                   <i class="bi bi-cart3"></i>
                </div>
                <div class="icon-divider"></div>
                <span class="mt-3">Submit Shopping list</span>
             </div>
          </div> -->
       </div>
    </div>
 </div>
 @elseif (session()->get('user_role') =='3')
 <div class="service-box jost-font">
    <div class="container-fluid p-3">
       <div class="row d-flex g-2">
          
          <!-- Icon Box 3 -->
          <div class="col-4">
          <a class="nav-link" href="{{ route('get-submited-shopping-list-super-admin') }}">
            <div class="icon-box text-center shadow">
               <div class="icon-circle mb-3">
                     <i class="bi bi-share-fill"></i>
               </div>
               <h4 class="mt-2">{{ $return_data['LocationWiseInventoryCount'] }}</h4> <!-- Moved below the icon -->
               <div class="icon-divider"></div>
               <span class="mt-3">Shopping List</span>
            </div>
            </a>
         </div>
        
          <!-- Icon Box 4 -->
          <div class="col-4">
          <a class="nav-link" href="{{ route('get-location-wise-inventory-sa') }}">
             <div class="icon-box text-center shadow">
                <div class="icon-circle mb-3">
                   <i class="bi bi-tools"></i>
                </div>
               <h4 class="mt-2">{{ $return_data['LocationWiseInventoryCount'] }}</h4> <!-- Moved below the icon -->
                <div class="icon-divider"></div>
                <span class="mt-3">For Update Kitchen Inventory</span>
             </div>
             </a>
          </div>
         
          
          <!-- Icon Box 6 -->
          <!-- <div class="col-4">
             <div class="icon-box text-center shadow">
                <div class="icon-circle mb-3">
                   <i class="bi bi-cart3"></i>
                </div>
                <div class="icon-divider"></div>
                <span class="mt-3">Submit Shopping list</span>
             </div>
          </div> -->
       </div>
    </div>
 </div>
 @endif
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