<?php

namespace tmyers273\debouncedjob;

use Illuminate\Support\Facades\Cache;

trait DispatchesDebouncedJobs {

    use \Illuminate\Foundation\Bus\DispatchesJobs;

    /**
     * Dispatches a debounced job
     *
     * @param DebouncedJob $job
     * @param int $delay in seconds
     * @param null $params optional parameters to hash against
     * @return mixed
     */
    protected function dispatchDebounced(DebouncedJob $job, $delay = 10, $params = null)
    {
        $jobId = $this->dispatch($job->delay($delay));

        Cache::put($job->getCacheKey(), $jobId, $this->getCacheTime($delay));

        return $jobId;
    }

    /**
     * Returns the time, in minutes, to cache value for
     *
     * @param $delay
     * @return float
     */
    protected function getCacheTime($delay)
    {
        return ceil($delay / 60) + 1;
    }

}