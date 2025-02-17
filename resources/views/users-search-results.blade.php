@foreach ($user_data as $item)
    <div class="user-request-box p-3 shadow rounded mb-2">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <div class="d-flex">
                     <span class="ur-user me-2 jost-font user_name_css">{{ $item->name }}
                     @if ($item->user_role == '1')
                     (Super Admin)
                     @elseif($item->user_role == '2')
                     (Admin)
                     @else
                     (Night Manager)
                     @endif
                     </span>
                     @if($item->is_approved == 1 && $item->added_by == 2 && $item->user_role == 3)
                     <div class="status-badge ms-2 d-flex align-items-center added_by_css">
                        <i class="bi bi-check-circle-fill text-success me-1"></i>
                        <span style="color:white">Added By Admin</span>
                     </div>
                     @endif
                  </div>
                  <p class="mb-1 fw-light">{{ $item->email }}</p>
                  <p class="mb-1 fw-light">{{ $item->phone }}</p>
                </div>
            <div>
                @if ($item->user_role != '1')
                  <button class="btn btn-edit text-center shadow-sm edit-btn-user"
                     data-id="{{ $item->id }}">
                  <i class="bi bi-pencil-square"></i> <br />Edit
                  </button>
                @endif
            </div>
        </div>
        <hr class="my-2" />
        <div class="text-center fw-light fs-sm">
          {{ \Carbon\Carbon::parse($item->created_at)->format('D F j, Y | g:ia') }}
        </div>
    </div>
@endforeach
