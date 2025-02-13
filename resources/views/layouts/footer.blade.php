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
 <script>
  $(document).ready(function() {
    $('.select2').select2({
      minimumResultsForSearch: 0,
      placeholder: "Select Location", // Optional placeholder
      allowClear: true,// Optional to allow clearing the selection
      width: '100%',
      // closeOnSelect: false,
      tags: false
    });
  });
</script>

 <script type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
      // const deleteButton = document.querySelector(".btn-delete");
      // const editButton = document.querySelector(".edit-btn");
      // const popup = document.getElementById("editPopup");
      // const addButton = document.querySelector(".add-btn");
      // const popupadd = document.getElementById("addPopup");
      // const confirmPopup = document.getElementById("confirmPopup");
      // const cancelDeleteButton = document.getElementById("cancelDelete");
      // const confirmDeleteButton = document.getElementById("confirmDelete");

      // const editButtonCategory = document.querySelector(".edit-btn-category");
      // const popupcategory = document.getElementById("editPopupCategory");
      // const deleteButtonCategory = document.querySelector(".btn-delete-category");
      // const confirmPopupCategory = document.getElementById("confirmPopupCategory");
      // const confirmDeleteButtonCategory = document.getElementById("confirmDeleteCategory");



    
      // // Open Popup
      // addButton.addEventListener("click", () => {
      //   popupadd.style.display = "flex";
      // });

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

<!-- <script>
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
</script>  -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        @if(session('alert_status') && session('alert_msg'))
            Swal.fire({
                title: "{{ session('alert_status') == 'success' ? 'Success' : 'Error' }}",
                text: "{{ session('alert_msg') }}",
                icon: "{{ session('alert_status') }}",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "OK"
            });
        @endif
    });
</script>

<script>
    document.getElementById("closePopup").addEventListener("click", function(event) {
        event.preventDefault(); // Prevent default link behavior
        document.getElementById("addPopup").style.display = "none"; // Hide the popup
    });
</script>

<script>
  let deferredPrompt;

window.addEventListener('beforeinstallprompt', (event) => {
    // Prevent default so we can trigger it later
    event.preventDefault();

    // Store the event for later use
    deferredPrompt = event;

    // Show install button
    document.getElementById('installButton').style.display = 'block';
});

document.getElementById('installButton').addEventListener('click', () => {
    if (deferredPrompt) {
        // Show install prompt
        deferredPrompt.prompt();

        deferredPrompt.userChoice.then((choiceResult) => {
            if (choiceResult.outcome === 'accepted') {
                console.log('User accepted the install prompt');
            } else {
                console.log('User dismissed the install prompt');
            }
            deferredPrompt = null; // Reset event
        });
    }
});


  </script>

<script type="text/javascript">
             if ('serviceWorker' in navigator) {
              navigator.serviceWorker
                .register('sw.js')
                .then(function () {
                  console.log('Website Worker Registered!');
                })
                .catch(function(err) {
                  console.log(err);
                });
            }

        </script>

</div>
</body>
</html>