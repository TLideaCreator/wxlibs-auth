<?php

namespace TLLibs\Provider;
use Illuminate\Support\ServiceProvider;
use TLLibs\Command\KeyGenerate;
use TLLibs\Command\ToolsInitCommand;
use TLLibs\Middleware\CORSMiddleware;

class TLLibsProviders extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/Table');
        if($this->app->runningInConsole()){
            $this->commands([
                KeyGenerate::class,
                ToolsInitCommand::class
            ]);
        }
        $this->app->middleware([CORSMiddleware::class]);
    }
}
