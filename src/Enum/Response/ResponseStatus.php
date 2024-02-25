<?php

namespace App\Enum\Response;

enum ResponseStatus: string
{
    case ERROR = 'error';
    case SUCCESS = 'success';
}
