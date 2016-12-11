<?php

namespace tmyers273\debouncedjob;

use Illuminate\Support\ServiceProvider;
use tmyers273\debouncedjob\Commands\DebouncedJobMakeCommand;

class DebouncedJobServiceProvider extends ServiceProvider {

    protected $defer = false;

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                DebouncedJobMakeCommand::class
            ]);
        }
    }

    public function register()
    {
//        $this->app->bind('debouncedjob', function($app) {
//            return new Debou
//        });
    }
}