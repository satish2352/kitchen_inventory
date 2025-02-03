<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKitchenInventory extends Model
{
    use HasFactory;
    protected $table = 'master_kitchen_inventory';
    protected $primaryKey = 'id';
}
