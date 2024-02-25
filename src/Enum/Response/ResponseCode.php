<?php

namespace App\Enum\Response;

enum ResponseCode: int
{
    case ERROR = 403;
    case SUCCESS = 200;
}
