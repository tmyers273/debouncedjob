<?php

namespace tmyers273\debouncedjob;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

abstract class DebouncedJob implements ShouldQueue, SelfHandling {

    use InteractsWithQueue, Queueable;

    protected $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * Determines whether or not the job should be run,
     * based off of the job's id and the cache value
     *
     * @return bool
     */
    public function shouldBeRun()
    {
        $jobId = $this->job->getJobId();

        $expectedJobId = Cache::get($this->getCacheKey());

        if ($jobId != $expectedJobId) {
            return false;
        }

        return true;
    }

    /**
     * Creates the cache key
     *
     * @return string
     */
    public function getCacheKey()
    {
        $hash = $this->getHash();
        return 'debounced_job:' . $hash;
    }

    public function getHash()
    {
        return $this->hash($this->getHashString());
    }

    protected function getHashString()
    {
        return json_encode([
            'class' => get_class($this),
            'params' => json_encode($this->params)
        ]);
    }

    protected function hash($string)
    {
        return md5($string);
    }

}