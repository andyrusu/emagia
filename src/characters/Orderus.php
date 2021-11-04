<?php
namespace Emagia\Characters;
use Emagia\Stats\StatsMap;
use Emagia\Stats\StatRange;
use Emagia\Characters\Character;
use Emagia\Skills\Attack;
use Emagia\Skills\Defend;
use Emagia\Skills\RapidStrike;
use Emagia\Skills\MagickShield;

class Orderus extends Character 
{
    public function __construct()
    {
        //Define the stats
        $statsMap = new StatsMap([
            StatRange::instantiateAndGenerateValue(Character::STAT_HEALTH, 70, 100),
            StatRange::instantiateAndGenerateValue(Character::STAT_STRENGTH, 70, 80),
            StatRange::instantiateAndGenerateValue(Character::STAT_DEFENCE, 45, 55),
            StatRange::instantiateAndGenerateValue(Character::STAT_SPEED, 40, 50),
            StatRange::instantiateAndGenerateValue(Character::STAT_LUCK, 10, 30),
        ]);

        parent::__construct("Orderus", $statsMap);

        //Register the skills
        $this->registerSkills();
    }

    protected function registerSkills()
    {
        $this->registerSkill(new Attack());
        $this->registerSkill(new Defend($this->getStat(Character::STAT_LUCK)->value));
        $this->registerSkill(new RapidStrike());
        $this->registerSkill(new MagickShield());
    }
}