<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Format for modifying the default setup
// #[Table('my_faqs', key: 'uuid', keyType: 'string', incrementing: false)]
class Faq extends Model
{
    use HasFactory;

    /**
     * The model's default values for attributes.
     *
     * @var array<string, string>
     */
    protected $attributes = [
        'question' => 'Placeholder Question?',
        'answer' => 'Placeholder Answer.',
    ];
}
