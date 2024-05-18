<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebApp extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'path', 'domain_id'];

    protected $searchableFields = ['*'];

    protected $table = 'web_apps';

    public function ftpAccounts()
    {
        return $this->hasMany(FtpAccount::class);
    }

    public function sshAccesses()
    {
        return $this->hasMany(SshAccess::class);
    }

    public function emailAccounts()
    {
        return $this->hasMany(EmailAccount::class);
    }

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }
}
