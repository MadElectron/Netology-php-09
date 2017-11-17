<?php

class Car
{           
    const WHEEL_COUNT = 4;

    private $wheelCount = WHEEL_COUNT;
    private $color = [255, 255, 255];
    private $speed = 0;

    private static $maxSpeed;

    public function __construct($color) 
    {   
        $this->color = $color;
    }

    public function getWheelCount()
    {   
        return $this->wheelCount;
    }

    public function getColor()
    {   
        return $this->color;
    }

    public function getSpeed()
    {   
        return $this->speed;
    }

    public function getMaxSpeed()
    {   
        return self::$maxSpeed;
    }


    public function paint($r, $g, $b)
    {
        if (in_array($r, range(0,255)) or 
            in_array($g, range(0,255)) or
            in_array($b, range(0,255))) {
            echo 'Все компоненты цвета должны быть в диапазоне от 0 до 255';
        }
        else {
            $this->color = $color;
        }
    }

    public function takeOffWheels($wheelCount)
    {
        if (!$this->wheelCount) {
            echo 'На машине не установлены колёса';
        }
        elseif ($wheelCount > WHEEL_COUNT) {
            echo 'У машины не бывает столько колёс';
        }
        elseif ($wheelCount > $this->wheelCount) {
            echo 'Вы пытаетесь снять колёс больше, чем установлено на машине. Установлено: '.$this->wheelCount;
        }
        else {
            $this->wheelCount -= $wheelCount;
        }
    }

    public function takeOnWheels($wheelCount)
    {
        if ($this->wheelCount == WHEEL_COUNT) {
            echo 'На машине установлены все колёса';                
        }
        elseif ($wheelCount + $this->wheelCount > WHEEL_COUNT) {
            echo 'Вы пытаетесь установить колёс больше, чем может быть в машине. Установлено: '.$this->wheelCount;
        }
        else {
            $this->wheelCount += $wheelCount;
        }
    }    

    /*
    * Linear increase Car's speed depending on pressing throttle time
    */
    public function throttle($time)
    {
        if ($this->speed < self::$maxSpeed) {
            $this->speed += $time;
        }   
    }

    /*
    * Linear decrease Car's speed depending on pressing break time
    */
    public function break($time) 
    {
        if ($this->speed) {
            $this->speed = 3*$time; //We break faster than throttle
        }
    }

    public static function setMaxSpeed($speed) 
    {
        self::$maxSpeed = $speed;
    }
}


class TvSet
{   
    private $serialNumber;
    private $channels = ['Первый', 'Россия'];
    private $powerOn = false;
    private $volume = 0;
    private $currentChannel = 0;

    public function __construct($number)
    {
        $this->serialNumber = $number;
    }

    public function getChannels()
    {
        return $this->channels;
    }

    public function getPowerOn()
    {
        return $this->powerOn;
    }

    public function getVolume()
    {
        return $this->powerOn ? $this->volume : 0;
    }

    public function getCurrentChannel()
    {
        return $this->powerOn ? $this->currentChannel : null;
    }


    public function clickPower() 
    {
        $this->powerOn = !$this->powerOn;
    }

    public function clickTune($channels)
    {
        if ($powerOn) {
            $this->channels = array_merge($this->channels, $channels);
        }
    }

    public function clickVolumePlus($time)
    {
        if ($powerOn) {
            $newVolume = $this->volume + $time;
            $this->volume = ($newVolume < 100) ? $newVolume : 100;
        }
    }

    public function clickVolumeMinus($time)
    {
        if ($powerOn) {
            $newVolume = $this->volume - $time;
            $this->volume = ($newVolume > 0) ? $newVolume : 0;
        }
    }

    public function clickChannelPlus()
    {
        if ($powerOn) {
            if ($this->currentChannel == count($this->channels) - 1) {
                $this->currentChannel = 0;
            }
            else {
                $this->currentChannel += 1;    
            }
        }
    }

    public function clickChannelMinus()
    {
        if ($powerOn) {
            if ($this->currentChannel == 0) {
                $this->currentChannel = count($this->channels) - 1;
            }
            else {
                $this->currentChannel -= 1;    
            }
        }
    }
}


