<?php

namespace App\Exceptions;

use Exception;
use App\Helpers\Http\NewsAggregatorResponse;
use Illuminate\Http\JsonResponse;

class GeneralUserException extends Exception
{
    public function __construct(string $msg)
    {
        parent::__construct();

        $this->message = $msg;
    }

    public function render(): JsonResponse
    {
        return (new NewsAggregatorResponse(
            message: $this->message
        ))->asBadRequest();
    }
}
