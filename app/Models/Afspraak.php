<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Afspraak extends Model
{
    use HasFactory;

    protected $table = 'Afspraak';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'KlantId',
        'MedewerkerId',
        'BehandelingId',
        'DatumTijd',
        'Status',
        'IsActief',
        'Opmerking',
        'DatumAangemaakt',
        'DatumGewijzigd',
    ];

    protected $casts = [
        'DatumTijd' => 'datetime',
        'IsActief' => 'boolean',
        'DatumAangemaakt' => 'datetime',
        'DatumGewijzigd' => 'datetime',
    ];

    public function klant()
    {
        return $this->belongsTo(Klant::class, 'KlantId', 'Id');
    }

    public function medewerker()
    {
        return $this->belongsTo(Medewerker::class, 'MedewerkerId', 'Id');
    }

    public function behandeling()
    {
        return $this->belongsTo(Behandeling::class, 'BehandelingId', 'Id');
    }
}
