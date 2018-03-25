<?php

namespace AcidState;

class AcidState
{
    private $state;

    public function __construct()
    {
        $this->state = "TEST";
    }

    public function currentState()
    {
        return $this->state;
    }
}