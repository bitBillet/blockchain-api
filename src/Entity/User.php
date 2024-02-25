<?php

declare(strict_types=1);

namespace App\Entity;

class User extends AbstractEntity
{
    private int $id = 0;
    private string $login = '';
    private string $password = '';
    private Token $token;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     * @return User
     */
    public function setLogin(string $login): User
    {
        $this->login = $login;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return (string)$this->token;
    }

    /**
     * @param Token $token
     * @return User
     */
    public function setToken(Token $token): User
    {
        $this->token = $token;
        return $this;
    }
}
