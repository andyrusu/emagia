<?php
namespace Emagia\Skills;

interface SkillInterface 
{
    /**
     * @return string Retrieve the name of the Skill.
     */
    public function getName() : string;

    /**
     * This value will be used to in shouldTrigger method to determine whether the Skill is triggered.
     * @param int $chance The chance of the Skill to be triggered.
     */
    public function setChance(int $chance) : void; 

    /**
     * @return bool Whether the Skill should triggered.
     */
    public function shouldTrigger() : bool;

    /**
     * Calculate the damage modifier when attacking (if the Skill is triggered), the default is no change to the damage value.
     * @param float $damage The damage when attacking, that needs to be modified if the skill is triggered.
     * @return float The damage modified if the skill is triggered
     */
    public function attackDamageModifier(float $damage) : float;

    /**
     * Calculate the damage modifier when defending (if the Skill is triggered), the default is no change to the damage value.
     * @param float $damage The damage when defending, that needs to be modified if the skill is triggered.
     * @return float The damage modified if the skill is triggered
     */
    public function defenceDamageModifier(float $damage) : float;

    /**
     * Called when attacking, it will check if the skill should trigger, if yes it will run the modifier and return the new damage value.
     * @param float $damage The damage to be modified if skill is triggered
     * @return float The new damage value.
     */
    public function onAttack(float $damage) : float;

    /**
     * Called when defending, it will check if the skill should trigger, if yes it will run the modifier and return the new damage value.
     * @param float $damage The damage to be modified if skill is triggered
     * @return float The new damage value.
     */
    public function onDefence(float $damage) : float;
}