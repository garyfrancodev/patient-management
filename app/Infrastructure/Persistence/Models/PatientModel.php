<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'patients';
    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'user_id',
        'name',
        'dob',
        'gender',
        'phone',
        'email',
        'full_name',
        'dni'
    ];

    protected function casts(): array
    {
        return [
          'dob' => 'date'
        ];
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(AppointmentModel::class, 'patient_id');
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(AddressModel::class, 'patient_id');
    }
}
