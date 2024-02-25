<?php

namespace App\Enum\Response;

enum ResponseKey: string
{
    case STATUS = 'status';
    case MESSAGE = 'message';
    case CODE = 'code';
    case DATA = 'data';
}
