<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Behandeling extends Model
{
    use HasFactory;

    protected $table = 'Behandeling';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'Naam',
        'Omschrijving',
        'Duurminuten',
        'Prijs',
        'IsActief',
        'Opmerking',
        'DatumAangemaakt',
        'DatumGewijzigd',
    ];

    protected $casts = [
        'IsActief' => 'boolean',
        'Prijs' => 'decimal:2',
        'DatumAangemaakt' => 'datetime',
        'DatumGewijzigd' => 'datetime',
    ];

    public function medewerkers()
    {
        return $this->belongsToMany(Medewerker::class, 'MedewerkerPerBehandeling', 'BehandelingId', 'MedewerkerId');
    }

    public function voorraad()
    {
        return $this->belongsToMany(Voorraad::class, 'BehandelingPerVoorraad', 'BehandelingId', 'VoorraadId');
    }
}
