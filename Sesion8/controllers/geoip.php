<?php

require 'models/geoip.php';
require 'libs/IPv4.php';


class IP_controller {

    public function query($ip) {

        $geoip = new GeoIP();
        return $geoip->getList($ip);
    }

    public function getNetwork($ip) {
        $IPv4 = new Net_IPv4();
        $IPv4->ip = $ip;
        $IPv4->netmask = "255.255.255.0";

        $error = $IPv4->calculate();

        if (!is_object($error)) {
            $network = $IPv4->network . "/" . $IPv4->bitmask;
        }
        return $network;
    }

}
