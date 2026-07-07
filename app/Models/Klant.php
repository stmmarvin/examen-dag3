<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klant extends Model
{
    use HasFactory;

    protected $table = 'klant';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'voornaam',
        'tussenvoegsel',
        'achternaam',
        'relatienummer',
        'bijzonderheden',
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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function contacten()
    {
        return $this->belongsToMany(Contact::class, 'klant_per_contact', 'klant_id', 'contact_id', 'id', 'id');
    }

    public function getVolledigeNaamAttribute()
    {
        $naam = $this->voornaam;
        if ($this->tussenvoegsel) {
            $naam .= " {$this->tussenvoegsel}";
        }
        $naam .= " {$this->achternaam}";
        return $naam;
    }

    public function getIdAttribute(): mixed
    {
        return $this->attributes['id'] ?? $this->attributes['Id'] ?? null;
    }

    public function getUserIdAttribute(): mixed
    {
        return $this->attributes['user_id'] ?? $this->attributes['UserId'] ?? null;
    }

    public function getVoornaamAttribute(): mixed
    {
        return $this->attributes['voornaam'] ?? $this->attributes['Voornaam'] ?? null;
    }

    public function getTussenvoegselAttribute(): mixed
    {
        return $this->attributes['tussenvoegsel'] ?? $this->attributes['Tussenvoegsel'] ?? null;
    }

    public function getAchternaamAttribute(): mixed
    {
        return $this->attributes['achternaam'] ?? $this->attributes['Achternaam'] ?? null;
    }

    public function getRelatienummerAttribute(): mixed
    {
        return $this->attributes['relatienummer'] ?? $this->attributes['Relatienummer'] ?? null;
    }

    public function getBijzonderhedenAttribute(): mixed
    {
        return $this->attributes['bijzonderheden'] ?? $this->attributes['Bijzonderheden'] ?? null;
    }

    public function setDatumGewijzigdAttribute(mixed $value): void
    {
        $this->attributes['datum_gewijzigd'] = $value;
    }
}
