<?php

namespace AcidState;

use Carbon\Carbon;

class AcidState
{
    private $transitions = [];
    private $stateIndex = 0;
    private $history = [];
    private $state;

    /**
     * Create a new AcidState
     * 
     * @return AcidState\AcidState self
     */
    static public function create($state_string = false)
    {
        if ($state_string) {
            $acidState = new self;

            return $acidState->initialize($state_string);
        }
        return new self;
    }

    /**
     * Add possible state transitions
     * cannot be redefined.
     * 
     * @return AcidState\AcidState $this
     */
    public function setTransitions(...$transitions)
    {
        if (count($this->transitions) == 0) {

            $this->setInitialState($transitions[$this->stateIndex]);

            $this->transitions = $transitions;
        }

        return $this;
    }

    /**
     * Return a list of transitions
     * 
     * @return array $this->transistions
     */
    public function getTransitions()
    {
        return $this->transitions;
    }

    /**
     * Return current state
     * 
     * @return string $this->state
     */
    public function getCurrentState()
    {
        return $this->state;
    }

    /**
     * Advance state index and state one level up
     * 
     * @return void
     */
    public function nextState()
    {
        if (($this->stateIndex + 1) < (count($this->transitions))) {
            $this->stateIndex += 1;
            $this->state = $this->transitions[$this->stateIndex];
            $this->logAction('next');
        }
    }

    /**
     * Rollback state one level based on history
     * 
     * @return void
     */
    public function rollback()
    {
        array_pop($this->history);
        $this->stateIndex = $this->history[count($this->history) - 1]['state_index'];
        $this->state      = $this->history[count($this->history) - 1]['state'];
    }

    /**
     * Set initial state
     * 
     * @return void
     */
    private function setInitialState($state)
    {
        $this->state = $state;

        $this->logAction('init_state');
    }

    private function logAction(string $action)
    {
        array_push($this->history, [
            'action'        => $action,
            'state'         => $this->state,
            'state_index'   => $this->stateIndex,
            'date'          => Carbon::now()->timestamp
        ]);
    }

    public function json()
    {
        return json_encode([
            'state'         => $this->state,
            'state_index'   => $this->stateIndex,
            'transitions'   => $this->transitions,
            'history'       => $this->history
        ]);
    }

    private function initialize(string $state_string)
    {
        $state = json_decode($state_string, true);

        $this->transitions  = $state['transitions'];
        $this->history      = $state['history'];
        $this->state        = $state['state'];
        $this->state_index  = $state['state_index'];

        return $this;
    }
}