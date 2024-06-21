<?php

namespace App\Http\Controllers;


use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ShellController extends Controller
{
    /**
     * Server Root User Reset script
     *
    */
    public function serversrootreset()
    {
        $script = Storage::get('hmpanel/rootreset.sh');

        return response($script)
                ->withHeaders(['Content-Type' =>'application/x-sh']);
    }

    /**
     * New Site script
     *
    */
    public function newsite()
    {
        $script = Storage::get('hmpanel/newsite.sh');

        return response($script)
                ->withHeaders(['Content-Type' =>'application/x-sh']);
    }


    /**
     * Delete Site script
     *
    */
    public function delsite()
    {
        $script = Storage::get('hmpanel/delsite.sh');

        return response($script)
                ->withHeaders(['Content-Type' =>'application/x-sh']);
    }


    /**
     * Reset Site Credentials script
     *
    */
    public function sitepass()
    {
        $script = Storage::get('hmpanel/sitepass.sh');

        return response($script)
                ->withHeaders(['Content-Type' =>'application/x-sh']);
    }

}
