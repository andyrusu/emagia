<?php
namespace Game;
use Emagia\Skills\RapidStrike;

class RapidStrikeTest extends \Codeception\Test\Unit
{
    // tests
    public function testSomeFeature()
    {
        $rsSkill = new RapidStrike();

        //Test if the attack modifier is correct
        $this->assertEquals(10 * 2, $rsSkill->attackDamageModifier(10));
        //Test if the defence modifier is not triggered
        $this->assertEquals(10, $rsSkill->onDefence(10));
    }
}