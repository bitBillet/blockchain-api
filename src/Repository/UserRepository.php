<?php

namespace App\Repository;


use App\Entity\AbstractEntity;
use App\Entity\Token;
use App\Entity\User;
use App\Enum\TableField\UserField;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;

class UserRepository extends AbstractRepository
{
    public static function getTableName(): string
    {
        return 'user';
    }

    public static function getPrimaryFields(): array
    {
        return [UserField::LOGIN->value];
    }

    public static function createTable(Schema $schema): void
    {
        $userTable = $schema->createTable(self::getTableName());

        $userTable->addColumn(UserField::ID->value, Types::INTEGER)
            ->setAutoincrement(true);

        $userTable->addColumn(UserField::LOGIN->value, Types::STRING)
            ->setLength(50);

        $userTable->addColumn(UserField::PASSWORD->value, Types::STRING)
            ->setLength(60);

        $userTable->addColumn(UserField::TOKEN->value, Types::STRING)
            ->setLength(64);

        $userTable->addUniqueConstraint([UserField::LOGIN->value]);
        $userTable->setPrimaryKey([UserField::ID->value]);
    }

    public static function getEnumFields(): array
    {
        return UserField::cases();
    }

    public function deleteByLogin(string $login)
    {
        $this->connection->createQueryBuilder()
            ->delete($this::getTableName())
            ->where(UserField::LOGIN->value . ' = :' . UserField::LOGIN->value)
            ->setParameter(UserField::LOGIN->value, $login)
            ->executeQuery()
        ;
    }

    public function getByLogin(string $login)
    {
        $result = new User();
        $statement = $this->connection->createQueryBuilder()
            ->select('*')
            ->from($this::getTableName())
            ->where(UserField::LOGIN->value . ' = :' . UserField::LOGIN->value)
            ->setMaxResults(1)
            ->setParameter(UserField::LOGIN->value, $login)
            ->executeQuery()
            ->fetchAllAssociative()
        ;

        if (count($statement) > 0) {
            $result = $this->fromArray($statement[array_key_first($statement)]);
        }

        return $result;
    }

    /**
     * @param User $user
     * @return true
     * @throws \Doctrine\DBAL\Exception
     */
    public function updateToken(User $user): bool
    {
        $this->connection->createQueryBuilder()
            ->update($this::getTableName())
            ->where(UserField::LOGIN->value . '=:' . UserField::LOGIN->value)
            ->set(UserField::LOGIN->value, ':' . UserField::LOGIN->value)
            ->set(UserField::TOKEN->value, ':' . UserField::TOKEN->value)
            ->setParameters(
                [
                    UserField::LOGIN->value => $user->getLogin(),
                    UserField::TOKEN->value => $user->getToken(),
                ]
            )
            ->executeQuery()
        ;

        return true;
    }

    public function fromArray($dbData)
    {
        return (new User())->setId((int)$dbData[UserField::ID->value])
            ->setLogin((string)$dbData[UserField::LOGIN->value])
            ->setPassword((string)$dbData[UserField::PASSWORD->value])
            ->setToken(new Token((string)$dbData[UserField::TOKEN->value]))
            ;
    }

    /**
     * @param string $token
     * @return bool
     * @throws \Doctrine\DBAL\Exception
     */
    public function existByToken(string $token): bool
    {
        $id = (int)$this->connection->createQueryBuilder()
            ->select(UserField::ID->value)
            ->from($this::getTableName())
            ->where('token = :token')
            ->setParameter('token', $token)
            ->executeQuery()
            ->fetchOne()
            ;

        return $id > 0;
    }

    public function add(User|AbstractEntity $entity)
    {
        $entity->setPassword(password_hash($entity->getPassword(), PASSWORD_BCRYPT));
        return parent::add($entity);
    }
}