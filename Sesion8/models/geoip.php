<?php

require 'libs/Database.php';

class GeoIP {

    public static function getList($ip) {
        $database = new Database();
        $sql = "SELECT L2.city_name, L2.country_name, B1.network, B1.latitude, B1.longitude, B1.postal_code
              FROM (SELECT DISTINCT network, latitude, longitude, postal_code, geoname_id FROM citiesbloqs WHERE network = '$ip') AS B1 
              JOIN (SELECT city_name, country_name, geoname_id FROM citieslocations) AS L2
                ON B1.geoname_id = L2.geoname_id";
        return $result = $database->doQuery($sql);
    }

}
