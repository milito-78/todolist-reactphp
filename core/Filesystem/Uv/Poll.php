<?php

namespace Core\Filesystem\Uv;

use React\EventLoop\TimerInterface;
use Core\Filesystem\PollInterface;

use React\EventLoop\LoopInterface;

final class Poll implements PollInterface
{
    private LoopInterface $loop;
    private int $workInProgress = 0;
    private ?TimerInterface $workInProgressTimer = null;
    private int $workInterval = 10;

    public function __construct(LoopInterface $loop)
    {
        $this->loop = $loop;
    }

    public function activate(): void
    {
        if ($this->workInProgress++ === 0) {
            $this->workInProgressTimer = $this->loop->addPeriodicTimer($this->workInterval, static function () {});
        }
    }

    public function deactivate(): void
    {
        if (--$this->workInProgress <= 0) {
            $this->loop->cancelTimer($this->workInProgressTimer);
        }
    }
}
