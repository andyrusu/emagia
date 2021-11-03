<?php
namespace Game;
use Emagia\Stats\StatsMap;
use Emagia\Stats\StatRange;
use Emagia\Characters\Character;
use Emagia\Skills\Attack;
use Emagia\Skills\Defend;
use Emagia\Skills\RapidStrike;
use Emagia\Skills\MagickShield;

class CharacterTest extends \Codeception\Test\Unit
{
    private $statsMap = null;
    private $skills = null;

    protected function _before()
    {
        $this->statsMap = new StatsMap([
            StatRange::instantiateAndGenerateValue(Character::STAT_HEALTH, 70, 100),
            StatRange::instantiateAndGenerateValue(Character::STAT_STRENGTH, 70, 80),
            StatRange::instantiateAndGenerateValue(Character::STAT_DEFENCE, 45, 55),
            StatRange::instantiateAndGenerateValue(Character::STAT_SPEED, 40, 50),
            StatRange::instantiateAndGenerateValue(Character::STAT_LUCK, 70, 100),
        ]);

        $this->skills = [
            new Attack(),
            new Defend($this->statsMap[Character::STAT_LUCK]),
            new RapidStrike(),
            new MagickShield(),
        ];
    }

    // tests
    public function testCharacterInstanceException()
    {
        $this->expectException(\InvalidArgumentException::class);
        $char = new Character("test", $this->statsMap, []);
    }

    public function testCharacterStat()
    {
        $char = new Character("test", $this->statsMap, $this->skills);

        //Test getters
        $this->assertEquals($this->statsMap, $char->getStatsMap());
        $this->assertEquals($this->statsMap->getStat(Character::STAT_HEALTH), $char->getStat(Character::STAT_HEALTH));
        $this->assertEquals($this->statsMap[Character::STAT_HEALTH], $char->getStat(Character::STAT_HEALTH)->value);

        //Test health
        $this->assertFalse($char->isDead());
        $char->decreaseHealth($this->statsMap[Character::STAT_HEALTH]);
        $this->assertEquals(0, $char->getStat(Character::STAT_HEALTH)->value);
        $this->assertTrue($char->isDead());
    }

    public function testCharacterDamage()
    {
        $char1 = new Character("char1", $this->statsMap, $this->skills);
        $char2 = new Character("char2", $this->statsMap, $this->skills);

        $this->assertEquals($this->statsMap[Character::STAT_STRENGTH] - $this->statsMap[Character::STAT_DEFENCE], $char1->calculateDamage($char2));
    }
}