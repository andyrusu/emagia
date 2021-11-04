<?php
namespace Emagia\Characters;
use Emagia\Stats\StatsMap;
use Emagia\Stats\StatRange;
use Emagia\Characters\Character;
use Emagia\Skills\Attack;
use Emagia\Skills\Defend;

class WildBeast extends Character 
{
    public function __construct()
    {
        //Define the stats
        $statsMap = new StatsMap([
            StatRange::instantiateAndGenerateValue(Character::STAT_HEALTH, 60, 90),
            StatRange::instantiateAndGenerateValue(Character::STAT_STRENGTH, 60, 90),
            StatRange::instantiateAndGenerateValue(Character::STAT_DEFENCE, 40, 60),
            StatRange::instantiateAndGenerateValue(Character::STAT_SPEED, 40, 60),
            StatRange::instantiateAndGenerateValue(Character::STAT_LUCK, 25, 40),
        ]);

        parent::__construct("Wild Beast", $statsMap);

        //Register the skills.
        $this->registerSkills();
    }

    protected function registerSkills()
    {
        $this->registerSkill(new Attack());
        $this->registerSkill(new Defend($this->getStat(Character::STAT_LUCK)->value));
    }
}