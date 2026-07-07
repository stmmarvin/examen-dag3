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

    public function getIdAttribute(): mixed
    {
        return $this->attributes['Id'] ?? null;
    }

    public function getStraatnaamAttribute(): mixed
    {
        return $this->attributes['Straatnaam'] ?? null;
    }

    public function getHuisnummerAttribute(): mixed
    {
        return $this->attributes['Huisnummer'] ?? null;
    }

    public function getToevoegingAttribute(): mixed
    {
        return $this->attributes['Toevoeging'] ?? null;
    }

    public function getPostcodeAttribute(): mixed
    {
        return $this->attributes['Postcode'] ?? null;
    }

    public function getPlaatsAttribute(): mixed
    {
        return $this->attributes['Plaats'] ?? null;
    }

    public function getEmailAttribute(): mixed
    {
        return $this->attributes['Email'] ?? null;
    }

    public function getMobielAttribute(): mixed
    {
        return $this->attributes['Mobiel'] ?? null;
    }
}
