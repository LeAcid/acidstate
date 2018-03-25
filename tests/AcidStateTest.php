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

    /**
     * Test that state json string can recreate the acid state
     * 
     * @return void
     */
    public function testThatJsonStringCanRecreateTheAcidState()
    {
        $state_string = '
            {
                "state": "two",
                "state_index": 1,
                "transitions": ["one","two","three","four"],
                "history": [
                    {
                        "action":"init_state",
                        "state":"one",
                        "state_index":0,
                        "date":1522000776
                    },
                    {
                        "action":"next",
                        "state":"two",
                        "state_index":1,
                        "date":1522000776
                    }
                ]
            }
        ';
        $acidState = AcidState::create($state_string);

        $this->assertEquals("two", $acidState->getCurrentState());

        $acidState->rollback();

        $this->assertEquals("one", $acidState->getCurrentState());
    }

    /**
     * Test that state json string can recreate the acid state
     * from a previous acid state saved as json
     * 
     * @return void
     */
    public function testThatJsonStringCanBeSavedAndRecreated()
    {
        $acidState = AcidState::create()
            ->setTransitions('one', 'two', 'three', 'four');

        $this->assertEquals("one", $acidState->getCurrentState());

        $acidState->nextState();

        $this->assertEquals("two", $acidState->getCurrentState());

        $state_string = $acidState->json();

        $acidState2 = AcidState::create($state_string);

        $this->assertEquals("two", $acidState2->getCurrentState());

        $acidState2->rollback();

        $this->assertEquals("one", $acidState2->getCurrentState());
    }

    /**
     * Test that next state can be checked without actually moving forward
     * 
     * @return void
     */
    public function testCanGetNextStateWithoutMovingAhead()
    {
        $acidState = AcidState::create()
            ->setTransitions('one', 'two', 'three', 'four');

        $this->assertEquals("one", $acidState->getCurrentState());

        $this->assertEquals("two", $acidState->getNextState());

        $this->assertEquals("one", $acidState->getCurrentState());
    }
}