<?php
namespace Game;
use Emagia\Stats\StatsMap;
use Emagia\Skills\Attack;
use Emagia\Skills\Defend;
use Emagia\Skills\RapidStrike;
use Emagia\Skills\MagickShield;
use Emagia\Characters\Orderus;

class OrderusTest extends \Codeception\Test\Unit
{
    private $orderus = null;

    protected function _before()
    {
        $this->orderus = new Orderus();

        $this->skills = [
            new Attack(),
            new Defend($this->orderus->getStat(Orderus::STAT_LUCK)->value),
            new RapidStrike(),
            new MagickShield(),
        ];
    }

    // tests
    public function testOrderusInstance()
    {
        $this->assertInstanceOf(StatsMap::class, $this->orderus->getStatsMap());
        $this->assertEquals($this->orderus->getSkills(), $this->skills);
    }
}