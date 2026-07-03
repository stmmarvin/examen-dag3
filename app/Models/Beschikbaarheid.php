<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beschikbaarheid extends Model
{
    use HasFactory;

    protected $table = 'Beschikbaarheid';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'MedewerkerId',
        'Dag',
        'StartTijd',
        'EindTijd',
        'IsBeschikbaar',
        'IsActief',
        'Opmerking',
        'DatumAangemaakt',
        'DatumGewijzigd',
    ];

    protected $casts = [
        'IsBeschikbaar' => 'boolean',
        'IsActief' => 'boolean',
        'DatumAangemaakt' => 'datetime',
        'DatumGewijzigd' => 'datetime',
    ];

    public function medewerker()
    {
        return $this->belongsTo(Medewerker::class, 'MedewerkerId', 'Id');
    }
}
