<div class="main">
    <div class="container-fluid p-3">
       <!-- Top Bar -->
       <div class="d-flex justify-content-between align-items-center mb-3">
          <!-- Toggle Drawer Button -->
          <div id="toggleDrawer" class="toggle-drawer">
             <i class="bi bi-list"></i>
          </div>
          <!-- Location -->
          <div class="location jost-font">
             <i class="bi bi-geo-alt"></i>
             <span>Kaaba, Saudi Arabia</span>
          </div>
       </div>
    </div>
    <!-- Drawer -->
    <div id="drawer" class="drawer">
       <div class="drawer-header d-flex align-items-center">
          <img src="img/user.png" alt="User" />
          <div>
             <h5 class="inter-font">Jammar White</h5>
             <span class="jost-font">Super Admin</span>
          </div>
       </div>
       <div class="drawer-nav">
          <a href="dashboard.html" class="active"
             ><i class="bi bi-house-door-fill"></i> Dashboard</a
             >
          <a href="approve-users.html"
             ><i class="bi bi-person-plus-fill"></i> Approve Users</a
             >
          <a href="submit-shopping-list.html"
             ><i class="bi bi-share-fill"></i> Shopping List</a
             >
          <a href="activity.html"><i class="bi bi-book"></i> Activity</a>
          <a href="users.html"><i class="bi bi-person"></i> Manage User</a>
          <a href="locations.html"
             ><i class="bi bi-geo-alt-fill"></i>Manage Location</a
             >
          <a href="category.html"
             ><i class="bi bi-tag-fill"></i> Manage Category</a
             >
          <a href="manage-units.html"
             ><i class="bi bi-kanban"></i> Manage Units</a
             >
          <a href="kitchen-inventory.html"
             ><i class="bi bi-bag-plus-fill"></i>Add kitchen Inventory</a
             >
          <a href="master-inventory.html"
             ><i class="bi bi-card-checklist"></i> Master Inventory</a
             >
          <a href="submit-shopping-list.html"
             ><i class="bi bi-cart3"></i> Submit Shopping list</a
             >

             <a href="{{ route('logout') }}"
             ><i class="bi bi-cart3"></i> Log Out</a
             >
       </div>
    </div>
    <!-- Overlay -->
    <div id="backdrop" class="backdrop"></div>
    <!-- dashboard content  -->


    