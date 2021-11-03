<?php
namespace Emagia\Skills;

class MagickShield extends Skill 
{
    public function __construct() 
    {
        parent::__construct('Magick Shield', 20);
    }

    public function defenceDamageModifier(float $damage): float
    {
        return $damage / 2;
    }

    /**
     * Bypass normal flow, as this is an defence skill.
     */
    public function onAttack(float $damage) : float
    {
        return $damage;
    }
}