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
}
