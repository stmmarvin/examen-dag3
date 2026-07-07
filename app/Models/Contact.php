<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'contact';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'straatnaam',
        'huisnummer',
        'toevoeging',
        'postcode',
        'plaats',
        'email',
        'mobiel',
        'is_actief',
        'opmerking',
        'datum_aangemaakt',
        'datum_gewijzigd',
    ];

    protected $casts = [
        'is_actief' => 'boolean',
        'datum_aangemaakt' => 'datetime',
        'datum_gewijzigd' => 'datetime',
    ];

    public function klanten()
    {
        return $this->belongsToMany(Klant::class, 'klant_per_contact', 'contact_id', 'klant_id');
    }

    public function getIdAttribute(): mixed
    {
        return $this->attributes['id'] ?? $this->attributes['Id'] ?? null;
    }

    public function getStraatnaamAttribute(): mixed
    {
        return $this->attributes['straatnaam'] ?? $this->attributes['Straatnaam'] ?? null;
    }

    public function getHuisnummerAttribute(): mixed
    {
        return $this->attributes['huisnummer'] ?? $this->attributes['Huisnummer'] ?? null;
    }

    public function getToevoegingAttribute(): mixed
    {
        return $this->attributes['toevoeging'] ?? $this->attributes['Toevoeging'] ?? null;
    }

    public function getPostcodeAttribute(): mixed
    {
        return $this->attributes['postcode'] ?? $this->attributes['Postcode'] ?? null;
    }

    public function getPlaatsAttribute(): mixed
    {
        return $this->attributes['plaats'] ?? $this->attributes['Plaats'] ?? null;
    }

    public function getEmailAttribute(): mixed
    {
        return $this->attributes['email'] ?? $this->attributes['Email'] ?? null;
    }

    public function getMobielAttribute(): mixed
    {
        return $this->attributes['mobiel'] ?? $this->attributes['Mobiel'] ?? null;
    }

    public function setDatumGewijzigdAttribute(mixed $value): void
    {
        $this->attributes['datum_gewijzigd'] = $value;
    }
}
