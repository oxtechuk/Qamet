<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Feature extends Model
{
    use HasTranslations;

    public $translatable = ['name'];

    protected $fillable = ['name', 'icon'];
}
