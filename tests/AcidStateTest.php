<?php

namespace Tests;

use Tests\BaseCase;
use AcidState\AcidState;

class AcidStateTest extends BaseCase
{
    public function testTests()
    {
        $this->assertTrue(true);
    }

    /**
     * Test dynamic register state progression
     * 
     * @return void
     */
    public function testDynamicRegisterStateProgression()
    {
        $acidState = AcidState::create()
            ->setTransitions('one', 'two', 'three', 'four');

        $this->assertEquals(
            ['one', 'two', 'three', 'four'],
            $acidState->getTransitions()
        );
    }

    public function testCanAdvanceToNextState()
    {
        $acidState = AcidState::create()
            ->setTransitions('one', 'two', 'three', 'four');

        $acidState->nextState();

        $this->assertEquals('two', $acidState->getCurrentState());

        $acidState->nextState();

        $this->assertEquals('three', $acidState->getCurrentState());
    }

    /**
     * Test can receive current state
     * 
     * @return void
     */
    public function testCanReceiveCurrentState()
    {
        $acidState = AcidState::create()
            ->setTransitions('armed', 'price_requested', 'price_agreed', 'sold');

        $this->assertEquals('armed', $acidState->getCurrentState());
    }
}