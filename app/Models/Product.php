<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Product Model
 * Representeert een salon product uit de Product tabel
 */
class Product extends Model
{
    use HasFactory;

    protected $table = 'product';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'categorie_id',
        'naam',
        'omschrijving',
        'merk',
        'ean_code',
        'houdbaarheidsdatum',
        'inkoop_prijs',
        'verkoop_prijs',
        'is_actief',
        'opmerking',
        'datum_aangemaakt',
        'datum_gewijzigd',
    ];

    protected $casts = [
        'houdbaarheidsdatum' => 'date',
        'inkoop_prijs' => 'decimal:2',
        'verkoop_prijs' => 'decimal:2',
        'is_actief' => 'boolean',
        'datum_aangemaakt' => 'datetime',
        'datum_gewijzigd' => 'datetime',
    ];

    /**
     * Relatie met Voorraad
     */
    public function voorraad()
    {
        return $this->hasOne(Voorraad::class, 'product_id', 'id');
    }

    /**
     * Relatie met Categorie
     */
    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }

    /**
     * Relatie met behandelingen via pivot tabel
     */
    public function behandelingen()
    {
        return $this->belongsToMany(Behandeling::class, 'behandeling_product', 'product_id', 'behandeling_id')
            ->withPivot('aantal');
    }
}
