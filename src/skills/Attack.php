<?php
namespace Emagia\Skills;

class Attack extends Skill 
{
    public function __construct() 
    {
        parent::__construct('attack', 100);
    }

    /**
     * Bypass normal flow, as this is the normal attack.
     */
    public function onAttack(float $damage) : float
    {
        return $damage;
    }

    /**
     * Bypass normal flow, as this is an attack skill.
     */
    public function onDefence(float $damage) : float
    {
        return $damage;
    }
}