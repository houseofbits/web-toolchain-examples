<?php

namespace App\Libraries;

class ViewHelper
{
    public function dateTime(){

        $datetime = new \DateTime('now');

        return $datetime->format('Y-m-d H:i:s');
    }

}

