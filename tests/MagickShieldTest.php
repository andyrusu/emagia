<?php
namespace Game;
use Emagia\Skills\MagickShield;

class MagickShieldTest extends \Codeception\Test\Unit
{
    // tests
    public function testSomeFeature()
    {
        $rsSkill = new MagickShield();

        //Test if the attack modifier is correct
        $this->assertEquals(10 / 2, $rsSkill->defenceDamageModifier(10));
        //Test if the defence modifier is not triggered
        $this->assertEquals(10, $rsSkill->onAttack(10));
    }
}