<?php
namespace Emagia\Stats;

interface StatRangeInterface {
    /**
     * Factory method that instantiates the class but also sets the final value.
     * @param string $statName The name of the stat
     * @param int $startValue The lowest number that the final $value can be.
     * @param int $endValue The highest number that the final $value can be.
     */
    public static function instantiateAndGenerateValue(string $statName, int $startValue, int $endValue) : StatRange;

    /**
     * Sets the $value class property.
     * @param int $value The new value, must be within the range defined.
     * @throws \InvalidArgumentException when the $value parameter is not inside the range.
     */
    public function setValue($value) : void;

    /**
     * Used to check if the class has the final value generated or not
     * @return bool true if the class has the final $value generated, false otherwise.
     */
    public function isFinalValueGenerated();

    /**
     * Increase the stat value by the $number specified. This bypases the range, can be used for temporary buff skills.
     * @param int $number
     */
    public function increaseBy(int $number) : void;

    /**
     * Decrease the stat value by the $number specified. This bypases the range, can be used for temporary debuff skills.
     * @param int $number
     */
    public function decreaseBy(int $number) :void;

    /**
     * Used to set the $value of the class.
     * @return int a number between the state range values.
     */
    public function generateFinalValue() : int;
}