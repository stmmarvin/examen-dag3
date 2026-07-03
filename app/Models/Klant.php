<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klant extends Model
{
    use HasFactory;

    protected $table = 'Klant';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'UserId',
        'Voornaam',
        'Tussenvoegsel',
        'Achternaam',
        'Relatienummer',
        'Bijzonderheden',
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

    public function user()
    {
        return $this->belongsTo(User::class, 'UserId');
    }

    public function contacten()
    {
        return $this->belongsToMany(Contact::class, 'KlantPerContact', 'KlantId', 'ContactId');
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
