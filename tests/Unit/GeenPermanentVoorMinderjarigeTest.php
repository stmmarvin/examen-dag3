<?php

namespace Tests\Unit;

use App\Rules\GeenPermanentVoorMinderjarige;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class GeenPermanentVoorMinderjarigeTest extends TestCase
{
    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public function test_minderjarige_medewerker_mag_geen_permanent_krijgen(): void
    {
        Carbon::setTestNow('2026-07-03');
        $messages = [];

        (new GeenPermanentVoorMinderjarige('2010-01-15'))->validate('specialisatie', 'Permanent', function (string $message) use (&$messages): void {
            $messages[] = $message;
        });

        $this->assertSame([
            'Minderjarige medewerkers mogen geen specialisatie Permanent toegewezen krijgen vanwege het werken met gevaarlijke stoffen en chemicaliën.',
        ], $messages);
    }

    public function test_meerderjarige_medewerker_mag_permanent_krijgen(): void
    {
        Carbon::setTestNow('2026-07-03');
        $messages = [];

        (new GeenPermanentVoorMinderjarige('1999-12-04'))->validate('specialisatie', 'Permanent', function (string $message) use (&$messages): void {
            $messages[] = $message;
        });

        $this->assertSame([], $messages);
    }
}
