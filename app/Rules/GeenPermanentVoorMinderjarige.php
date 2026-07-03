<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class GeenPermanentVoorMinderjarige implements ValidationRule
{
    public function __construct(private readonly ?string $geboortedatum)
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Alleen Permanent heeft deze leeftijdscontrole nodig.
        if ($value !== 'Permanent' || blank($this->geboortedatum)) {
            return;
        }

        try {
            $geboortedatum = Carbon::parse($this->geboortedatum);
        } catch (\Throwable) {
            return;
        }

        // Jonger dan 18 jaar mag geen specialisatie Permanent krijgen.
        if ($geboortedatum->greaterThan(Carbon::now()->subYears(18))) {
            $fail('Minderjarige medewerkers mogen geen specialisatie Permanent toegewezen krijgen vanwege het werken met gevaarlijke stoffen en chemicaliën.');
        }
    }
}
