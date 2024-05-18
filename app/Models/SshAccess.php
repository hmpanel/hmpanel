<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SshAccess extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['username', 'password', 'web_app_id'];

    protected $searchableFields = ['*'];

    protected $table = 'ssh_accesses';

    protected $hidden = ['password'];

    public function webApp()
    {
        return $this->belongsTo(WebApp::class);
    }
}
