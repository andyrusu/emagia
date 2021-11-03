<?php
namespace Emagia\Characters;
use Emagia\Stats\StatRangeInterface;
use Emagia\Stats\StatsMapInterface;

interface CharacterInterface {
    /**
     * Calculates the damage value to be dealt to the $defender. (Does not trigger skills)
     * @param CharacterInterface $defender the character that will be dealt the damage.
     * @return int the damage value
     */
    public function calculateDamage(CharacterInterface $defender) : int;

    /**
     * Shortcut to decrease the character health by the damage amount.
     * @param int $damage the damage dealt to the character.
     */
    public function decreaseHealth(int $damage) : void;

    /**
     * Retrieve the stat with the given $name.
     * @param string $name The stat
     * @param StatRangeInterface The stat object
     */
    public function getStat(string $name) : StatRangeInterface;

    /**
     * @return StatsMapInterface
     */
    public function getStatsMap() : StatsMapInterface;

    /**
     * @return array of SkillInterface classes.
     */
    public function getSkills() : array;

    /**
     * @return bool if character is dead.
     */
    public function isDead() : bool;

    /**
     * @return string The character name.
     */
    public function getName() : string;
}