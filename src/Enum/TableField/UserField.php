<?php

namespace App\Enum\TableField;

enum UserField: string
{
    case ID = 'id';
    case LOGIN = 'login';
    case PASSWORD = 'password';
    case TOKEN = 'token';
}
