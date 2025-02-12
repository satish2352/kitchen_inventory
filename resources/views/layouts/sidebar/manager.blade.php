<div class="main">
   <div class="container-fluid p-3">
      <!-- Top Bar -->
      <div class="d-flex justify-content-between align-items-center mb-3">
         <!-- Toggle Drawer Button -->
         <div id="toggleDrawer" class="toggle-drawer">
            <i class="bi bi-list"></i>
         </div>

         <!-- Username and Role Together -->
         <div>
               <h5 class="inter-font"><span class="jost-font">Manager</span></h5>
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
            <span class="jost-font">Manager</span>
         </div>
      </div>
      <div class="drawer-nav">
         <a href="{{ route('/dashboard') }}" class="active"
            ><i class="bi bi-house-door-fill"></i> Dashboard</a
            >
         <a href="{{ route('get-location-wise-inventory') }}"
            ><i class="bi bi-cart3"></i>Update Kitchen Inventory</a>

         <a href="{{ route('get-submited-shopping-list-manager') }}"
            ><i class="bi bi-house-door-fill"></i>Submitted Shopping List</a>

         <!-- <a href="{{ route('get-inventory-history-manager') }}"
            ><i class="bi bi-house-door-fill"></i>Inventory History List</a>    -->

            <a href="javascript:void(0);" id="logoutbtn">
                  <i class="bi bi-box-arrow-right"></i> Log Out
            </a>
      </div>
   </div>
   <!-- Overlay -->
   <div id="backdrop" class="backdrop"></div>
   <!-- dashboard content  -->

   <!-- Confirm Logout Popup -->
<div id="confirmLogOutPopUp" class="confirm-popup-container" style="display: none;">
    <div class="confirm-popup-content">
        <h4 class="confirm-popup-title">Confirm Logout</h4>
        <p class="confirm-popup-text">Are you sure you want to log out?</p>
        <div class="d-flex justify-content-around mt-4">
            <button id="cancelLogout" class="btn br">NO</button>
            <button id="confirmLogout" class="btn">YES</button>
        </div>
    </div>
</div>

<!-- Hidden Logout Form -->
<form id="logoutForm" action="{{ route('logout') }}" method="get" style="display: none;">
    @csrf
</form>

<!-- JavaScript -->
<script type="text/javascript">
document.addEventListener("DOMContentLoaded", () => {
    const logOutButton = document.querySelector("#logoutbtn");
    const confirmLogOutPopUp = document.getElementById("confirmLogOutPopUp");
    const cancelLogout = document.getElementById("cancelLogout");
    const confirmLogout = document.getElementById("confirmLogout");
    const logoutForm = document.getElementById("logoutForm");

    logOutButton.addEventListener("click", () => {
        confirmLogOutPopUp.style.display = "flex"; // Show the confirmation popup
    });

    cancelLogout.addEventListener("click", () => {
        confirmLogOutPopUp.style.display = "none"; // Hide the popup if canceled
    });

    confirmLogout.addEventListener("click", () => {
        logoutForm.submit(); // Submit the form to trigger Laravel logout
    });
});
</script>