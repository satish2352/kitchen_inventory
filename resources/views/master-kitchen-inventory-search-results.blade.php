@if(session()->get('location_selected_id') != '')
@if (!empty($user_data) && count($user_data) > 0)
@foreach ($user_data as $category => $items)
        <!-- Border Box -->
        <div class="border-box">
          <!-- Header Title -->
          <div class="grid-header text-center">
            <h6 class="m-0 text-white">{{ $category }}</h6>
          </div>

          <!-- Table -->
          <div class="table-responsive">
            <table class="table table-striped">
              <!-- Table Head -->
              <thead class="table-header">
                <tr>
                      <th><b>Sr. No.</b></th>
                      <th><b>Item</b></th>
                      <th><b>Qty</b></th>
                      <th><b>Unit</b></th>
                      <th><b>Price</b></th>
                      <th><b>Action</b></th>
                </tr>
              </thead>
              <!-- Table Body -->
              <tbody>

              @php $srNo = 1; @endphp
              @foreach ($items as $item)
                <tr>
                  <td>{{ $srNo++ }}.</td>
                  <td>{{ $item->item_name }}</td>
                  <td>{{ $item->quantity }}</td>
                  <td>{{ $item->unit_name }}</td>
                  <!-- <td>7</td> -->
                  <td>${{ $item->price }}</td>
                  <td>
                    <div>
                      <button class="btn btn-edit text-center shadow-sm edit-btn-item" data-id="{{ $item->id }}">
                        <i class="bi bi-pencil-square"></i> <br />Edit
                      </button>
                    </div>
                  </td>
                </tr>
                @endforeach



              </tbody>
            </table>
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

    @else
        <div class="border-box mb-4" id="search-results">
            <!-- Header Title -->
            <div class="grid-header text-center">
                <h6 class="m-0 text-white">Please Select Location First</h6>
            </div>
        </div>    
    @endif