<div class="main">
    <div class="container-fluid p-3">
       <!-- Top Bar -->
       <div class="d-flex justify-content-between align-items-center mb-3">
          <!-- Toggle Drawer Button -->
          <div id="toggleDrawer" class="toggle-drawer">
             <i class="bi bi-list"></i>
          </div>
          <!-- Location -->
          @if(session()->get('location_selected_id') !='')
          <div class="location jost-font">
             <i class="bi bi-geo-alt"></i>
             <span>{{session('location_selected_name')}}</span>
          </div>
          @endif
       </div>
    </div>
    <!-- Drawer -->
    <div id="drawer" class="drawer">
       <div class="drawer-header d-flex align-items-center">
          <img src="{{ asset('/img/user.png') }}" alt="User" />
          <div>
             <h5 class="inter-font">{{ session('user_name') }}</h5>
             <span class="jost-font">Super Admin</span>
          </div>
       </div>
       <div class="drawer-nav">
          <a href="{{ route('/dashboard') }}" class="active"
             ><i class="bi bi-house-door-fill"></i> Dashboard</a>
          <a href="{{ route('approve-users') }}"
             ><i class="bi bi-person-plus-fill"></i> Approve Users</a>
          <!-- <a href="{{ route('get-shopping-list-super-admin') }}"
             ><i class="bi bi-share-fill"></i> Shopping List</a> -->
             <a href="{{ route('get-submited-shopping-list-super-admin') }}"
             ><i class="bi bi-share-fill"></i> Shopping List</a>
          <a href="{{ route('get-activity-log') }}"><i class="bi bi-book"></i> Activity</a>
          <a href="{{ route('list-users') }}"><i class="bi bi-person"></i> Manage User</a>
          <a href="{{ route('list-locations') }}"
             ><i class="bi bi-geo-alt-fill"></i>Manage Location</a>
          <a href="{{ route('list-category') }}"
             ><i class="bi bi-tag-fill"></i> Manage Category</a>
          <a href="{{ route('list-units') }}"
             ><i class="bi bi-kanban"></i> Manage Units</a>
             <a href="{{ route('list-items') }}"
             ><i class="bi bi-card-checklist"></i> Master Inventory</a>
          <a href="{{ route('get-location-wise-inventory-sa') }}"
             ><i class="bi bi-bag-plus-fill"></i>Add kitchen Inventory</a>
          
          <!-- <a href="get-submited-shopping-list-super-admin"
             ><i class="bi bi-cart3"></i> Submit Shopping list</a> -->

             <a href="{{ route('logout') }}"
             ><i class="bi bi-cart3"></i> Log Out</a>
       </div>
    </div>
    <!-- Overlay -->
    <div id="backdrop" class="backdrop"></div>
    <!-- dashboard content  -->