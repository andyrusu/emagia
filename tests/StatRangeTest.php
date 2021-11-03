<?php
namespace Game;
use Emagia\Stats\StatRange;
use Emagia\Characters\Character;

class StatRangeTest extends \Codeception\Test\Unit
{
    // tests
    public function testRangeInstanceAndFactory()
    {
        $stat = new StatRange(Character::STAT_HEALTH, 70, 100);
        //Test if we can instantiate with positive numbers. For other invalid params the developer will get a PHP error.
        $this->assertInstanceOf(StatRange::class, $stat);
        
        //Test the initial state of the class
        $this->assertLessThan(0, $stat->value);
        $this->assertFalse($stat->isFinalValueGenerated());

        //Test after factory
        $stat = StatRange::instantiateAndGenerateValue(Character::STAT_HEALTH, 70, 100);
        $this->assertInstanceOf(StatRange::class, $stat); //Check proper instance
        $this->assertGreaterThanOrEqual(0, $stat->value); //Check if value is set
        $this->assertTrue($stat->isFinalValueGenerated()); //Check if is reported correctly
    }

    public function testFinalValueGeneration()
    {
        $stat = new StatRange(Character::STAT_HEALTH, 70, 100);
        //Test if the generateFinalValue will generate the correct value.
        $value = $stat->generateFinalValue();
        $this->assertGreaterThanOrEqual(70, $value, "The stat value is not equal or greater then 70.");
        $this->assertLessThanOrEqual(100, $value, "The stat value is not equal or less then 100.");
        //Even if the implementation is using rand() which will guarantee that the number will be in the proper range,
        //we need to keep this test in case the way we generate the numbers change.
    }

    public function testIncreaseAndDecrease()
    {
        $stat = StatRange::instantiateAndGenerateValue(Character::STAT_HEALTH, 70, 100);
        $initialValue = $stat->value;

        //Test increase
        $stat->increaseBy(5);
        $this->assertEquals($initialValue + 5, $stat->value);

        //Test decrease
        $stat->decreaseBy(5);
        $this->assertEquals($initialValue, $stat->value);
    }

    //Testing for Exeptions.
    public function testRangeWithNegativeNums()
    {
        $this->expectException(\InvalidArgumentException::class);
        $statNegative = new StatRange(Character::STAT_HEALTH, -70, 100);
    }
    
    public function testGetInvalidAttribute()
    {
        $this->expectException(\InvalidArgumentException::class);
        $stat = new StatRange(Character::STAT_HEALTH, 70, 100);
        $value = $stat->fakeAttribute;
    }
}