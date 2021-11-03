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
        $statsMap = new StatsMap([
            StatRange::instantiateAndGenerateValue(Character::STAT_HEALTH, 60, 90),
            StatRange::instantiateAndGenerateValue(Character::STAT_STRENGTH, 60, 90),
            StatRange::instantiateAndGenerateValue(Character::STAT_DEFENCE, 40, 60),
            StatRange::instantiateAndGenerateValue(Character::STAT_SPEED, 40, 60),
            StatRange::instantiateAndGenerateValue(Character::STAT_LUCK, 25, 40),
        ]);

        $skills = [
            new Attack(),
            new Defend($statsMap[Character::STAT_LUCK]),
        ];

        parent::__construct("Wild Beast", $statsMap, $skills);
    }
}