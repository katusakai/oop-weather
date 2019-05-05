<?php

namespace Weather;

use Symfony\Component\HttpFoundation\Request;
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
            $api = Request::createFromGlobals()->query->get("api");
            switch ($api){
                case "weather":
                    $this->transporter = new DbRepositoryWeather();
                    break;
                case "google":
                    $this->transporter = new GoogleApi();
                    break;
                case "data":
                default:
                $this->transporter = new DbRepositoryData();
                break;
            }
        }

        return $this->transporter;
    }
}


