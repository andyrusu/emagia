<?php
namespace Emagia\Skills;

class Defend extends Skill 
{
    public function __construct($chance) 
    {
        parent::__construct('evade', $chance);
    }

    /**
     * If this skill is triggered the attack is missed, so no damage is taken.
     */
    public function defenceDamageModifier(float $damage) : float
    {
        return 0;
    }

    /**
     * Does not trigger when attacking so we are bypassing the normal flow.
     */
    public function onAttack(float $damage) : float
    {
        return $damage;
    }
}