<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @mixin \App\Models\Url
 */
#[OA\Schema(
    schema: 'Url',
    properties: [
        new OA\Property(property: 'original_url', type: 'string', format: 'url', example: 'https://example.com/very/long/url'),
        new OA\Property(property: 'short_url', type: 'string', format: 'url', example: 'http://localhost/r/mylink'),
        new OA\Property(property: 'short_code', type: 'string', example: 'mylink'),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2026-11-13T12:00:00Z'),
    ]
)]
class UrlResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'original_url' => $this->long_url,
            'short_url' => route('redirect.show', $this->short_url),
            'short_code' => $this->short_url,
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
