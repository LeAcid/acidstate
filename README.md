# Acid State

Acid state is a simple way of managing the progression of state in an application. It provides an easy way to serialize and unserialize your state and history for storage.

### Example usage of library
```php
use AcidState\AcidState;

$price = null;
$confirmed = 'N';

// Create new AcidState and setup transitions.
$acidState = AcidState::create()
    ->setTransitions('armed', 'confirmed', 'sold');

// Loop for the retrieval of data to work through possible states.
while($acidState->getCurrentState() != 'sold') {
    switch ($acidState->getNextState()) {
        // In each case is an easy area to call into data validators before allowing
        // the state to be transitioned into the next possible state.
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

// Dump the price that was set in transitioning.
var_dump($price);
// Dump the json representation of the acidState object.
var_dump($acidState->json());
```

### Create a new AcidState with available steps
```php
$acidState = AcidState::create()
    ->setTransitions('armed', 'confirmed', 'sold');

// The state is initialized at the first transition.
// You can now call $acidState->nextState(); to move the state ahead
// a transistion level to 'confirmed'
```

### Retrieve the current state
```php
$acidState->getCurrentState();
// returns a string identifier of current state
```

### Retrieve the next possible state
```
$acidState->getNextState();
// returns a string of next state
```

### Create an AcidState based on an old state
```
$acidState = AcidState::create($json_encoded_acid_state);
```