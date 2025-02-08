@foreach ($user_data as $item)
    <div class="user-request-box p-3 shadow rounded mb-2">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <div class="d-flex align-items-center">
                    <span class="ur-user me-2 jost-font">{{ $item->name }}</span>
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
        {{ \Carbon\Carbon::parse($item->created_at)->format('D F j, Y | g:ia') }}
        </div>
    </div>
@endforeach
