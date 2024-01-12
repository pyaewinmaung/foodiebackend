<?php

namespace App\Models;

use App\Models\Instruction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'instruction',
        'image',
        'amount',
        'type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function instrucion()
    {
        return $this->belongsTo(Instruction::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // public function instructions()
    // {
    //     return $this->hasMany(Instruction::class);
    // }

    public function buyers()
    {
        return $this->hasMany(RecipeBuyer::class);
    }
}
