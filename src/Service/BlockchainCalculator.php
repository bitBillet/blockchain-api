<?php

namespace App\Service;

use App\Validator\BlockchainValidator;

class BlockchainCalculator
{
    public const CURRENCY_BTC = 'BTC';
    private const COMMISSION_RATE = 2;
    public const MIN_VALUE_FROM = 0.01;
    private array $data = [];
    private float $convertRate = 0.0;

    private BlockchainValidator $validator;

    public function setData(array $data): void
    {
        $this->data      = $data;
        $this->validator = new BlockchainValidator($data);
    }

    public function rates(string $currency)
    {
        $this->validator->validateRates($currency);

        if (true === array_key_exists($currency, $this->data)) {
            $result = [
                $currency => $this->data[$currency]['buy']
            ];
        } else {
            $result = [];

            foreach ($this->data as $currencyTitle => $currencyData) {
                $result[$currencyTitle] = $this->calculateWithCommission((float)$currencyData['buy']);
            }
        }

        asort($result);

        return $result;
    }

    /**
     * @param string $currencyFrom
     * @param string $currencyTo
     * @param float $value
     * @return array
     * @throws \Exception
     */
    public function convert(string $currencyFrom, string $currencyTo, float $value): array
    {
        $this->validator->validateConvert($currencyFrom, $currencyTo, $value);

        if ($currencyFrom === self::CURRENCY_BTC) {
            $result = $this->convertFromBTC($currencyTo, $value);
        } else {
            $result = $this->convertToBTC($currencyFrom, $value);
        }

        return [
            'currency_from'   => $currencyFrom,
            'currency_to'     => $currencyTo,
            'value'           => sprintf("%01.10f", $this->calculateWithCommission($result)),
            'converted_value' => $value,
            'rate'            => $this->convertRate,
        ];
    }

    /**
     * @param string $currencyTo
     * @param float $value
     * @return float
     */
    public function convertFromBTC(string $currencyTo, float $value): float
    {
        $this->convertRate = (float)$this->data[$currencyTo]['buy'];

        return $this->convertRate * $value;
    }

    /**
     * @param string $currencyFrom
     * @param float $value
     * @return float
     */
    public function convertToBTC(string $currencyFrom, float $value): float
    {
        $this->convertRate = (float)$this->data[$currencyFrom]['sell'];

        return $value / $this->convertRate;
    }

    /**
     * @param float $value
     * @return float
     */
    public function calculateWithCommission(float $value): float
    {
        $commissionValue = (self::COMMISSION_RATE * $value) / 100;

        return $value - $commissionValue;
    }
}