<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DietaryPreferenceModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dietary_preferences';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'patient_id',
        'preference',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(PatientModel::class, 'patient_id');
    }

}
