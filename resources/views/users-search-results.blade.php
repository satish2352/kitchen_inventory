@foreach ($user_data as $item)
    <div class="user-request-box p-3 shadow rounded mb-2">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <div class="d-flex align-items-center">
                <span class="ur-user me-2 jost-font">{{ $item->name }}
                  @if($item->user_role == '1') 
                  (Super Admin)
                  @elseif($item->user_role == '2')
                  (Admin)
                  @else
                  (Night Manager)
                  @endif
                  </span>

                  @if($item->is_approved == 0)
                  <div class="status-badge ms-2 d-flex align-items-center" style="background-color:red">
                    <i class="bi bi-check-circle-fill text-success me-1"></i>
                    <span style="color:white">Unapproved</span>
                  </div>
                @elseif($item->is_approved == 1) 
                  <div class="status-badge ms-2 d-flex align-items-center">
                    <i class="bi bi-check-circle-fill text-success me-1"></i>
                    <span style="color:white">Approved</span>
                  </div>
                @endif 
                </div>
                <p class="mb-1 fw-light">{{ $item->email }}</p>
                <p class="mb-1 fw-light">{{ $item->phone }}</p>
            </div>
            <div>
                <button class="btn btn-edit text-center shadow-sm edit-btn-user" data-id="{{ $item->id }}">
                    <i class="bi bi-pencil-square"></i> <br />Edit
                </button>
            </div>
        </div>
        <hr class="my-2" />
        <div class="text-center fw-light fs-sm">
            Last active: Sun April 27, 2024 | 5:45 p.m.
        </div>
    </div>
@endforeach
