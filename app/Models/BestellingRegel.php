<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BestellingRegel extends Model
{
    use HasFactory;

    protected $table = 'bestelling_regels';

    protected $fillable = [
        'bestelling_id',
        'product_id',
        'aantal',
        'prijs',
    ];

    public function bestelling()
    {
        return $this->belongsTo(Bestelling::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getSubtotaalAttribute()
    {
        return $this->aantal * $this->prijs;
    }
}
