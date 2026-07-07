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
        return $this->belongsToMany(Contact::class, 'medewerker_per_contact', 'medewerker_id', 'contact_id');
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
}
