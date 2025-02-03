@foreach ($unit_data as $item)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->created_at }}</td>
                  <td>{{ $item->unit_name }}</td>
                  <td>
                    <button
                      class="btn text-center shadow-sm btn-sm edit-btn-unit mu-edit" data-id="{{ $item->id }}">
                      <i class="bi bi-pencil-square"></i> Edit
                    </button>
                  </td>
                </tr>
              @endforeach