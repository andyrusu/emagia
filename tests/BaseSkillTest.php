<?php
namespace Game;
use Emagia\Skills\Attack;
use Emagia\Skills\Defend;
use Emagia\Skills\Skill;

class BaseSkillTest extends \Codeception\Test\Unit
{
    // tests
    public function testAttackSkill()
    {
        $attackSkill = new Attack();
        //The attack skill always triggers, but it just applyes damage.

        $this->assertTrue($attackSkill->shouldTrigger()); //Will always return true
        $this->assertEquals($attackSkill->onAttack(10), 10); //It will return same number (as in damage x 1)
        $this->assertEquals($attackSkill->onDefence(10), 10); //It will return same number because it does not trigger on defence
    }

    public function testDefenceSkill()
    {
        $attackSkill = new Defend(10);

        $this->assertEquals($attackSkill->onAttack(10), 10); //It will not trigger on attack, so value is the same
        //There is a chance to trigger on defence, but it can't be tested properly.
    }

    public function testChanceExeption()
    {
        $this->expectException(\InvalidArgumentException::class);
        $skill = new Skill('test', -1);
    }
}