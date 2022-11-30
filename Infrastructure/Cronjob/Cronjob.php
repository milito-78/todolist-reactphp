<?php
namespace Infrastructure\Cronjob;

use Infrastructure\App;
use Infrastructure\Cronjob\Jobs\DeleteUnusedFilesJob;
use React\EventLoop\Loop;
use React\EventLoop\LoopInterface;

class Cronjob{
    private LoopInterface $loop;
    public function __construct()
    {
        $this->loop = Loop::get();
    }

    public function init(){
        $this->loop->addPeriodicTimer(60,App::make(DeleteUnusedFilesJob::class));
    }
}