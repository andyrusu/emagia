<?php
namespace Game;
use Emagia\Stats\StatsMap;
use Emagia\Characters\WildBeast;
use Emagia\Skills\Attack;
use Emagia\Skills\Defend;

class WildBeastTest extends \Codeception\Test\Unit
{
    private $wildBeast = null;

    protected function _before()
    {
        $this->wildBeast = new WildBeast();
    }

    // tests
    public function testWildBeastInstance()
    {
        $this->assertInstanceOf(StatsMap::class, $this->wildBeast->getStatsMap());
        $skills = $this->wildBeast->getSkills();
        $this->assertInstanceOf(Attack::class, $skills[0]);
    }
}