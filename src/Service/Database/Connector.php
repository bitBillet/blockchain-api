<?php

declare(strict_types=1);

namespace App\Service\Database;


use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

/**
 * Class Connector
 */
class Connector
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    private static $connection = null;

    public const PARAMS = [
        'dbname'   => 'blockchain',
        'user'     => 'slim',
        'password' => 'slim',
        'host'     => 'blockchain-mysql',
        'driver'   => 'pdo_mysql',
        'port'     => 3306,
        'charset'  => 'utf8'
    ];

    /**
     * Получить подключение к БД используя конфигурацию Битрикс
     *
     * @return \Doctrine\DBAL\Connection
     * @throws \Doctrine\DBAL\Exception
     */
    public static function getInstance(string $host = 'blockchain-mysql'): Connection
    {
        if (null === self::$connection) {
            $params         = self::PARAMS;
            $params['host'] = $host;
            self::$connection = DriverManager::getConnection($params);
        }

        return self::$connection;
    }
}
