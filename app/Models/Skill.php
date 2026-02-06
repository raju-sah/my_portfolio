<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Skill extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'skill_domain' => \App\Enums\SkillDomain::class,
    ];
}
