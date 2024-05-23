<?php

namespace GohostAuth\Enums;

enum UserType: string
{
    case Admin = 'admin';
    case GoHost = 'gohost';
    case Customer = 'customer';
}
