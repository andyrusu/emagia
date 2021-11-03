<?php
namespace Emagia\Skills;

class Skill implements SkillInterface {
    private string $name = '';
    private int $chance = 0;

    /**
     * @param string $name The name of the skill
     * @param int $chance The chance that the skill is triggered (eg. 10 if 10% chance).
     */
    public function __construct(string $name, int $chance)
    {
        $this->name = $name;
        $this->setChance($chance);
    }

    /**
     * @return string Retrieve the name of the Skill.
     */
    public function getName() : string 
    {
        return $this->name;
    }

    /**
     * @return bool Whether the Skill should triggered.
     */
    public function shouldTrigger() : bool 
    {
        return (rand(0, 99) < $this->chance);
    }

    /**
     * This value will be used to in shouldTrigger method to determine whether the Skill is triggered.
     * @param int $chance The chance of the Skill to be triggered.
     */
    public function setChance(int $chance) : void
    {
        if ($chance < 0 || $chance > 100)
            throw new \InvalidArgumentException('$chance has to be between 0 and 100');

        $this->chance = $chance;
    }

    /**
     * Calculate the damage modifier when attacking (if the Skill is triggered), the default is no change to the damage value.
     * @param float $damage The damage when attacking, that needs to be modified if the skill is triggered.
     * @return float The damage modified if the skill is triggered
     */
    public function attackDamageModifier(float $damage) : float
    {
        return $damage;
    }

    /**
     * Calculate the damage modifier when defending (if the Skill is triggered), the default is no change to the damage value.
     * @param float $damage The damage when defending, that needs to be modified if the skill is triggered.
     * @return float The damage modified if the skill is triggered
     */
    public function defenceDamageModifier(float $damage) : float
    {
        return $damage;
    }

    /**
     * Called when attacking, it will check if the skill should trigger, if yes it will run the modifier and return the new damage value.
     * @param float $damage The damage to be modified if skill is triggered
     * @return float The new damage value.
     */
    public function onAttack(float $damage) : float
    {
        if ($this->shouldTrigger())
            return $this->attackDamageModifier($damage);

        return $damage;
    }

    /**
     * Called when defending, it will check if the skill should trigger, if yes it will run the modifier and return the new damage value.
     * @param float $damage The damage to be modified if skill is triggered
     * @return float The new damage value.
     */
    public function onDefence(float $damage) : float
    {
        if ($this->shouldTrigger())
            return $this->defenceDamageModifier($damage);

        return $damage;
    }
}