<?php
namespace Game;
use Emagia\Stats\StatsMap;
use Emagia\Stats\StatRange;
use Emagia\Stats\StatReadOnlyException;
use Emagia\Characters\Character;

class StatMapTest extends \Codeception\Test\Unit
{
    // tests
    public function testInstanceAndAccessToValues()
    {
        $stat = StatRange::instantiateAndGenerateValue(Character::STAT_HEALTH, 70, 100);
        $stats = new StatsMap([$stat,]);

        //Test if we can access as an array
        $this->assertEquals($stat->value, $stats[$stat->name]);
        //Test if same class
        $this->assertSame($stat, $stats->getStat($stat->name));
        //Test if it's the correct value.
        $this->assertEquals($stat->value, $stats->getStat($stat->name)->value);
    }

    public function testReadOnlyExceptionsOnSet()
    {
        $stats = new StatsMap([
            StatRange::instantiateAndGenerateValue(Character::STAT_HEALTH, 70, 100),
        ]);

        $this->expectException(StatReadOnlyException::class);
        $stats[Character::STAT_HEALTH] = null;
    }

    public function testReadOnlyExceptionsOnUnset()
    {
        $stats = new StatsMap([
            StatRange::instantiateAndGenerateValue(Character::STAT_HEALTH, 70, 100),
        ]);

        $this->expectException(StatReadOnlyException::class);
        unset($stats[Character::STAT_HEALTH]);
    }
}