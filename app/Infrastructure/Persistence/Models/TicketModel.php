<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tickets';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'patient_id',
        'details',
        'type',
        'status'
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(PatientModel::class, 'patient_id');
    }

}
