        <?php
        class Database {
            public $database;
            function __construct() {
                //Creamos instancia de mysqli (hay introducir usuario y contrasena correctos)
                $this->database = new mysqli('localhost', 'root', 'Alemania10!', 'entregable6');
            }

            public function doQuery($sql) {
                return $result = $this->database->query($sql);
            }
        }

        class GeoIP {

            public static function getList($ip) {
                $database = new Database();
                $sql = "SELECT L2.city_name, L2.country_name, B1.latitude, B1.longitude, B1.postal_code
              FROM (SELECT DISTINCT latitude, longitude, postal_code, geoname_id FROM citiesbloqs WHERE network = '$ip') AS B1 
              JOIN (SELECT city_name, country_name, geoname_id FROM citieslocations) AS L2
                ON B1.geoname_id = L2.geoname_id";
                $result = $database->doQuery($sql);
                while ($city = $result->fetch_assoc()) {
                    echo $city['country_name'];
                    echo " - ";
                    echo $city['city_name'];
                    echo " - ";
                    echo $city['latitude'];
                    echo " - ";
                    echo $city['longitude'];
                    echo " - ";
                    echo $city['postal_code'];
                }
            }
        }

        GeoIP::getList("37.231.50.0/24");
        ?>
    </body>

