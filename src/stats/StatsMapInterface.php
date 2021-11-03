<?php
namespace Emagia\Stats;

interface StatsMapInterface {
    /**
     * Retrieves the stat class associated with the $name param.
     * @return StatRange the stat class.
     * @throws \InvalidArgumentException when the stat is not found.
     */
    public function getStat(string $name) : StatRangeInterface;
}