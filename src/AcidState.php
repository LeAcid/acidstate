<?php

namespace AcidState;

use Carbon\Carbon;

class AcidState
{
    private $transitions = [];
    private $stateIndex = 0;
    private $history = [];

    /**
     * Create a new AcidState
     * 
     * @return AcidState\AcidState self
     */
    static public function create()
    {
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
}