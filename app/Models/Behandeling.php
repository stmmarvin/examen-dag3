<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Behandeling Model representeert een salon behandeling (knippen, kleuren, permanent, etc.)
class Behandeling extends Model
{
    use HasFactory;

    // Database configuratie.
    protected $table = 'behandeling';
    protected $primaryKey = 'id';
    public $timestamps = false;

    // Velden die mass-assignable zijn (veilig via create/update).
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

    // Type casting voor automatische conversie van database waarden.
    protected $casts = [
        'prijs' => 'decimal:2',
        'is_actief' => 'boolean',
        'datum_aangemaakt' => 'datetime',
        'datum_gewijzigd' => 'datetime',
    ];

    // Many-to-Many relatie met Product via behandeling_product pivot tabel.
    // Een behandeling gebruikt meerdere producten, een product kan bij meerdere behandelingen horen.
    public function producten()
    {
        return $this->belongsToMany(Product::class, 'behandeling_product', 'behandeling_id', 'product_id')
            ->withPivot('aantal'); // Voeg 'aantal' kolom toe uit pivot tabel.
    }
}
