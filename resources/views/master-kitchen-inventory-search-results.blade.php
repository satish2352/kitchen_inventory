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
                  <th>Item</th>
                  <!-- <th>Qty</th> -->
                  <th>Unit</th>
                  <!-- <th>IX</th> -->
                  <th>Price</th>
                  <th>Action</th>
                </tr>
              </thead>
              <!-- Table Body -->
              <tbody>


              @foreach ($items as $item)
                <tr>
                  <td>{{ $item->item_name }}</td>
                  <!-- <td>
                    <input type="text" name="quantity" class="form-control qty-input" />
                  </td> -->
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