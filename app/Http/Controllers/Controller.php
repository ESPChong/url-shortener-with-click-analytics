<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="URL Shortener API",
 *      description="API for shortening URLs and tracking click analytics"
 * )
 */
#[OA\SecurityScheme(
    securityScheme: 'bearerAuth',
    type: 'http',
    scheme: 'bearer',
    bearerFormat: 'Sanctum Personal Access Token',
    description: 'Issue a token with "php artisan api-token:create {email}" and send it as "Bearer {token}".'
)]
abstract class Controller
{
    //
}
