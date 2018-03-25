<?php

require __DIR__ . '/vendor/autoload.php';

use AcidState\AcidState;

$acidState = AcidState::create()
    ->setTransitions('one', 'two', 'three', 'four');

$acidState->nextState();

$acidState->nextState();

$acidState->rollback();