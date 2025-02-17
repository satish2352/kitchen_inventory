            @if(session()->get('location_selected_id') !='')
            <!-- second if start -->
            @if($InventoryData['DataType']=='MasterData')
            <form action="{{ route('add-kitchen-inventory-by-admin') }}" id="frm_register_add" method="POST">
               @csrf
               @if (!empty($InventoryData['data_location_wise_inventory']) && count($InventoryData['data_location_wise_inventory']) > 0)
               @foreach ($InventoryData['data_location_wise_inventory'] as $category => $items)
               <!-- Border Box -->
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
                           <th><b>Req. Qty For This Location</b></th>
                           <th><b>Item</b></th>
                           <th><b>Available Qty</b></th>
                           <th><b>Unit</b></th>
                           <!-- <th><b>Price</b></th> -->
                        </tr>
                     </thead>
                     <!-- Table Body -->
                     <tbody>
                        @php $srNo = 1; @endphp
                        @foreach ($items as $item)
                        <input type="hidden" class="form-control" name="master_inventory_id[]" id="master_inventory_id" value="{{ $item['id'] }}"/>
                        <tr>
                           <td> {{ $srNo++ }} </td>
                           <td>{{ $item['masterQuantity'] }}</td>
                           <td>{{ $item['item_name'] }}</td>
                           <td>
                              <input type="text" name="quantity[]" class="form-control qty-input-add" style="text-align: center;" placeholder="QTY" style="justify-self: center;">
                              <span class="error-message text-danger"></span>
                           </td>
                           <td>{{ $item['unit_name'] }}</td>
                           <!-- <td>{{ $item['price'] }}</td> -->
                        </tr>
                        @endforeach
                        <tr>
                     </tbody>
                  </table>
               </div>
               @endforeach
               <div class="text-center mt-3">
                  <button type="submit" class="btn btn-success">Submit Inventory</button>
               </div>
               @else
               <div class="border-box mb-4" id="search-results">
                  <!-- Header Title -->
                  <div class="grid-header text-center">
                     <h6 class="m-0 text-white">No List Found For Kitchen Inventory. Please Contact To Super Admin</h6>
                  </div>
               </div>
               @endif
               <!-- Submit Button -->
            </form>
            <!-- second if end and else start -->
            @elseif($InventoryData['DataType']=='LocationWiseData')
            <form action="{{ route('update-kitchen-inventory-by-admin') }}" id="frm_register_edit" method="POST">
               @csrf
               @if (!empty($InventoryData['data_location_wise_inventory']) && count($InventoryData['data_location_wise_inventory']) > 0)
               @foreach ($InventoryData['data_location_wise_inventory'] as $category => $items)
               <!-- Border Box -->
               <div class="border-box mb-4" id="search-results">
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
                              <th><b>Req. Qty For This Location</b></th>
                              <th><b>Item</b></th>
                              <th><b>Available Qty</b></th>
                              <th><b>Unit</b></th>
                              <!-- <th><b>Price</b></th> -->
                           </tr>
                        </thead>
                        <!-- Table Body -->
                        <tbody>
                           @php $srNo = 1; @endphp
                           @foreach ($items as $item)
                           <input type="hidden" class="form-control" name="location_wise_inventory_id[]" id="location_wise_inventory_id" value="{{ $item['locationWiseId'] }}"/>
                           <input type="hidden" class="form-control" name="master_inventory_id[]" id="master_inventory_id" value="{{ $item['masterInventoryId'] }}"/>
                           <tr>
                              <td> {{ $srNo++ }} </td>
                              <td>{{ $item['masterQuantity'] }}</td>
                              <td>{{ $item['item_name'] }}</td>
                              <td>
                                 <input type="text" name="quantity[]" class="form-control qty-input-edit" style="text-align: center;" value="{{ $item['quantity'] }}"  placeholder="QTY" />
                                 <span class="error-message text-danger"></span>
                              </td>
                              <td>{{ $item['unit_name'] }}</td>
                              <!-- <td>{{ $item['price'] }}</td> -->
                           </tr>
                           @endforeach
                           <tr>
                        </tbody>
                     </table>
                  </div>
               </div>
               @endforeach
               <div class="text-center mt-3">
                  <button type="submit" class="btn btn-success">Submit Inventory</button>
               </div>
               @else
               <div class="border-box mb-4" id="search-results">
                  <!-- Header Title -->
                  <div class="grid-header text-center">
                     <h6 class="m-0 text-white">No List Found For Kitchen Inventory. Please Contact To Super Admin</h6>
                  </div>
               </div>
               @endif
               <!-- Submit Button -->
            </form>
            <!-- second if close -->
            @endif
            <!-- first if end and else stat -->
            @else
            <div class="border-box mb-4" id="search-results">
               <!-- Header Title -->
               <div class="grid-header text-center">
                  <h6 class="m-0 text-white">Please Select Location First</h6>
               </div>
            </div>
            <!-- first if end and else ens -->
            @endif