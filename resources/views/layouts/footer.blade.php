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
      const addButton = document.querySelector(".add-btn");
      const popupadd = document.getElementById("addPopup");
      const confirmPopup = document.getElementById("confirmPopup");
      const cancelDeleteButton = document.getElementById("cancelDelete");
      const confirmDeleteButton = document.getElementById("confirmDelete");

      const editButtonCategory = document.querySelector(".edit-btn-category");
      const popupcategory = document.getElementById("editPopupCategory");
      const deleteButtonCategory = document.querySelector(".btn-delete-category");
      const confirmPopupCategory = document.getElementById("confirmPopupCategory");
      const confirmDeleteButtonCategory = document.getElementById("confirmDeleteCategory");



    
      // Open Popup
      addButton.addEventListener("click", () => {
        popupadd.style.display = "flex";
      });

      // Open Popup
      // editButton.addEventListener("click", () => {
      //   popup.style.display = "flex";
      // });
    
      // Close Popup when clicking outside
      // popup.addEventListener("click", (e) => {
      //   if (e.target === popup) {
      //     popup.style.display = "none";
      //   }
      // });
    
      // Show Confirmation Popup
      // deleteButton.addEventListener("click", () => {
      //   popup.style.display = "none"; // Close the bottom popup
      //   confirmPopup.style.display = "flex"; // Show the confirmation popup
      // });

      // deleteButtonCategory.addEventListener("click", () => {
      //   popupcategory.style.display = "none"; // Close the bottom popup
      //   confirmPopupCategory.style.display = "flex"; // Show the confirmation popup
      // });
    
      // Close Confirmation Popup on Cancel
      // cancelDeleteButton.addEventListener("click", () => {
      //   confirmPopup.style.display = "none";
      // });
    
      // Perform Action on Confirm Delete
      // confirmDeleteButton.addEventListener("click", () => {
      //   confirmPopup.style.display = "none";
      //           $("#delete_id").val($("#edit-location-id").val());
      //           $("#deleteform").submit();
      //   alert("User deleted successfully!");
      //   // Add delete logic here
      // });

      // confirmDeleteButtonCategory.addEventListener("click", () => {
      //   confirmPopupCategory.style.display = "none";
      //           $("#delete_id").val($("#edit-category-id").val());
      //           $("#deleteform").submit();
      //   alert("User deleted successfully!");
      //   // Add delete logic here
      // });
    });
 </script>

<script>
 $(document).ready(function() {
  // Open the popup when Edit button is clicked
  $('.edit-btn').on('click', function() {
    var locationId = $(this).data('id'); // Get the location ID from the button
    
    // AJAX request to get location data
    $.ajax({
      url: '{{ route('edit-locations') }}', // Your route to fetch the location data
      type: 'GET',
      data: {
                locationId: locationId
            },
      success: function(response) {
        // console.log('responseresponseresponseresponse',response.location_data);
        // alert('ppppppppppppppppppp');
        // Populate the popup with the fetched data
        $('#edit-location').val(response.location_data.location); // Set location value
        $('#edit-role').val(response.location_data.role); // Set role value
        $('#edit-location-id').val(response.location_data.id); // Set role value
        
        // Show the popup
        $('#editPopup').show();

// Add the CSS property for flex display
document.getElementById('editPopup').style.display = "flex";
      },
      error: function() {
        alert('Failed to load location data.');
      }
    });
  });
  // Close the popup if clicked outside (optional)
  // $(document).on('click', function(event) {
  //   if (!$(event.target).closest('#editPopup, .edit-btn').length) {
  //     $('#editPopup').hide();
  //   }
  // });
});
</script> 



</div>
</body>
</html>