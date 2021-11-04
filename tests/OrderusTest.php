<?php
namespace Game;
use Emagia\Stats\StatsMap;
use Emagia\Skills\Attack;
use Emagia\Characters\Orderus;

class OrderusTest extends \Codeception\Test\Unit
{
    private $orderus = null;

    protected function _before()
    {
        $this->orderus = new Orderus();
    }

    // tests
    public function testOrderusInstance()
    {
        $this->assertInstanceOf(StatsMap::class, $this->orderus->getStatsMap());
        $skills = $this->orderus->getSkills();
        $this->assertInstanceOf(Attack::class, $skills[0]);
    }
}