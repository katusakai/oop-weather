<?php

namespace Weather\Api;

use Weather\Model\NullWeather;
use Weather\Model\Weather;

class GoogleApi
{
    /**
     * @return Weather
     * @throws \Exception
     */
    public function selectByDate(): Weather
    {
        $result = $this->load(new NullWeather());
        $result->setDate(new \DateTime());
        return $result;
    }

    public function selectByRange(\DateTime $from, \DateTime $to): array
    {
        $dayFrom = $from->getTimestamp() / (3600 * 24);
        $dayTo = $to->getTimestamp() / (3600 * 24);

        $result = [];

        for($i = $dayFrom; $i < $dayTo; $i++) {
            $item = $this->load(new NullWeather());
            $item->setDate(new \DateTime(date('Y-m-d')));
            $result[] = $item;
        }

        return $result;
    }

    /**
     * @param Weather $before
     * @return Weather
     * @throws \Exception
     */
    private function load(Weather $before)
    {
        $now = new Weather();
        $base = $before->getDayTemp();
        $now->setDayTemp(random_int(5 - $base, 5 + $base));

        $base = $before->getNightTemp();
        $now->setNightTemp(random_int(-5 - abs($base), -5 + abs($base)));

        $now->setSky(random_int(1, 3));

        return $now;
    }
}
