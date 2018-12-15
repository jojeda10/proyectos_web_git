<?php
        class Database {

            public $database;

            function __construct() {
                //Creamos instancia de mysqli (hay introducir usuario y contrasena correctos) Ups, me he dejado aqui mis credenciales...
                $this->database = new mysqli('localhost', 'root', 'Alemania10!', 'entregable6');
            }

            public function doQuery($sql) {
                return $result = $this->database->query($sql);
            }

        }
        ?>

