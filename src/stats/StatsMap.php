<?php
namespace Emagia\Stats;

use InvalidArgumentException;

/**
 * Class that represents the character's stats.
 * Ex:
 * $stats = new StatsMap([StatRange::instantiateAndGenerateValue("health", 70, 100)]);
 * $stats["health"] will return the value of the "health" stat.
 * $stats->getStat("health") will return the StatRange class associated with the stat.
 */
class StatsMap implements StatsMapInterface, \ArrayAccess {
    protected $attributes = [];

    /**
     * Instanciate the class with an array of stats.
     * @param array $stats an array of StatRange classes.
     */
    public function __construct(array $stats)
    {
        foreach ($stats as $stat)
        {
            if (!($stat instanceof StatRangeInterface))
                throw new InvalidArgumentException('Stat items must be of type StatRangeInterface');

            $this->attributes[$stat->name] = $stat;
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->attributes[$offset]);
    }

    public function offsetGet($offset) : int
    {
        return $this->attributes[$offset]->value;
    }

    public function offsetSet($offset, $value)
    {
        throw new StatReadOnlyException('The stat is read only, and cannot be set.');
    }

    public function offsetUnset($offset)
    {
        throw new StatReadOnlyException('The stat is read only, cannot be unset.');
    }

    /**
     * Retrieves the stat class associated with the $name param.
     * @return StatRange the stat class.
     * @throws \InvalidArgumentException when the stat is not found.
     */
    public function getStat(string $name) : StatRangeInterface
    {
        if (isset($this->attributes[$name]))
        {
            return $this->attributes[$name];
        }

        throw new \InvalidArgumentException("$name is not a valid stat.");
    }
}