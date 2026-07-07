<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Product Model
 * Representeert een salon product zoals shampoo, conditioner, etc.
 */
class Product extends Model
{
    use HasFactory;

    protected $table = 'product';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'naam',
        'categorie_id',
        'omschrijving',
        'merk',
        'ean_code',
        'houdbaarheidsdatum',
        'inkoop_prijs',
        'verkoop_prijs',
    ];

    protected $casts = [
        'inkoop_prijs' => 'decimal:2',
        'verkoop_prijs' => 'decimal:2',
        'houdbaarheidsdatum' => 'date',
    ];

    /**
     * Relatie met Categorie
     * Een product behoort tot één categorie
     */
    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }

    /**
     * Relatie met Voorraad
     * Een product heeft één voorraad record
     */
    public function voorraad()
    {
        return $this->hasOne(Voorraad::class, 'product_id');
    }

    /**
     * Many-to-many relatie met Behandeling
     * Een product kan gebruikt worden in meerdere behandelingen
     */
    public function behandelingen()
    {
        return $this->belongsToMany(Behandeling::class, 'behandeling_product', 'product_id', 'behandeling_id')
                    ->withPivot('aantal');
    }
}
