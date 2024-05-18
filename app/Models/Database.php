<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Database extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'username', 'password'];

    protected $searchableFields = ['*'];

    protected $hidden = ['password'];
}
