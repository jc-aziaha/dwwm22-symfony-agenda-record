<?php
namespace App\Trait;

trait TimeZoneTrait {

    public function changeTimeZone(string $timeZoneId): void {
        date_default_timezone_set($timeZoneId);
    }
}
