<?php

namespace App\Repository;

use App\Entity\AbstractEntity;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;

abstract class AbstractRepository
{
    protected Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    abstract public static function getTableName(): string;

    abstract public static function createTable(Schema $schema): void;

    abstract public static function getPrimaryFields(): array;

    /**
     * Поля таблицы должны возвращать массив с типом тип Enum[] из неймспейса App\Enum\TableField::cases()
     *
     * @return Enum[]
     */
    abstract public static function getEnumFields(): array;

    /**
     * @param AbstractEntity $entity
     * @return int
     * @throws \Doctrine\DBAL\Exception
     */
    public function add(AbstractEntity $entity)
    {
        $this->connection->createQueryBuilder()
            ->insert($this::getTableName())
            ->values($this->prepareValues($entity))
            ->setParameters($entity->toArray())
            ->executeQuery()
        ;

        return (int)$this->connection->lastInsertId();
    }

    /**
     * @param AbstractEntity $entity
     * @return array
     */
    private function prepareValues(AbstractEntity $entity)
    {
        $result     = [];
        $entityKeys = $entity->toArray();

        foreach ($this::getEnumFields() as $field) {
            if (true === array_key_exists($field->value, $entityKeys)) {
                $result[$field->value] = ":$field->value";
            }
        }

        return $result;
    }

    public function deleteByPrimary(AbstractEntity $entity)
    {
        $this->connection->createQueryBuilder()
            ->delete($this::getTableName())
            ->where($this->getPrimaryFilter())
            ->setParameters($entity->toArray())
            ->executeQuery()
        ;
    }

    protected function getPrimaryFilter(): string
    {
        $fields = [];

        foreach ($this::getPrimaryFields() as $primaryField) {
            $fields[] = $primaryField . ' = :' . $primaryField;
        }

        if (count($fields) > 1) {
            $result = implode(' AND ', $fields);
        } else {
            $result = $fields[0];
        }

        return $result;
    }
}
