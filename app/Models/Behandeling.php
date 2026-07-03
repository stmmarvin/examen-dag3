<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Behandeling Model
 * Representeert een salon behandeling zoals knippen, kleuren, etc.
 */
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
        'Prijs' => 'decimal:2',
        'IsActief' => 'boolean',
        'DatumAangemaakt' => 'datetime',
        'DatumGewijzigd' => 'datetime',
    ];

    /**
     * Relatie met voorraad via BehandelingPerVoorraad pivot tabel
     */
    public function voorraadItems()
    {
        return $this->belongsToMany(Voorraad::class, 'BehandelingPerVoorraad', 'BehandelingId', 'VoorraadId');
    }
}
