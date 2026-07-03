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

    protected $table = 'Product';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'CategorieId',
        'Naam',
        'Omschrijving',
        'Merk',
        'EANcode',
        'Houdbaarheidsdatum',
        'InkoopPrijs',
        'VerkoopPrijs',
        'IsActief',
        'Opmerking',
        'DatumAangemaakt',
        'DatumGewijzigd',
    ];

    protected $casts = [
        'Houdbaarheidsdatum' => 'date',
        'InkoopPrijs' => 'decimal:2',
        'VerkoopPrijs' => 'decimal:2',
        'IsActief' => 'boolean',
        'DatumAangemaakt' => 'datetime',
        'DatumGewijzigd' => 'datetime',
    ];

    /**
     * Relatie met Voorraad
     */
    public function voorraad()
    {
        return $this->hasOne(Voorraad::class, 'ProductId', 'Id');
    }
}
