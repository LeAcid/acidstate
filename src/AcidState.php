<?php

namespace AcidState;

class AcidState
{
    private $transitions = [];
    private $stateIndex = 0;

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
        $this->stateIndex += 1;
        $this->state = $this->transitions[$this->stateIndex];
    }

    /**
     * Set initial state
     * 
     * @return void
     */
    private function setInitialState($state)
    {
        $this->state = $state;
    }
}