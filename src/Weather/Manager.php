<?php

namespace Weather;

use Weather\Api\DataProvider;
use Weather\Api\DbRepositoryData;
use Weather\Api\DbRepositoryWeather;
use Weather\Api\GoogleApi;
use Weather\Model\Weather;

class Manager
{
    /**
     * @var DataProvider
     */
    private $transporter;

    public function getTodayInfo(): Weather
    {
        return $this->getTransporter()->selectByDate(new \DateTime());
    }

    public function getWeekInfo(): array
    {
        return $this->getTransporter()->selectByRange(new \DateTime('midnight'), new \DateTime('+6 days midnight'));
    }

    private function getTransporter()
    {
        if (null === $this->transporter) {
            $this->transporter = new DbRepositoryWeather();
            $this->transporter = new GoogleApi();
//            $this->transporter = new DbRepositoryData();
        }

        return $this->transporter;
    }
}


