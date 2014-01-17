<?php
// bootstrap.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/module/Application/src/Application/Entity"), $isDevMode);

// database configuration parameters
$conn = array(
    'driver' => 'mysqli',
    'user' => 'battleship',
    'password' => 'pacificrim',
    'host' => 'localhost',
    'dbname' => 'battleship',
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);