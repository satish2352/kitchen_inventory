<?php
namespace App\Http\Repository\SuperAdmin;

use Illuminate\Database\QueryException;
use DB;
use Illuminate\Support\Carbon;
use Session;
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
use Config;
// use Illuminate\Support\Facades\Mail;
// use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\Facade\Pdf as PDF;



class ShoppingListRepository
{

    public function editItem($reuest)
	{

		// $data_district = [];

		$data_users_data = MasterKitchenInventory::where('master_kitchen_inventory.id', '=', $reuest->locationId)
			->select('master_kitchen_inventory.*')->get()
			->toArray();
						
		$data_location = $data_users_data[0];
		// dd($data_location);
		return $data_location;
	}

    public function addKitchenInventoryBySuperAdmin($request)
	{
		$sess_user_id = session()->get('login_id');
		$sess_user_name = session()->get('user_name');
		$sess_location_id = session()->get('location_selected_id');
		$inventoryIds = $request->input('master_inventory_id');
		$quantities = $request->input('quantity');

		$data =array();
		foreach ($inventoryIds as $index => $inventoryId) {
		$LocationWiseInventoryData = new LocationWiseInventory();
		$LocationWiseInventoryData->user_id = $sess_user_id;
		$LocationWiseInventoryData->inventory_id = $inventoryIds[$index];
		$LocationWiseInventoryData->location_id = $sess_location_id;
		$LocationWiseInventoryData->quantity = $quantities[$index];
		$LocationWiseInventoryData->approved_by = 1;
		$LocationWiseInventoryData->created_at = Carbon::now('America/New_York');
    	// $LocationWiseInventoryData->updated_at = Carbon::now('America/New_York'),
		$LocationWiseInventoryData->save();
		$last_insert_id = $LocationWiseInventoryData->id;
		}

		if($last_insert_id)
		{
		$LogMsg= config('constants.MANAGER.1111');

		$FinalLogMessage = $sess_user_name.' '.$LogMsg;
		$ActivityLogData = new ActivityLog();
		$ActivityLogData->user_id = $sess_user_id;
		$ActivityLogData->activity_message = $FinalLogMessage;
		$ActivityLogData->created_at = Carbon::now('America/New_York');
		$ActivityLogData->save();
		}

		$data =array();
		foreach ($inventoryIds as $index => $inventoryId) {
		$InventoryHistoryData = new InventoryHistory();
		$InventoryHistoryData->user_id = $sess_user_id;
		$InventoryHistoryData->inventory_id = $inventoryIds[$index];
		$InventoryHistoryData->location_id = $sess_location_id;
		$InventoryHistoryData->quantity = $quantities[$index];
		$InventoryHistoryData->approved_by = 1;
		$InventoryHistoryData->created_at = Carbon::now('America/New_York');
		$InventoryHistoryData->save();

		$LocationsData = Locations::find($sess_location_id);
		$MasterInventoryData = MasterKitchenInventory::find($inventoryIds[$index]);

		$logoPath = asset('/img/main_logo.png');
		$logoBase64 = base64_encode(file_get_contents($logoPath));

		// Store data for PDF
		$historyData[] = [
			'master_qty' => $MasterInventoryData->quantity,
			'inventory_id' => $MasterInventoryData->item_name,
			'quantity' => $quantities[$index],
			'location_id' => $LocationsData->location,
			'price' => $MasterInventoryData->price,
			'logimg'=> $logoBase64
			// 'approved_by' => 1,
		];

		}

		// Generate PDF
		$htmlContent = view('inventory_history_pdf', ['historyData' => $historyData,
		'location'=>$LocationsData->location,
		'currentDate' => now()->toDateString()])->render();
		$pdf = PDF::loadHTML($htmlContent);
		$pdfData = $pdf->output(); // Get raw PDF data


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

public function updateKitchenInventoryBySuperAdmin($request) {
		$sess_user_id = session()->get('login_id');
		$sess_user_name = session()->get('user_name');
		$sess_location_id = session()->get('location_selected_id');
		$inventoryIds = $request->input('location_wise_inventory_id');
		$quantities = $request->input('quantity');
		$MasterInventoryIds = $request->input('master_inventory_id');

	
		foreach ($inventoryIds as $index => $inventoryId) {
			$existingInventory = LocationWiseInventory::where('id', $inventoryId)
			->first();
			$MasterInventoryData = MasterKitchenInventory::find((int) $MasterInventoryIds[$index]);
			if ($existingInventory) {

			LocationWiseInventory::where('id', $inventoryId)
				->update([
					'quantity' => $quantities[$index],
					'master_quantity' => $MasterInventoryData->quantity,
					'master_price' => $MasterInventoryData->price,
					'approved_by' => '1',
					'updated_at' => Carbon::now('America/New_York')

				]);
			}else {
				$LocationWiseInventoryData = new LocationWiseInventory();
				$LocationWiseInventoryData->user_id = $sess_user_id;
				$LocationWiseInventoryData->inventory_id = (int) $MasterInventoryIds[$index];
				$LocationWiseInventoryData->location_id = $sess_location_id;				
				$LocationWiseInventoryData->master_quantity = $MasterInventoryData->quantity;
				$LocationWiseInventoryData->master_price = $MasterInventoryData->price;
				$LocationWiseInventoryData->quantity = $quantities[$index];
				$LocationWiseInventoryData->approved_by = 2;
				$LocationWiseInventoryData->created_at = Carbon::now('America/New_York');
				// dd($LocationWiseInventoryData);
				$LocationWiseInventoryData->save();
				$last_insert_id = $LocationWiseInventoryData->id;
			}
				
				$LocationsData = Locations::find($sess_location_id);
		// $LocationsWiseData = LocationWiseInventory::find($inventoryId);
		// $MasterInventoryData = MasterKitchenInventory::find($LocationsWiseData->inventory_id);
		$MasterInventoryData = MasterKitchenInventory::find((int) $MasterInventoryIds[$index]);

		$logoPath = asset('/img/main_logo.png');
		$logoBase64 = base64_encode(file_get_contents($logoPath));

		$historyData[] = [
			'master_qty' => $MasterInventoryData->quantity,
			'inventory_id' => $MasterInventoryData->item_name,
			'quantity' => $quantities[$index],
			'location_id' => $LocationsData->location,
			'price' => $MasterInventoryData->price,
			'logimg'=> $logoBase64
			// 'approved_by' => 1,
		];
		}
	// dd($historyData);
		$LogMsg = config('constants.SUPER_ADMIN.1112');
		$FinalLogMessage = $sess_user_name . ' ' . $LogMsg;
		$ActivityLogData = new ActivityLog();
		$ActivityLogData->user_id = $sess_user_id;
		$ActivityLogData->activity_message = $FinalLogMessage;
		$ActivityLogData->created_at = Carbon::now('America/New_York');
		$ActivityLogData->save();
	
		$data =array();
		foreach ($inventoryIds as $index => $inventoryId) {
		$InventoryHistoryData = new InventoryHistory();
		$InventoryHistoryData->user_id = $sess_user_id;
		$InventoryHistoryData->inventory_id = (int) $MasterInventoryIds[$index];
		$InventoryHistoryData->location_id = $sess_location_id;
		$InventoryHistoryData->quantity = $quantities[$index];
		$InventoryHistoryData->approved_by = 1;
		$InventoryHistoryData->created_at = Carbon::now('America/New_York');
		$InventoryHistoryData->save();

		$LocationsData = Locations::find($sess_location_id);
		$MasterInventoryData = MasterKitchenInventory::find((int) $MasterInventoryIds[$index]);
		}
	
		// Generate PDF
		$htmlContent = view('inventory_history_pdf', ['historyData' => $historyData,
		'location'=>$LocationsData->location,
		'currentDate' => now()->toDateString()])->render();
		$pdf = PDF::loadHTML($htmlContent);
		$pdfData = $pdf->output(); // Get raw PDF data


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
	


}