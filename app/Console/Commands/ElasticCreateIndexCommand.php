<?php

namespace Hedonist\Console\Commands;

use Hedonist\Entities\Place\Place;
use Hedonist\Entities\Review\Review;
use Hedonist\Entities\UserList\UserList;
use Illuminate\Console\Command;
use Sleimanx2\Plastic\Facades\Plastic;

class ElasticCreateIndexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic:create-index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create elasticsearch index';

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

        $places = [
            'index' => (new Place())->getDocumentIndex(),
            'body' => [
                'settings' => [
                    'number_of_shards' => 1,
                    'number_of_replicas' => 0
                ]
            ]
        ];

        $reviews = [
            'index' => (new Review())->getDocumentIndex(),
            'body' => [
                'settings' => [
                    'number_of_shards' => 1,
                    'number_of_replicas' => 0
                ]
            ]
        ];

        $lists = [
            'index' => (new UserList())->getDocumentIndex(),
            'body' => [
                'settings' => [
                    'number_of_shards' => 1,
                    'number_of_replicas' => 0
                ]
            ]
        ];

        $client->indices()->create($reviews);

        $this->call('mapping:run');

        $reviews = Review::all();

        Plastic::persist()->bulkSave($reviews);
    }
}
