<?php


namespace TLLibs\Command;

use Illuminate\Console\Command;


class UserDBCommand extends Command
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
    private $dbs = [
        '2019_10_29_105659_create_table_users.php',
        '2019_10_29_110452_create_table_seeders.php'
    ];

    public function handle(){
        foreach ($this->dbs as $db) {
            $newDb = database_path('migrations/'.$db);
            copy(
                __DIR__.'/Table/'.$db,
                $newDb
            );
        }
        $subType = $this->input->getArgument('sub') ;
        if(empty($subType)){
            $subType= 'app_sub';
        }

        $envContent = fopen(base_path('.env'), 'a');
        fwrite($envContent, "API_STANDARDS_TREE=prs\nAPI_SUBTYPE={$subType}\nAPI_PREFIX=api\nAPI_VERSION=v1\n");
        fclose($envContent);

        $envContent = fopen(base_path('.env.example'), 'a');
        fwrite($envContent, "API_STANDARDS_TREE=prs\nAPI_SUBTYPE={$subType}\nAPI_PREFIX=api\nAPI_VERSION=v1\n");
        fclose($envContent);
    }

}
