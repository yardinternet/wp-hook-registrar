<?php

declare(strict_types=1);

use Yard\Hooks\Facades\Hooks;

it('can retrieve a random inspirational quote', function () {
    $quote = Hooks::getQuote();

    expect($quote)->tobe('For every Sage there is an Acorn.');
});
