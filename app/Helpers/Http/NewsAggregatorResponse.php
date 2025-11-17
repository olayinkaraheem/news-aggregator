<?php

namespace App\Helpers\Http;

use Illuminate\Http\JsonResponse;

class NewsAggregatorResponse
{
    const OK = 200;
    const UPDATED = 202;
    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const VALIDATION_ERROR = 422;
    const SERVER_ERROR = 500;


    public function __construct(
        protected array $data = [],
        protected string $message = '',
        protected string|array $error = [],
        protected array $meta = []
    )
    {}

    public function asSuccessful() : JsonResponse
    {
        return $this->responseArray(self::OK);
    }

    public function asBadRequest() : JsonResponse
    {
        return $this->responseArray(self::BAD_REQUEST);
    }

    public function asUpdated() : JsonResponse
    {
        return $this->responseArray(self::UPDATED);
    }

    public function asNotFound() : JsonResponse
    {
        return $this->responseArray(self::NOT_FOUND);
    }

    public function asServerError() : JsonResponse
    {
        return $this->responseArray(self::SERVER_ERROR);
    }

    public function asValidationError() : JsonResponse
    {
        return $this->responseArray(self::VALIDATION_ERROR);
    }

    public function asUnauthorizedError() : JsonResponse
    {
        return $this->responseArray(self::UNAUTHORIZED);
    }

    public function asForbidden() : JsonResponse
    {
        return $this->responseArray(self::FORBIDDEN);
    }

    private function responseArray(int $statusCode) : JsonResponse
    {
        return response()->json([
            'success'   => $statusCode <= 202,
            'data'      => $this->data,
            'message'   => $this->message,
            'error'     => $this->error,
            'meta'     => $this->meta
        ], $statusCode);
    }
}
