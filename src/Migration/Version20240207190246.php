<?php

declare(strict_types=1);

namespace App\Migration;


use App\Entity\Token;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Psr\Log\LoggerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240207190246 extends AbstractMigration
{
    private UserRepository $userRepository;
    private const USER_LOGIN = 'someuser';
    private const USER_PASSWORD = 'qwerty123';

    public function __construct(Connection $connection, LoggerInterface $logger)
    {
        $this->userRepository = new UserRepository($connection);
        parent::__construct($connection, $logger);
    }

    public function getDescription(): string
    {
        return 'Add new user';
    }

    public function up(Schema $schema): void
    {
        $user = (new User())
            ->setLogin(self::USER_LOGIN)
            ->setPassword(self::USER_PASSWORD)
            ->setToken(new Token());
        $this->userRepository->add($user);
    }

    public function down(Schema $schema): void
    {
        $this->userRepository->deleteByLogin(self::USER_LOGIN);
    }
}
