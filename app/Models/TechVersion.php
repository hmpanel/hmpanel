<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TechVersion extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['version', 'technology_id'];

    protected $searchableFields = ['*'];

    protected $table = 'tech_versions';

    public function technology()
    {
        return $this->belongsTo(Technology::class);
    }
}
