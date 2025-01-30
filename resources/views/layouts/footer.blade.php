<script>
    const toggleDrawer = document.getElementById("toggleDrawer");
    const drawer = document.getElementById("drawer");
    const backdrop = document.getElementById("backdrop");
    
    // Toggle drawer and backdrop
    toggleDrawer.addEventListener("click", () => {
      drawer.classList.toggle("open");
      backdrop.classList.toggle("show");
    });
    
    // Close drawer and backdrop when clicking the backdrop
    backdrop.addEventListener("click", () => {
      drawer.classList.remove("open");
      backdrop.classList.remove("show");
    });
 </script>
 <script type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
      const deleteButton = document.querySelector(".btn-delete");
      const editButton = document.querySelector(".edit-btn");
      const popup = document.getElementById("editPopup");
      const confirmPopup = document.getElementById("confirmPopup");
      const cancelDeleteButton = document.getElementById("cancelDelete");
      const confirmDeleteButton = document.getElementById("confirmDelete");
    
      // Open Popup
      editButton.addEventListener("click", () => {
        popup.style.display = "flex";
      });
    
      // Close Popup when clicking outside
      popup.addEventListener("click", (e) => {
        if (e.target === popup) {
          popup.style.display = "none";
        }
      });
    
      // Show Confirmation Popup
      deleteButton.addEventListener("click", () => {
        popup.style.display = "none"; // Close the bottom popup
        confirmPopup.style.display = "flex"; // Show the confirmation popup
      });
    
      // Close Confirmation Popup on Cancel
      cancelDeleteButton.addEventListener("click", () => {
        confirmPopup.style.display = "none";
      });
    
      // Perform Action on Confirm Delete
      confirmDeleteButton.addEventListener("click", () => {
        confirmPopup.style.display = "none";
        alert("User deleted successfully!");
        // Add delete logic here
      });
    });
 </script>
</div>
</body>
</html>