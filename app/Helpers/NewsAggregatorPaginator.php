<?php
namespace App\Helpers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class NewsAggregatorPaginator
{
    protected array $data;
    protected array $meta;
    public function __construct(protected LengthAwarePaginator $paginatedData)
    {
        $this->setData();
        $this->setMeta();
    }

    protected function setData()
    {
        $this->data = $this->paginatedData->items();
    }

    protected function setMeta()
    {
        $this->meta = [
            'current_page' => $this->paginatedData->currentPage(),
            'last_page' => $this->paginatedData->lastPage(),
            'per_page' => $this->paginatedData->perPage(),
            'total' => $this->paginatedData->total(),
            'from' => $this->paginatedData->firstItem(),
            'to' => $this->paginatedData->lastItem(),
            'links' => [
                "first" =>  $this->paginatedData->url($this->paginatedData->currentPage()),
                "last" =>  $this->paginatedData->url($this->paginatedData->lastPage()),
                "prev" =>  $this->paginatedData->previousPageUrl(),
                "next" =>  $this->paginatedData->nextPageUrl(),
            ]
        ];
    }

    public function getData()
    {
        return $this->data;
    }

    public function getMeta()
    {
        return $this->meta;
    }
}