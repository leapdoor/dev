<?php

// This is the database connection configuration.
return array(
    'connectionString' => 'sqlite:' . dirname(__FILE__) . '/../data/testdrive.db',
    // uncomment the following lines to use a MySQL database

//'connectionString' => 'mysql:host=192.168.1.14;dbname=srlc',
//'connectionString' => 'mysql:host=192.168.43.109;dbname=srlc',
    'connectionString' => 'mysql:host=localhost:3307;dbname=srlc',
    'emulatePrepare' => true,
    'username' => 'root',
//	'password' => 'managerinfo1',
    'password' => '',
//    'password' => 'BattelShip',
    'charset' => 'utf8',

);