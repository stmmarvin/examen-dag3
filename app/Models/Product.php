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
        'naam',
        'beschrijving',
        'prijs',
        'voorraad',
        'sku',
    ];

    protected $casts = [
        'prijs' => 'decimal:2',
    ];

    public function behandelingen()
    {
        return $this->belongsToMany(Behandeling::class, 'behandeling_product', 'product_id', 'behandeling_id')
                    ->withPivot('aantal')
                    ->withTimestamps();
    }
}
