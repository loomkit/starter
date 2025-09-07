<?php

namespace App\Enums;

use Sikessem\Concerns\Enumerates;

enum AdminRole: string
{
    use Enumerates;

    case Admin = 'admin';
    case SuperAdmin = 'super_admin';
}
