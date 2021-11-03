<?php
namespace Emagia\Skills;

class RapidStrike extends Skill 
{
    public function __construct() 
    {
        parent::__construct('Rapid Strike', 10);
    }

    public function attackDamageModifier(float $damage): float
    {
        return $damage * 2;
    }

    /**
     * Bypass normal flow, as this is an attack skill.
     */
    public function onDefence(float $damage) : float
    {
        return $damage;
    }
}