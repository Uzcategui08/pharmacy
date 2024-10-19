<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('apartados:cancelar-apartado', function () {
    $this->call('apartados:cancelar-apartado');
})->purpose('Cancela los apartados apartado')->everyMinute();
