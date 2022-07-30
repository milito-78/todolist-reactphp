<?php


namespace App\Core\Providers;

use App\Core\CornJobs\RemoveExtraFilesJob;
use Core\Providers\CronJobServiceProvider as Provider;
class CronJobServiceProvider extends Provider
{
    protected array $jobs = [
        RemoveExtraFilesJob::class => 60
    ];

}