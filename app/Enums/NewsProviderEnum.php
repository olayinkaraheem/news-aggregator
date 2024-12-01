<?php

namespace App\Enums;

enum NewsProviderEnum: string
{
    use PHP8BaseEnum;

    case THE_GUARDIAN = 'theguardian';
    case NEWSAPI = 'newsapi';
}
