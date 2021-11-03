<?php
namespace Emagia\Characters;
use Emagia\Stats\StatRangeInterface;
use Emagia\Skills\SkillInterface;
use Emagia\Stats\StatsMapInterface;

class Character implements CharacterInterface {
    const STAT_HEALTH   = 'health';
    const STAT_STRENGTH = 'strength';
    const STAT_DEFENCE  = 'defence';
    const STAT_SPEED    = 'speed';
    const STAT_LUCK     = 'luck';

    private $name = '';
    private $statsMap = null;
    private $skills = null;

    public function __construct(string $name, StatsMapInterface $statsMap, array $skills) 
    {
        $this->name = $name;
        $this->statsMap = $statsMap;
        $this->setSkills($skills);
    }

    protected function setSkills(array $skills)
    {
        //Make sure that the $skills array is valid.
        if (empty($skills))
            throw new \InvalidArgumentException('$skills param has to be an array of SkillInterface instances');

        foreach ($skills as $skill) 
        {
            if (!($skill instanceof SkillInterface))
            {
                throw new \InvalidArgumentException('$skills param has to be an array of SkillInterface instances');
            }
        }

        $this->skills = $skills;
    }

    public function calculateDamage(CharacterInterface $defender) : int 
    {
        return $this->statsMap[self::STAT_STRENGTH] - $defender->getStat(self::STAT_DEFENCE)->value;
    }

    public function decreaseHealth(int $damage) : void 
    {
        $this->statsMap
            ->getStat(self::STAT_HEALTH)
            ->decreaseBy($damage);
    }

    public function getStat(string $name) : StatRangeInterface 
    {
        return $this->statsMap->getStat($name);
    }

    public function getStatsMap() : StatsMapInterface
    {
        return $this->statsMap;
    }

    public function getSkills() : array
    {
        return $this->skills;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function isDead() : bool
    {
        return $this->statsMap[self::STAT_HEALTH] <= 0;
    }
}