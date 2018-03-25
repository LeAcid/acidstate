<?php

require __DIR__ . '/vendor/autoload.php';

use AcidState\AcidState;

$price = null;
$confirmed = 'N';

$acidState = AcidState::create()
    ->setTransitions('armed', 'confirmed', 'sold');

while($acidState->getCurrentState() != 'sold') {
    switch ($acidState->getNextState()) {
        case 'confirmed':
            if ($confirmed == 'Y') {
                $acidState->nextState();
            } else {
                echo "You must confirm your intent sell product\n";
                $confirmed = readline("Enter 'Y' to confirm: ");
            }
        break;
        case 'sold':
            if ($price) {
                $acidState->nextState();
            } else {
                echo "You must set price to sell vehicle\n";
                $price = readline("Enter a price: $");
            }
        break;
    }
}

var_dump($price);
var_dump($acidState->json());