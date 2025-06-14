<?php

namespace App;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	use HasUuids;

	protected $fillable = [
		'id',
		'patient_id',
		'order_date',
		'status',
		'currency',
		'total',
	];
}
