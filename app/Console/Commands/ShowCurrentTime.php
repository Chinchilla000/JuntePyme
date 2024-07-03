<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

class ShowCurrentTime extends Command
{
    protected $signature = 'show:current-time';
    protected $description = 'Display the current time';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $currentTime = Carbon::now();
        $this->info('Current time: ' . $currentTime);
    }
}
