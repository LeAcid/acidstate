<?php

require __DIR__ . '/vendor/autoload.php';

use AcidState\AcidState;

$state = new AcidState;

echo $state->currentState();