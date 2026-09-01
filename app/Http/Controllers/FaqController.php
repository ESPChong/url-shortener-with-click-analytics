<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\FaqRepositoryInterface;
use OpenApi\Attributes as OA;

class FaqController extends Controller
{
    #[OA\Get(
        path: '/faq',
        summary: 'Get paginated Faqs',
        description: 'Returns frequently asked questions with pagination',
        tags: ['FAQs'],
        parameters: [
            new OA\Parameter(
                name: 'page',
                in: 'query',
                description: 'Page number for pagination',
                schema: new OA\Schema(type: 'integer', default: 1)
            )
        ],
        responses: [
            new OA\Response(
                name: 'page',
                in: 'query',
                description: 'Page number',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/Faq')),
                        new OA\Property(property: 'meta', ref: '#/components/schemas/PaginationMeta')
                    ]
                )
            )
        ]
    )]

    public function __construct(
        private FaqRepositoryInterface $faqRepository
    ) {}

    public function index(Request $request)
    {
        return Inertia::render('faq', [
            'faqs' => $this->faqRepository->getPaginated(5)
        ]);
    }
}
