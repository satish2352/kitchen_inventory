@foreach ($locations_data as $item)
          <!-- User Request Box -->
          <div class="user-request-box p-3 shadow rounded mb-3">
            <!-- Top Row -->
            <div class="d-flex justify-content-between align-items-center">
              <!-- Left Section -->
              <div>
                <div class="d-flex align-items-center">
                  <span class="act-user me-2">{{ $item->location }}</span>
                </div>
                <!-- <p class="mb-1">{{ $item->role }}</p> -->
              </div>

              <!-- Right Section -->
              <div>
                <button class="btn btn-edit text-center shadow-sm edit-btn" data-id="{{ $item->id }}">
                  <i class="bi bi-pencil-square"></i> <br />Edit
                </button>
              </div>
            </div>
          </div>
          @endforeach