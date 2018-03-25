<?php

namespace Tests;

use Tests\BaseCase;
use AcidState\AcidState;

class AcidStateTest extends BaseCase
{
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

    /**
     * Test can rollback state one level
     * 
     * @return void
     */
    public function testCanRollbackStateOneLevel()
    {
        $acidState = AcidState::create()
            ->setTransitions('one', 'two', 'three', 'four');
        
        $acidState->nextState();

        $this->assertEquals('two', $acidState->getCurrentState());

        $acidState->rollback();

        $this->assertEquals('one', $acidState->getCurrentState());
    }

    /**
     * Test that state stops at the end of transitions
     * 
     * @return void
     */
    public function testThatStopsAtTheEndOfTransitions()
    {
        $acidState = AcidState::create()
            ->setTransitions('one', 'two', 'three', 'four');
        
        $acidState->nextState();
        $acidState->nextState();
        $acidState->nextState();
        $acidState->nextState();
        $acidState->nextState();

        $this->assertEquals('four', $acidState->getCurrentState());
    }
}