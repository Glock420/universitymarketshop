<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipFee extends Model
{
    use HasFactory;
    protected $primaryKey = 'fee_id';
    public $timestamps = false;
}