<?php

namespace App\Validator;

use App\Service\BlockchainCalculator;

class BlockchainValidator
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param string $currencyFrom
     * @param string $currencyTo
     * @param float $value
     * @return void
     * @throws \Exception
     */
    public function validateConvert(string $currencyFrom, string $currencyTo, float $value)
    {
        if (
            BlockchainCalculator::CURRENCY_BTC !== $currencyFrom
            && false === array_key_exists($currencyFrom, $this->data)
        ) {
            throw new \Exception('Не найдена валюта из которой конвертируем');
        }

        if (
            BlockchainCalculator::CURRENCY_BTC !== $currencyTo
            && false === array_key_exists($currencyTo, $this->data)
        ) {
            throw new \Exception('Не найдена валюта, в которую нужно конвертировать');
        }

        if ($value < BlockchainCalculator::MIN_VALUE_FROM) {
            throw new \Exception('Значение валюты меньше ' . BlockchainCalculator::MIN_VALUE_FROM);
        }
    }

    public function validateRates(string $currency)
    {
        if (
            '' !== $currency
            && false === array_key_exists($currency, $this->data)
        ) {
            throw new \Exception("Валюта $currency не найдена");
        }
    }
}