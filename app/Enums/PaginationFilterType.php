<?php

namespace App\Enums;

enum PaginationFilterType: int
{
    case Five = 5;
    case Ten = 10;
    case Twenty = 20;
    case Fifty = 50;
    case All = -1;
}
