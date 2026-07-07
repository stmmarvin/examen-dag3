<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Behandeling Model
 * Representeert een salon behandeling zoals knippen, kleuren, etc.
 */
class Behandeling extends Model
{
    use HasFactory;

    protected $table = 'behandeling';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'naam',
        'omschrijving',
        'duur_minuten',
        'prijs',
        'is_actief',
        'opmerking',
        'datum_aangemaakt',
        'datum_gewijzigd',
    ];

    protected $casts = [
        'prijs' => 'decimal:2',
        'is_actief' => 'boolean',
        'datum_aangemaakt' => 'datetime',
        'datum_gewijzigd' => 'datetime',
    ];

    /**
     * Relatie met producten via behandeling_product pivot tabel
     */
    public function producten()
    {
        return $this->belongsToMany(Product::class, 'behandeling_product', 'behandeling_id', 'product_id')
            ->withPivot('aantal');
    }
}
