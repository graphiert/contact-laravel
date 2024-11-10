<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'username', 'phone', 'email', 'gender', 'profile'];

    public function getRouteKeyName(): string
    {
        return 'username';
    }

    public function scopeSearch($query, $keyword): void
    {
        $query->where('name', 'like', '%' . $keyword . '%');
    }
}
