<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'emment',
        'material',
        'bibliography',
        'semester',
        'schedules',
        'active'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'emment' => 'array',
        'material' => 'string',
        'bibliography' => 'string',
        'semester' => 'integer',
        'schedules' => 'array',
        'active' => 'boolean'
    ];
}
