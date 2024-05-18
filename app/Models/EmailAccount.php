<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmailAccount extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['email', 'password', 'web_app_id'];

    protected $searchableFields = ['*'];

    protected $table = 'email_accounts';

    protected $hidden = ['password'];

    public function webApp()
    {
        return $this->belongsTo(WebApp::class);
    }
}
