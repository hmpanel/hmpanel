<?php

namespace App\Http\Controllers;

use App\Models\WebApp;
use App\Models\Alias;
use App\Models\Server;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ConfController extends Controller
{

    /**
     * Crontab file configuration
     *
    */
    public function cron(string $server_id)
    {
        $server = Server::where('server_id', $server_id)->where('status', 1)->firstOrFail();

        $script = Storage::get('hmpanel/cron.conf');
        if ($server->cron) {
            $script = Str::replaceArray('???', [
                $server->cron
            ], $script);
        } else {
            $script = Str::replaceArray('???', [
                ' '
            ], $script);
        }

        return response($script)
                ->withHeaders(['Content-Type' =>'text/plain']);
    }


    /**
     * HmPanel nginx configuration
     *
    */
    public function panel()
    {
        $server = Server::where('default', 1)->firstOrFail();

        $site = Site::where('server_id', $server->id)->where('panel', 1)->firstOrFail();
        $script = Storage::get('hmpanel/panel.conf');
        $script = Str::replaceArray('???', [
            $site->domain
        ], $script);

        return response($script)
                ->withHeaders(['Content-Type' =>'text/plain']);
    }


    /**
     * Site host configuration
     *
    */
    public function host($site_id)
    {
        $site = WebApp::findOrFail($site_id);

        if ($site->basepath) {
            $basepath = '/home/'.$site->domain->name.'/web/'.$site->basepath;
        } else {
            $basepath = '/home/'.$site->domain->name.'/web';
        }

        $script = Storage::get('hmpanel/host.conf');
        $script = str_replace('???USER???', $site->username, $script);
        $script = str_replace('???BASE???', $basepath, $script);
        $script = str_replace('???PHP???', $site->php, $script);
        $script = str_replace('???DOMAIN???', $site->domain->name, $script);
        return response($script)->withHeaders(['Content-Type' =>'text/plain']);
    }



    /**
     * Site alias configuration
     *
    */
    public function alias($alias_id)
    {
        $site = WebApp::findOrFail($site_id);

        if ($site->basepath) {
            $basepath = '/home/'.$site->domain->name.'/web/'.$site->basepath;
        } else {
            $basepath = '/home/'.$site->domain->name.'/web';
        }

        $script = Storage::get('hmpanel/host.conf');
        $script = str_replace('???USER???', $alias->site->username, $script);
        $script = str_replace('???BASE???', $basepath, $script);
        $script = str_replace('???PHP???', $alias->site->php, $script);
        $script = str_replace('???DOMAIN???', $alias->domain, $script);
        return response($script)->withHeaders(['Content-Type' =>'text/plain']);
    }



    /**
     * Site PHP configuration
     *
    */
    public function php($site_id)
    {
        $site = WebApp::findOrFail($site_id);


        $script = Storage::get('hmpanel/php.conf');
        $script = str_replace('???USER???', $site->username, $script);
        $script = str_replace('???DOMAIN???', $site->domain->name, $script);
        $script = str_replace('???PHP???', $site->php, $script);
        return response($script)->withHeaders(['Content-Type' =>'text/plain']);
    }


    /**
     * Site nginx configuration
     *
    */
    public function nginx()
    {
        $script = Storage::get('hmpanel/nginx.conf');
        return response($script)->withHeaders(['Content-Type' =>'text/plain']);
    }


    /**
     * Site supervisor configuration
     *
    */
    public function supervisor()
    {
        $script = Storage::get('hmpanel/supervisor.conf');
        return response($script)->withHeaders(['Content-Type' =>'text/plain']);
    }
}
