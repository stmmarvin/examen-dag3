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
        return $this->belongsToMany(Contact::class, 'klant_per_contact', 'klant_id', 'contact_id');
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
}
