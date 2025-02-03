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
         <a href="{{ route('get-shopping-list-manager') }}"
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