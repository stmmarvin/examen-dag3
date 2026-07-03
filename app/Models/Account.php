<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $table = 'Account';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'UserId',
        'Gebruikersnaam',
        'Email',
        'Wachtwoord',
        'Rol',
        'IsActief',
        'Opmerking',
        'DatumAangemaakt',
        'DatumGewijzigd',
    ];

    protected $hidden = [
        'Wachtwoord',
    ];

    protected $casts = [
        'IsActief' => 'boolean',
        'DatumAangemaakt' => 'datetime',
        'DatumGewijzigd' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserId');
    }
}
