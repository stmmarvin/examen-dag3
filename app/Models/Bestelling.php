<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bestelling extends Model
{
    use HasFactory;

    protected $table = 'Bestelling';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'KlantId',
        'Ordernummer',
        'Besteldatum',
        'Status',
        'TotaalBedrag',
        'IsActief',
        'Opmerking',
        'DatumAangemaakt',
        'DatumGewijzigd',
    ];

    protected $casts = [
        'Besteldatum' => 'datetime',
        'TotaalBedrag' => 'decimal:2',
        'IsActief' => 'boolean',
        'DatumAangemaakt' => 'datetime',
        'DatumGewijzigd' => 'datetime',
    ];

    public function klant()
    {
        return $this->belongsTo(Klant::class, 'KlantId', 'Id');
    }

    public function regels()
    {
        return $this->hasMany(BestellingRegel::class, 'BestellingId', 'Id');
    }
}
