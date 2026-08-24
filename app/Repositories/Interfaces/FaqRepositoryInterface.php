<?php

namespace App\Repositories\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface FaqRepositoryInterface
{
    /**
     * Get paginated FAQs.
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginated(int $perPage = 5): LengthAwarePaginator;
}
