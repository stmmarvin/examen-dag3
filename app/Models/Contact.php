<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'Contact';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'Straatnaam',
        'Huisnummer',
        'Toevoeging',
        'Postcode',
        'Plaats',
        'Email',
        'Mobiel',
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

    public function klanten()
    {
        return $this->belongsToMany(Klant::class, 'KlantPerContact', 'ContactId', 'KlantId');
    }
}
