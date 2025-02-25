<style>
    #drawer::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        border-radius: 10px;
        background-color: #F5F5F5;
    }

    #drawer::-webkit-scrollbar {
        width: 5px;
        background-color: #F5F5F5;
    }

    #drawer::-webkit-scrollbar-thumb {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
        background-color: #555;
    }

    .drawer {
        /* margin-left: 30px; */
        float: left;
        /* height: 300px; */
        /* width: 65px; */
        background: #F5F5F5;
        overflow-y: scroll;
        margin-bottom: 25px;
    }
</style>

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
                <h5 class="inter-font"><span class="jost-font">Night Manager</span></h5>
            </div>
            <!-- Location -->
            @if (session()->get('location_selected_id') != '')
                <div class="location jost-font">
                    <i class="bi bi-geo-alt"></i>
                    <span>{{ session('location_selected_name') }}</span>
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
                <span class="jost-font">Night Manager</span>
            </div>
        </div>
        <div class="drawer-nav">
            <a href="{{ route('/dashboard') }}" class="active"><i class="bi bi-house-door-fill"></i> Dashboard</a>
            <a href="{{ route('get-location-wise-inventory-sa') }}"><i class="bi bi-house-door-fill"></i>Update Kitchen
                Inventory</a>
            <a href="{{ route('get-submited-shopping-list-super-admin') }}"><i
                    class="bi bi-house-door-fill"></i>Submitted Shopping List</a>

            <a href="{{ route('change-password') }}"><i class="bi bi-bag-plus-fill"></i>Change Password</a>


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
