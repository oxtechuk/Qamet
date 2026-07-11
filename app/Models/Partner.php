<?php

namespace App\Models;

use App\Casts\AsImageUrl;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $fillable = ['name', 'logo', 'link', 'sort_order'];

    protected $casts = [
        'logo' => AsImageUrl::class,
    ];
}
