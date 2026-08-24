<?php

namespace App\Repositories;

use App\Repositories\Interfaces\FaqRepositoryInterface;
use App\Models\Faq;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class FaqRepository implements FaqRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function getPaginated(int $perPage = 5): LengthAwarePaginator
    {
        return Faq::paginate($perPage);
    }
}
