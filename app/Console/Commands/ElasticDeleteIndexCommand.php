<?php

namespace Hedonist\Console\Commands;

use Hedonist\Entities\Place\Place;
use Hedonist\Entities\Review\Review;
use Hedonist\Entities\UserList\UserList;
use Illuminate\Console\Command;
use Sleimanx2\Plastic\Facades\Plastic;

class ElasticDeleteIndexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic:delete-index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete elasticsearch index';

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
        $client = Plastic::getClient();

        $client->indices()->delete([
            'index'=> (new Place())->getDocumentIndex()
        ]);

        $client->indices()->delete([
            'index'=> (new Review())->getDocumentIndex()
        ]);

        $client->indices()->delete([
            'index'=> (new UserList())->getDocumentIndex()
        ]);
    }
}
