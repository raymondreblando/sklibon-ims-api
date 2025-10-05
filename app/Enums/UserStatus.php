<?php

namespace App\Enums;

enum UserStatus: string
{
    case Active = 'active';
    case Verified = 'verified';
    case Deactivated = 'deactivated';
    case Blocked = 'blocked';
}
