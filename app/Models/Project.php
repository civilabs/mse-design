<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'location', 'latitude', 'longitude',
        'image', 'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'members');
    }

    public function designs()
    {
        return $this->hasMany(Design::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
