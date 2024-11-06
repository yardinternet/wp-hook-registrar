<?php

declare(strict_types=1);

it('can retrieve a random inspirational quote', function () {
    $this->artisan('hooks')
        ->expectsOutput('For every Sage there is an Acorn.')
        ->assertExitCode(0);
});
