<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $title
 * @property ?string $description
 * @property string status
 */
class Task extends Model
{
    use HasFactory;

    protected $table = "tasks";

    protected $fillable = [
        "title",
        "description",
        "status",
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $attributes = [
        'status' => 'pending',
    ];

    protected $casts = [
        'status' => TaskStatus::class,
    ];
}
