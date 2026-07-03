<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'producten';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'categorie_id',
        'naam',
        'omschrijving',
        'merk',
        'ean_code',
        'houdbaarheidsdatum',
        'inkoop_prijs',
        'verkoop_prijs',
    ];

    protected $casts = [
        'houdbaarheidsdatum' => 'date',
        'inkoop_prijs' => 'decimal:2',
        'verkoop_prijs' => 'decimal:2',
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }

    public function voorraad()
    {
        return $this->hasOne(Voorraad::class, 'product_id');
    }
}
