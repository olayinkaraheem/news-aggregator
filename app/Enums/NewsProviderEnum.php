<?php

namespace App\Enums;

enum NewsProviderEnum: string
{
    use PHP8BaseEnum;

    case THE_GUARDIAN = 'the_guardian';
    case NEWSAPI = 'newsapi';
    case NEW_YORK_TIMES = 'new_york_times';
}
