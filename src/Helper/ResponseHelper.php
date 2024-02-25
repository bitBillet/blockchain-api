<?php

namespace App\Helper;

use App\Enum\Response\ResponseCode;
use App\Enum\Response\ResponseKey;
use App\Enum\Response\ResponseStatus;

class ResponseHelper
{
    public static function getErrorData(string $errorMessage): array
    {
        return [
            ResponseKey::STATUS->value  => ResponseStatus::ERROR->value,
            ResponseKey::CODE->value    => ResponseCode::ERROR->value,
            ResponseKey::MESSAGE->value => $errorMessage
        ];
    }

    public static function getSuccessData(array $data): array
    {
        return [
            ResponseKey::STATUS->value => ResponseStatus::SUCCESS,
            ResponseKey::CODE->value   => ResponseCode::SUCCESS,
            ResponseKey::DATA->value   => $data
        ];
    }
}
