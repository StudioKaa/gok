<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;

class MySqlDump extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:mysqldump';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs the mysqldump utility';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $ds = DIRECTORY_SEPARATOR;

        $db = config('database.connections.mysql.database');
        $user = config('database.connections.mysql.username');
        $pass = config('database.connections.mysql.password');


        $path = database_path() . $ds . 'backups' . $ds . date('Y') . $ds . date('m') . $ds;
        $file = date('Y-m-d') . '_mysqldump.sql';
        $command = sprintf('mysqldump %s -u %s -p\'%s\' > %s', $db, $user, $pass, $path . $file);

        echo $command;

        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        exec($command);

        Mail::raw('Backup from GOK', function ($message) use ($path, $file){
            $message->subject('GOK backup: ' . $file)->to('bartjroos@gmail.com')->attach($path . $file);
        });
    }
}