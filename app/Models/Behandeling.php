<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Behandeling extends Model
{
    use HasFactory;

    protected $table = 'behandelingen';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'naam',
        'beschrijving',
        'duur',
        'prijs',
    ];

    protected $casts = [
        'prijs' => 'decimal:2',
    ];

    public function producten()
    {
        return $this->belongsToMany(Product::class, 'behandeling_product', 'behandeling_id', 'product_id')
                    ->withPivot('aantal')
                    ->withTimestamps();
    }
}
