<?php

declare(strict_types=1);

namespace App\Entity;

class Token
{
    private string $token = '';

    private const AVAILABLE_SYMBOLS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_';

    public function __construct(string $token = '')
    {
        if ('' === $token) {
            $this->generate();
        }
    }

    /**
     * @return void
     */
    private function generate(): void
    {
        $symbolsArray = str_split($this::AVAILABLE_SYMBOLS);
        shuffle($symbolsArray);
        $this->token = implode('', $symbolsArray);
    }

    public function __toString(): string
    {
        return $this->token;
    }
}
