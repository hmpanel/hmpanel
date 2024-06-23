<?php

namespace App\Jobs;

use phpseclib3\Net\SSH2;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class NewSiteSSH implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $site;
    public $password;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($site)
    {
        $this->site = $site;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $this->password = 'password';

        \Log::info(config('app.url'));

        $ssh = new SSH2('127.0.0.1', 22);
        $ssh->login('hmpanel', 'password');
        $ssh->setTimeout(360);
        $ssh->exec('echo '.$this->password.' | sudo -S sudo unlink newsite');
        $ssh->exec('echo '.$this->password.' | sudo -S sudo wget '.config('app.url').'/sh/newsite');
        $ssh->exec('echo '.$this->password.' | sudo -S sudo dos2unix newsite');
        $ssh->exec('echo '.$this->password.' | sudo -S sudo bash newsite -dbr '.$this->password.' -u '.$this->site->username.' -p '.$this->site->password.' -dbp '.$this->site->database.' -php '.$this->site->php.' -id '.$this->site->id.' -d '.$this->site->domain->name.' -r '.config('app.url').' -b '.$this->site->basepath);
        $ssh->exec('exit');

        \Log::info('New Site SSH Job Done');
    }
}
