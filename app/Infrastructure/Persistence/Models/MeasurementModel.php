<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MeasurementModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'measurements';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'patient_id',
        'consultation_id',
        'height',
        'weight',
        'body_fat',
        'notes'
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(PatientModel::class, 'patient_id');
    }
}
