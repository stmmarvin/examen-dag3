<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medewerker extends Model
{
    use HasFactory;

    protected $table = 'Medewerker';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'UserId',
        'Voornaam',
        'Tussenvoegsel',
        'Achternaam',
        'Specialisatie',
        'Geboortedatum',
        'IsActief',
        'Opmerking',
        'DatumAangemaakt',
        'DatumGewijzigd',
    ];

    protected $casts = [
        'Geboortedatum' => 'date',
        'IsActief' => 'boolean',
        'DatumAangemaakt' => 'datetime',
        'DatumGewijzigd' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserId');
    }

    public function contacten()
    {
        return $this->belongsToMany(Contact::class, 'MedewerkerPerContact', 'MedewerkerId', 'ContactId');
    }

    public function behandelingen()
    {
        return $this->belongsToMany(Behandeling::class, 'MedewerkerPerBehandeling', 'MedewerkerId', 'BehandelingId');
    }

    public function getVolledigeNaamAttribute()
    {
        $naam = $this->Voornaam;
        if ($this->Tussenvoegsel) {
            $naam .= " {$this->Tussenvoegsel}";
        }
        $naam .= " {$this->Achternaam}";
        return $naam;
    }
}
