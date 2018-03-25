<?php

namespace AcidState;

class AcidState
{
    private $transitions = [];

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
     * cannot be redefined on the fly.
     * 
     * @return AcidState\AcidState $this
     */
    public function setTransitions(...$transitions)
    {
        if (count($this->transitions) == 0) {

            $this->setInitialState($transitions[0]);

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
     * Set initial state
     * 
     * @return void
     */
    private function setInitialState($state)
    {
        $this->state = $state;
    }
}