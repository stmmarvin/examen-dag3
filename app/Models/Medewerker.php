<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Medewerker Model
 * Representeert een salon medewerker
 */
class Medewerker extends Model
{
    use HasFactory;

    protected $table = 'medewerker';
    protected $primaryKey = 'Id';
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
        'Geboortedatum' => 'date',
        'IsActief' => 'boolean',
        'DatumAangemaakt' => 'datetime',
        'DatumGewijzigd' => 'datetime',
    ];

    /**
     * Relatie met User model
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'UserId');
    }

    /**
     * Many-to-many relatie met Contact
     */
    public function contacten()
    {
        return $this->belongsToMany(Contact::class, 'medewerker_per_contact', 'medewerker_id', 'contact_id', 'Id', 'Id');
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
        return $this->attributes['UserId'] ?? null;
    }

    public function setUserIdAttribute(mixed $value): void
    {
        $this->attributes['UserId'] = $value;
    }

    public function getVoornaamAttribute(): mixed
    {
        return $this->attributes['Voornaam'] ?? null;
    }

    public function setVoornaamAttribute(mixed $value): void
    {
        $this->attributes['Voornaam'] = $value;
    }

    public function getTussenvoegselAttribute(): mixed
    {
        return $this->attributes['Tussenvoegsel'] ?? null;
    }

    public function setTussenvoegselAttribute(mixed $value): void
    {
        $this->attributes['Tussenvoegsel'] = $value;
    }

    public function getAchternaamAttribute(): mixed
    {
        return $this->attributes['Achternaam'] ?? null;
    }

    public function setAchternaamAttribute(mixed $value): void
    {
        $this->attributes['Achternaam'] = $value;
    }

    public function getSpecialisatieAttribute(): mixed
    {
        return $this->attributes['Specialisatie'] ?? null;
    }

    public function setSpecialisatieAttribute(mixed $value): void
    {
        $this->attributes['Specialisatie'] = $value;
    }

    public function getGeboortedatumAttribute(): mixed
    {
        return $this->attributes['Geboortedatum'] ?? null;
    }

    public function setGeboortedatumAttribute(mixed $value): void
    {
        $this->attributes['Geboortedatum'] = $value;
    }

    public function getIsActiefAttribute(): mixed
    {
        return $this->attributes['IsActief'] ?? null;
    }

    public function setIsActiefAttribute(mixed $value): void
    {
        $this->attributes['IsActief'] = $value;
    }

    public function getOpmerkingAttribute(): mixed
    {
        return $this->attributes['Opmerking'] ?? null;
    }

    public function setOpmerkingAttribute(mixed $value): void
    {
        $this->attributes['Opmerking'] = $value;
    }

    public function setDatumGewijzigdAttribute(mixed $value): void
    {
        $this->attributes['DatumGewijzigd'] = $value;
    }
}
