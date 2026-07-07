<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Medewerker Model
 * Representeert een salon medewerker
 */
class Medewerker extends Model
{
    use HasFactory;

    protected $table = 'medewerker';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'voornaam',
        'tussenvoegsel',
        'achternaam',
        'specialisatie',
        'geboortedatum',
        'is_actief',
        'opmerking',
        'datum_aangemaakt',
        'datum_gewijzigd',
    ];

    protected $casts = [
        'geboortedatum' => 'date',
        'is_actief' => 'boolean',
        'datum_aangemaakt' => 'datetime',
        'datum_gewijzigd' => 'datetime',
    ];

    /**
     * Relatie met User model
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Many-to-many relatie met Contact
     */
    public function contacten()
    {
        return $this->belongsToMany(Contact::class, 'medewerker_per_contact', 'medewerker_id', 'contact_id', 'id', 'id');
    }

    /**
     * Helper om volledige naam te krijgen
     */
    public function getVolledigeNaamAttribute()
    {
        $naam = $this->voornaam;
        if ($this->tussenvoegsel) {
            $naam .= ' ' . $this->tussenvoegsel;
        }
        $naam .= ' ' . $this->achternaam;
        return $naam;
    }

    public function getUserIdAttribute(): mixed
    {
        return $this->attributes['user_id'] ?? $this->attributes['UserId'] ?? null;
    }

    public function setUserIdAttribute(mixed $value): void
    {
        $this->attributes['user_id'] = $value;
    }

    public function getVoornaamAttribute(): mixed
    {
        return $this->attributes['voornaam'] ?? $this->attributes['Voornaam'] ?? null;
    }

    public function setVoornaamAttribute(mixed $value): void
    {
        $this->attributes['voornaam'] = $value;
    }

    public function getTussenvoegselAttribute(): mixed
    {
        return $this->attributes['tussenvoegsel'] ?? $this->attributes['Tussenvoegsel'] ?? null;
    }

    public function setTussenvoegselAttribute(mixed $value): void
    {
        $this->attributes['tussenvoegsel'] = $value;
    }

    public function getAchternaamAttribute(): mixed
    {
        return $this->attributes['achternaam'] ?? $this->attributes['Achternaam'] ?? null;
    }

    public function setAchternaamAttribute(mixed $value): void
    {
        $this->attributes['achternaam'] = $value;
    }

    public function getSpecialisatieAttribute(): mixed
    {
        return $this->attributes['specialisatie'] ?? $this->attributes['Specialisatie'] ?? null;
    }

    public function setSpecialisatieAttribute(mixed $value): void
    {
        $this->attributes['specialisatie'] = $value;
    }

    public function getGeboortedatumAttribute(): mixed
    {
        $datum = $this->attributes['geboortedatum'] ?? $this->attributes['Geboortedatum'] ?? null;

        return $datum ? Carbon::parse($datum) : null;
    }

    public function setGeboortedatumAttribute(mixed $value): void
    {
        $this->attributes['geboortedatum'] = $value;
    }

    public function getIsActiefAttribute(): mixed
    {
        return $this->attributes['is_actief'] ?? $this->attributes['IsActief'] ?? null;
    }

    public function setIsActiefAttribute(mixed $value): void
    {
        $this->attributes['is_actief'] = $value;
    }

    public function getOpmerkingAttribute(): mixed
    {
        return $this->attributes['opmerking'] ?? $this->attributes['Opmerking'] ?? null;
    }

    public function setOpmerkingAttribute(mixed $value): void
    {
        $this->attributes['opmerking'] = $value;
    }

    public function setDatumGewijzigdAttribute(mixed $value): void
    {
        $this->attributes['datum_gewijzigd'] = $value;
    }
}
