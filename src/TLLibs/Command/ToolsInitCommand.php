<?php


namespace TLLibs\Command;

use Illuminate\Console\Command;


class ToolsInitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tlib:tools {sub : api sub}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'copy user database and middleware to project';

    public function handle(){
        $subType = $this->input->getArgument('sub') ;
        if(empty($subType)){
            $subType= 'app_sub';
        }
        $this->laravel['config']['api.standards.tree'] = 'prs';
        $this->laravel['config']['api.subtype'] = $subType;
        $this->laravel['config']['api.prefix'] = 'api';
        $this->laravel['config']['api.version'] = 'v1';

    }

}
