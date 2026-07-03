<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voorraad extends Model
{
    use HasFactory;

    protected $table = 'Voorraad';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'ProductId',
        'AantalOpVoorraad',
        'Aantaluitgegeven',
        'Aantalbijgekomen',
        'IsActief',
        'Opmerking',
        'DatumAangemaakt',
        'DatumGewijzigd',
    ];

    protected $casts = [
        'IsActief' => 'boolean',
        'DatumAangemaakt' => 'datetime',
        'DatumGewijzigd' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductId', 'Id');
    }

    public function behandelingen()
    {
        return $this->belongsToMany(Behandeling::class, 'BehandelingPerVoorraad', 'VoorraadId', 'BehandelingId');
    }
}
