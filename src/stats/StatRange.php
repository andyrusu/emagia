<?php
namespace Emagia\Stats;

/**
 * This class handels the generation of individual stat values.
 * Ex:
 * $stat = StatRange::instantiateAndGenerateValue("health", 70, 100);
 * 
 * Afte this you can handle the following properties:
 * @property string $statName The name of the stat, from the example it would be "health".
 * @property int $value The value of the stat, it will be between the start and end values set in the constructor.
 */
class StatRange implements StatRangeInterface {
    private string $name = '';
    private int $value = -1;
    private array $range = [];

    /**
     * Instantiates the class but does not set the final $value, you need to do it separately or use the factory method.
     * @param string $statName The name of the stat
     * @param int $startValue The lowest number that the final $value can be.
     * @param int $endValue The highest number that the final $value can be.
     */
    public function __construct(string $statName, int $startValue, int $endValue) {
        if ($startValue < 0 || $endValue < 0) throw new \InvalidArgumentException('$statName and $endName have to be positive numbers.');

        $this->name = $statName;
        $this->range = [$startValue, $endValue];
    }

    public function __get($name) {
        if (in_array($name, ['name', 'value'])) {
            return $this->$name;
        }

        throw new \InvalidArgumentException('Invalid attribute name.');
    }

    /**
     * Factory method that instantiates the class but also sets the final value.
     * @param string $statName The name of the stat
     * @param int $startValue The lowest number that the final $value can be.
     * @param int $endValue The highest number that the final $value can be.
     */
    public static function instantiateAndGenerateValue(string $statName, int $startValue, int $endValue) : StatRange
    {
        $statRange = new StatRange($statName, $startValue, $endValue);
        $statRange->setValue($statRange->generateFinalValue());
        return $statRange;
    }

    /**
     * Sets the $value class property.
     * @param int $value The new value, must be within the range defined.
     * @throws \InvalidArgumentException when the $value parameter is not inside the range.
     */
    public function setValue($value) : void 
    {
        if ($value < $this->range[0] || $value > $this->range[1]) {
            throw new \InvalidArgumentException('$value parameter must be between ' . $this->range[0] . ' and ' . $this->range[1] . '.');
        }

        $this->value = $value;
    }

    /**
     * Used to check if the class has the final value generated or not
     * @return bool true if the class has the final $value generated, false otherwise.
     */
    public function isFinalValueGenerated() {
        return $this->value > 0;
    }

    /**
     * Increase the stat value by the $number specified. This bypases the range, can be used for temporary buff skills.
     * @param int $number
     */
    public function increaseBy(int $number) : void {
        $this->value += $number;
    }

    /**
     * Decrease the stat value by the $number specified. This bypases the range, can be used for temporary debuff skills.
     * @param int $number
     */
    public function decreaseBy(int $number) :void {
        $this->value -= $number;
    }

    /**
     * Used to set the $value of the class.
     * @return int a number between the state range values.
     */
    public function generateFinalValue() : int {
        return rand($this->range[0], $this->range[1]);
    }
}