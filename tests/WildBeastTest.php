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

        $this->skills = [
            new Attack(),
            new Defend($this->wildBeast->getStat(WildBeast::STAT_LUCK)->value)
        ];
    }

    // tests
    public function testWildBeastInstance()
    {
        $this->assertInstanceOf(StatsMap::class, $this->wildBeast->getStatsMap());
        $this->assertEquals($this->wildBeast->getSkills(), $this->skills);
    }
}