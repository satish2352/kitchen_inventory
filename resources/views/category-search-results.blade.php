@if(!empty($category_data) && count($category_data) > 0)
@foreach ($category_data as $item)
          <!-- User Request Box -->
          <div class="user-request-box p-3 shadow rounded mb-2">
            <!-- Top Row -->
            <div class="d-flex justify-content-between align-items-center">
              <!-- Left Section -->
              <div>
                <div class="d-flex flex-column">
                  <span class="act-user me-2">{{ $loop->iteration }}</span>
                  <span class="act-user me-2">{{ $item->category_name }}</span>
                </div>
                <!-- <p class="mb-1 activity-p">{{ $item->created_at }}</p> -->
              </div>

              <!-- Right Section -->
              <div>
                <button class="btn btn-edit text-center shadow-sm edit-btn-category" data-id="{{ $item->id }}">
                  <i class="bi bi-pencil-square"></i> <br />Edit
                </button>
              </div>
            </div>
          </div>
        @endforeach
        @else
      <div class="border-box mb-4" id="search-results">
         <!-- Header Title -->
         <div class="grid-header text-center">
            <h6 class="m-0 text-white">No Data Found</h6>
         </div>
      </div>
      @endif