<?php
namespace App\Http\Repository\Manager;

use App\Models\{
	Locations,
	Category,
	Unit,
	User,
	Items,
	MasterKitchenInventory,
	LocationWiseInventory,
	ActivityLog,
	InventoryHistory
};
use Illuminate\Database\QueryException;
use Illuminate\Support\Carbon;
use Config;
use DB;
use Session;
// use Illuminate\Support\Facades\Mail;
// use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class ShoppingListRepository
{
	public function editItem($reuest)
	{
		// $data_district = [];

		$data_users_data = MasterKitchenInventory::where('master_kitchen_inventory.id', '=', $reuest->locationId)
			->select('master_kitchen_inventory.*')
			->get()
			->toArray();

		$data_location = $data_users_data[0];
		// dd($data_location);
		return $data_location;
	}

	public function addKitchenInventoryByManager($request)
	{
		$sess_user_id = session()->get('login_id');
		$sess_user_name = session()->get('user_name');
		$sess_location_id = session()->get('location_selected_id');
		$inventoryIds = $request->input('master_inventory_id');
		$quantities = $request->input('quantity');

		$data = array();
		foreach ($inventoryIds as $index => $inventoryId) {
			$LocationsData = Locations::find($sess_location_id);
			$MasterInventoryData = MasterKitchenInventory::find($inventoryIds[$index]);

			$LocationWiseInventoryData = new LocationWiseInventory();
			$LocationWiseInventoryData->user_id = $sess_user_id;
			$LocationWiseInventoryData->inventory_id = $inventoryIds[$index];
			$LocationWiseInventoryData->location_id = $sess_location_id;
			$LocationWiseInventoryData->quantity = $quantities[$index];
			$LocationWiseInventoryData->master_quantity = $MasterInventoryData->quantity;
			$LocationWiseInventoryData->approved_by = 3;
			$LocationWiseInventoryData->created_at = Carbon::now('America/New_York');
			$LocationWiseInventoryData->save();
			$last_insert_id = $LocationWiseInventoryData->id;
		}

		if ($last_insert_id) {
			$LogMsg = config('constants.MANAGER.1111');

			$FinalLogMessage = $sess_user_name . ' ' . $LogMsg;
			$ActivityLogData = new ActivityLog();
			$ActivityLogData->user_id = $sess_user_id;
			$ActivityLogData->activity_message = $FinalLogMessage;
			$ActivityLogData->created_at = Carbon::now('America/New_York');
			$ActivityLogData->save();
		}

		$data = array();
		foreach ($inventoryIds as $index => $inventoryId) {
			$InventoryHistoryData = new InventoryHistory();
			$InventoryHistoryData->user_id = $sess_user_id;
			$InventoryHistoryData->inventory_id = $inventoryIds[$index];
			$InventoryHistoryData->location_id = $sess_location_id;
			$InventoryHistoryData->quantity = $quantities[$index];
			$InventoryHistoryData->approved_by = 3;
			$InventoryHistoryData->created_at = Carbon::now('America/New_York');
			$InventoryHistoryData->save();

			$LocationsData = Locations::find($sess_location_id);
			$MasterInventoryData = MasterKitchenInventory::find($inventoryIds[$index]);

			$logoPath = asset('/img/main_logo.png');
			$logoBase64 = base64_encode(file_get_contents($logoPath));

			$historyData[] = [
				'master_qty' => $MasterInventoryData->quantity,
				'inventory_id' => $MasterInventoryData->item_name,
				'quantity' => $quantities[$index],
				'location_id' => $LocationsData->location,
				'price' => $MasterInventoryData->price,
				'logimg' => $logoBase64
			];
		}

		// Generate PDF
		$htmlContent = view('inventory_history_pdf', ['historyData' => $historyData,
			'location' => $LocationsData->location,
			'currentDate' => now()->toDateString()])->render();
		$pdf = PDF::loadHTML($htmlContent);
		$pdfData = $pdf->output();  // Get raw PDF data

		// Encode PDF data to Base64
		$pdfBase64 = base64_encode($pdfData);

		// Prepare the response data
		$responseData = [
			'pdf' => $pdfBase64,
			'location' => $LocationsData->location,
			'currentDate' => now()->toDateString(),
		];

		// Return the response with the PDF and additional data
		return $responseData;
	}

	public function updateKitchenInventoryByManager($request)
	{
		$sess_user_id = session()->get('login_id');
		$sess_user_name = session()->get('user_name');
		$sess_location_id = session()->get('location_selected_id');
		$inventoryIds = $request->input('location_wise_inventory_id');
		$quantities = $request->input('quantity');
		$MasterInventoryIds = $request->input('master_inventory_id');
		// dd($MasterInventoryIds);

		foreach ($inventoryIds as $index => $inventoryId) {
			$existingInventory = LocationWiseInventory::where('id', $inventoryId)
				->first();

			if ($existingInventory) {
				LocationWiseInventory::where('id', $inventoryId)
					->update([
						'quantity' => $quantities[$index],
						'approved_by' => '3',
						'updated_at' => Carbon::now('America/New_York')
					]);
			} else {
				// Insert new inventory if not exists
				// $newInventory = new LocationWiseInventory();
				// $newInventory->inventory_id = $inventoryId;
				// $newInventory->location_id = $sess_location_id;
				// $newInventory->quantity = $quantities[$index];
				// $newInventory->save();

				// if($index==2)
				// {
				// 	dd($MasterInventoryIds[$index]);
				// }

				$LocationWiseInventoryData = new LocationWiseInventory();
				$LocationWiseInventoryData->user_id = $sess_user_id;
				$LocationWiseInventoryData->inventory_id = (int) $MasterInventoryIds[$index];
				$LocationWiseInventoryData->location_id = $sess_location_id;
				$LocationWiseInventoryData->quantity = $quantities[$index];
				$LocationWiseInventoryData->approved_by = 3;
				$LocationWiseInventoryData->created_at = Carbon::now('America/New_York');
				// dd($LocationWiseInventoryData);
				$LocationWiseInventoryData->save();
				$last_insert_id = $LocationWiseInventoryData->id;
			}

			$LocationsData = Locations::find($sess_location_id);
			// $LocationsWiseData = LocationWiseInventory::find($inventoryId);
			$MasterInventoryData = MasterKitchenInventory::find((int) $MasterInventoryIds[$index]);

			$logoPath = asset('/img/main_logo.png');
			$logoBase64 = base64_encode(file_get_contents($logoPath));

			$historyData[] = [
				'master_qty' => $MasterInventoryData->quantity,
				'inventory_id' => $MasterInventoryData->item_name,
				'quantity' => $quantities[$index],
				'location_id' => $LocationsData->location,
				'price' => $MasterInventoryData->price,
				'logimg' => $logoBase64
				// 'approved_by' => 1,
			];
		}
		$LogMsg = config('constants.MANAGER.1112');
		$FinalLogMessage = $sess_user_name . ' ' . $LogMsg;
		$ActivityLogData = new ActivityLog();
		$ActivityLogData->user_id = $sess_user_id;
		$ActivityLogData->activity_message = $FinalLogMessage;
		$ActivityLogData->created_at = Carbon::now('America/New_York');
		$ActivityLogData->save();

		$data = array();
		foreach ($inventoryIds as $index => $inventoryId) {
			$InventoryHistoryData = new InventoryHistory();
			$InventoryHistoryData->user_id = $sess_user_id;
			$InventoryHistoryData->inventory_id = (int) $MasterInventoryIds[$index];
			$InventoryHistoryData->location_id = $sess_location_id;
			$InventoryHistoryData->quantity = $quantities[$index];
			$InventoryHistoryData->approved_by = 3;
			$InventoryHistoryData->created_at = Carbon::now('America/New_York');
			$InventoryHistoryData->save();

			$LocationsData = Locations::find($sess_location_id);
			$MasterInventoryData = MasterKitchenInventory::find((int) $MasterInventoryIds[$index]);
		}

		// Generate PDF
		$htmlContent = view('inventory_history_pdf', ['historyData' => $historyData,
			'location' => $LocationsData->location,
			'currentDate' => now()->toDateString()])->render();
		$pdf = PDF::loadHTML($htmlContent);
		$pdfData = $pdf->output();  // Get raw PDF data

		// Encode PDF data to Base64
		$pdfBase64 = base64_encode($pdfData);

		// Prepare the response data
		$responseData = [
			'pdf' => $pdfBase64,
			'location' => $LocationsData->location,
			'currentDate' => now()->toDateString(),
		];

		// Return the response with the PDF and additional data
		return $responseData;
	}

	public function updateItem($request)
	{
		// dd($request);
		$user_data = MasterKitchenInventory::where('id', $request['edit_id'])
			->update([
				'item_name' => $request['item_name'],
				'category' => $request['category'],
				'unit' => $request['unit'],
				'price' => $request['price'],
				'location_id' => $request['location_id'],
				'quantity' => $request['quantity'],
			]);

		$LogMsg = config('constants.MANAGER.1112');

		$FinalLogMessage = $sess_user_name . ' ' . $LogMsg;
		$ActivityLogData = new ActivityLog();
		$ActivityLogData->user_id = $sess_user_id;
		$ActivityLogData->activity_message = $FinalLogMessage;
		$ActivityLogData->save();

		// return $request->edit_id;

		$htmlContent = view('inventory_history_pdf')->render();

		$pdf = PDF::loadHTML($htmlContent);
		// dd($pdf);
		// return $pdf->download('inventory_history.pdf');
		return $pdf->download('inventory_history.pdf');
	}

	public function deleteItem($id)
	{
		$all_data = [];

		$student_data = MasterKitchenInventory::find($id);
		// dd($student_data);
		// Delete the record from the database
		$is_deleted = $student_data->is_deleted == 1 ? 0 : 1;
		$student_data->is_deleted = $is_deleted;
		$student_data->save();

		return $student_data;

		// }
		// return response()->json([
		//     'status' => 'error',
		//     'message' => 'Intern ID Card details not found.',
		// ], 404);
	}
}
