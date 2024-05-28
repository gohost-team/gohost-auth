<?php

namespace GohostAuth\Enums;

enum UserStatus: string
{
    case Active = 'active';
    case Pending = 'pending';
    case Inactive = 'inactive';
    case Disabled = 'disabled';
}
