<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klant extends Model
{
    use HasFactory;

    // Koppelt dit model aan de klanttabel uit de examen-database.
    protected $table = 'klant';
    protected $primaryKey = 'id';
    public $timestamps = false;

    // Velden die via mass assignment mogen worden opgeslagen.
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

    // Zet databasewaarden automatisch om naar handige PHP-types.
    protected $casts = [
        'is_actief' => 'boolean',
        'datum_aangemaakt' => 'datetime',
        'datum_gewijzigd' => 'datetime',
    ];

    public function user()
    {
        // Een klant hoort bij een gebruikersaccount.
        return $this->belongsTo(User::class, 'user_id');
    }

    public function contacten()
    {
        // Een klant kan via de koppeltabel een of meer contactadressen hebben.
        return $this->belongsToMany(Contact::class, 'klant_per_contact', 'klant_id', 'contact_id', 'id', 'id');
    }

    public function getVolledigeNaamAttribute()
    {
        // Bouwt de volledige naam op uit voornaam, tussenvoegsel en achternaam.
        $naam = $this->voornaam;
        if ($this->tussenvoegsel) {
            $naam .= " {$this->tussenvoegsel}";
        }
        $naam .= " {$this->achternaam}";
        return $naam;
    }

    public function getIdAttribute(): mixed
    {
        // Ondersteunt zowel kleine als hoofdletter-kolomnamen.
        return $this->attributes['id'] ?? $this->attributes['Id'] ?? null;
    }

    public function getUserIdAttribute(): mixed
    {
        // Ondersteunt zowel user_id als UserId uit verschillende databases.
        return $this->attributes['user_id'] ?? $this->attributes['UserId'] ?? null;
    }

    public function getVoornaamAttribute(): mixed
    {
        // Leest de voornaam uit beide mogelijke kolomnamen.
        return $this->attributes['voornaam'] ?? $this->attributes['Voornaam'] ?? null;
    }

    public function getTussenvoegselAttribute(): mixed
    {
        // Leest het tussenvoegsel uit beide mogelijke kolomnamen.
        return $this->attributes['tussenvoegsel'] ?? $this->attributes['Tussenvoegsel'] ?? null;
    }

    public function getAchternaamAttribute(): mixed
    {
        // Leest de achternaam uit beide mogelijke kolomnamen.
        return $this->attributes['achternaam'] ?? $this->attributes['Achternaam'] ?? null;
    }

    public function getRelatienummerAttribute(): mixed
    {
        // Leest het relatienummer uit beide mogelijke kolomnamen.
        return $this->attributes['relatienummer'] ?? $this->attributes['Relatienummer'] ?? null;
    }

    public function getBijzonderhedenAttribute(): mixed
    {
        // Leest bijzonderheden uit beide mogelijke kolomnamen.
        return $this->attributes['bijzonderheden'] ?? $this->attributes['Bijzonderheden'] ?? null;
    }

    public function setDatumGewijzigdAttribute(mixed $value): void
    {
        // Schrijft de wijzigingsdatum altijd naar de kolomnaam van de examen-database.
        $this->attributes['datum_gewijzigd'] = $value;
    }
}
