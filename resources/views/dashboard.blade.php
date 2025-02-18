@include('layouts.header')
@include('layouts.sidebar')

@yield('content')

<style>
   @media  (min-width: 376px) and (max-width: 440px) {
      .icon-box {
      height: 22vh;
   }
   }

   @media (max-width: 375px) {
      .icon-box {
      height: 28vh;
   }
   }

</style>

<div class="container-fluid p-3">
    <!-- Dashboard Title -->
    <h1 class="mb-3 fw-bold">Dashboard</h1>
    <!-- Gradient Background Box -->
 </div>
 <!-- box content -->

 <!-- <img src="{{ asset('/img/main_logo.png') }}" alt="Company Logo dsds"> -->

 <!-- <img src="{{ asset('/img/main_logo.png') }}" alt="Company Logo" /> -->
 @if (session()->get('user_role') =='1')
 <div class="service-box jost-font">
    <div class="container-fluid p-3">
       <div class="row d-flex g-2">
          <!-- Icon Box 1 -->
          @if ($return_data['users_count'] > 0)
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
          @elseif ($return_data['users_count'] == 0)
          <div class="col-4">
            <a class="nav-link" href="{{ route('list-users') }}">
            <div class="icon-box text-center shadow">
               <div class="icon-circle mb-3">
                     <i class="bi bi-person-add"></i>
               </div>
               <h4 class="mt-2">0</h4> <!-- Moved below the icon -->
               <div class="icon-divider"></div>
               <span class="mt-3">All Users</span>
            </div>
            </a>
         </div>
         @endif
          <!-- Icon Box 2 -->


          @if ($return_data['ActivityLogCount'] > 0)
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
          @elseif ($return_data['ActivityLogCount'] == 0)
          <div class="col-4">
            <a class="nav-link" href="{{ route('get-activity-log') }}">
            <div class="icon-box text-center shadow">
               <div class="icon-circle mb-3">
                     <i class="bi bi-person-add"></i>
               </div>
               <h4 class="mt-2">0</h4> <!-- Moved below the icon -->
               <div class="icon-divider"></div>
               <span class="mt-3">Activity</span>
            </div>
            </a>
         </div>
          @endif

          <!-- Icon Box 3 -->
          @if ($return_data['LocationWiseInventoryCount'] > 0)
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
          @elseif ($return_data['LocationWiseInventoryCount'] == 0)
          <div class="col-4">
            <a class="nav-link" href="{{ route('get-submited-shopping-list-super-admin') }}">
            <div class="icon-box text-center shadow">
               <div class="icon-circle mb-3">
                     <i class="bi bi-share-fill"></i>
               </div>
               <h4 class="mt-2">0</h4> <!-- Moved below the icon -->
               <div class="icon-divider"></div>
               <span class="mt-3">Shopping List</span>
            </div>
            </a>
         </div>
          @endif

          <!-- Icon Box 4 -->
          @if ($return_data['LocationWiseInventoryCount'] > 0)
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
          @elseif ($return_data['LocationWiseInventoryCount'] == 0)
          <div class="col-4">
            <a class="nav-link" href="{{ route('get-location-wise-inventory-sa') }}">
             <div class="icon-box text-center shadow">
                <div class="icon-circle mb-3">
                   <i class="bi bi-tools"></i>
                </div>
               <h4 class="mt-2">0</h4> <!-- Moved below the icon -->
                <div class="icon-divider"></div>
                <span class="mt-3">For Update Kitchen Inventory</span>
             </div>
             </a>
          </div>
          @endif
          <!-- Icon Box 5 -->
          @if ($return_data['master_inventory_count'] > 0)
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
          @elseif ($return_data['master_inventory_count'] == 0)
          <div class="col-4">
            <a class="nav-link" href="{{ route('list-items') }}">
            <div class="icon-box text-center shadow">
               <div class="icon-circle mb-3">
                     <i class="bi bi-person-add"></i>
               </div>
               <h4 class="mt-2">0</h4> <!-- Moved below the icon -->
               <div class="icon-divider"></div>
               <span class="mt-3">Master Inventory</span>
            </div>
            </a>
         </div>
          @endif


          @if ($return_data['CategoryCount'] > 0)
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
          @elseif ($return_data['CategoryCount'] == 0)
          <div class="col-4">
            <a class="nav-link" href="{{ route('list-items') }}">
            <div class="icon-box text-center shadow">
               <div class="icon-circle mb-3">
                     <i class="bi bi-person-add"></i>
               </div>
               <h4 class="mt-2">0</h4> <!-- Moved below the icon -->
               <div class="icon-divider"></div>
               <span class="mt-3">Category</span>
            </div>
            </a>
         </div>
          @endif

          @if ($return_data['LocationCount'] > 0)
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
          @elseif ($return_data['LocationCount'] == 0)
          <div class="col-4">
            <a class="nav-link" href="{{ route('list-items') }}">
            <div class="icon-box text-center shadow">
               <div class="icon-circle mb-3">
                     <i class="bi bi-person-add"></i>
               </div>
               <h4 class="mt-2">0</h4> <!-- Moved below the icon -->
               <div class="icon-divider"></div>
               <span class="mt-3">Locations</span>
            </div>
            </a>
         </div>
          @endif

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
 @elseif (session()->get('user_role') =='2')
 <div class="service-box jost-font">
    <div class="container-fluid p-3">
       <div class="row d-flex g-2">
          <!-- Icon Box 1 -->
          @if ($return_data['alluserCount'] > 0)
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
          @elseif ($return_data['alluserCount'] == 0)
          <div class="col-4">
            <a class="nav-link" href="{{ route('list-admin-users') }}">
            <div class="icon-box text-center shadow">
               <div class="icon-circle mb-3">
                     <i class="bi bi-person-add"></i>
               </div>
               <h4 class="mt-2">0</h4> <!-- Moved below the icon -->
               <div class="icon-divider"></div>
               <span class="mt-3">All Users</span>
            </div>
            </a>
         </div>
          @endif
          <!-- Icon Box 2 -->

          <!-- Icon Box 1 -->
          <!-- @if ($return_data['users_count'] > 0)
          <div class="col-4">
            <div class="icon-box text-center shadow">
               <div class="icon-circle mb-3">
                     <i class="bi bi-person-add"></i>
               </div>
               <h4 class="mt-2">{{ $return_data['users_count'] }}</h4> 
               <div class="icon-divider"></div>
               <span class="mt-3">Approve Users</span>
            </div>
         </div>
          @endif -->
          <!-- Icon Box 2 -->

          <!-- Icon Box 3 -->
          @if ($return_data['LocationWiseInventoryCount'] > 0)
          <div class="col-4">
            <a class="nav-link" href="{{ route('get-submited-shopping-list-admin') }}">
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
          @elseif ($return_data['LocationWiseInventoryCount'] > 0)
          <div class="col-4">
            <a class="nav-link" href="{{ route('get-submited-shopping-list-admin') }}">
            <div class="icon-box text-center shadow">
               <div class="icon-circle mb-3">
                     <i class="bi bi-share-fill"></i>
               </div>
               <h4 class="mt-2">0</h4>
               <div class="icon-divider"></div>
               <span class="mt-3">Shopping List</span>
            </div>
            </a>
         </div>
          @endif

          <!-- Icon Box 4 -->
          @if ($return_data['LocationWiseInventoryCount'] > 0)
          <div class="col-4">
               <a class="nav-link" href="{{ route('get-shopping-list-admin') }}">
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
          @elseif ($return_data['LocationWiseInventoryCount'] == 0)
          <div class="col-4">
               <a class="nav-link" href="{{ route('get-shopping-list-admin') }}">
             <div class="icon-box text-center shadow">
                <div class="icon-circle mb-3">
                   <i class="bi bi-tools"></i>
                </div>
               <h4 class="mt-2">0</h4> <!-- Moved below the icon -->
                <div class="icon-divider"></div>
                <span class="mt-3">For Update Kitchen Inventory</span>
             </div>
             </a>
          </div>
          @endif
          
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
          @if ($return_data['LocationWiseInventoryCount'] > 0)
          <div class="col-4">
          <a class="nav-link" href="{{ route('get-submited-shopping-list-manager') }}">
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
          @elseif ($return_data['LocationWiseInventoryCount'] == 0)
          <div class="col-4">
          <a class="nav-link" href="{{ route('get-submited-shopping-list-manager') }}">
            <div class="icon-box text-center shadow">
               <div class="icon-circle mb-3">
                     <i class="bi bi-share-fill"></i>
               </div>
               <h4 class="mt-2">0</h4> <!-- Moved below the icon -->
               <div class="icon-divider"></div>
               <span class="mt-3">Shopping List</span>
            </div>
            </a>
         </div>
          @endif

          <!-- Icon Box 4 -->
          @if ($return_data['LocationWiseInventoryCount'] > 0)
          <div class="col-4">
          <a class="nav-link" href="{{ route('get-location-wise-inventory') }}">
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
          @elseif ($return_data['LocationWiseInventoryCount'] == 0)
          <div class="col-4">
          <a class="nav-link" href="{{ route('get-location-wise-inventory') }}">
             <div class="icon-box text-center shadow">
                <div class="icon-circle mb-3">
                   <i class="bi bi-tools"></i>
                </div>
               <h4 class="mt-2">0</h4> <!-- Moved below the icon -->
                <div class="icon-divider"></div>
                <span class="mt-3">For Update Kitchen Inventory</span>
             </div>
             </a>
          </div>
          @endif
          
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