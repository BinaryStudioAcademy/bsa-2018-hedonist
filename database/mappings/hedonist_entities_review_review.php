<?php

use Sleimanx2\Plastic\Map\Blueprint;
use Sleimanx2\Plastic\Mappings\Mapping;

class HedonistEntitiesReviewReview extends Mapping
{
    /**
     * Full name of the model that should be mapped
     *
     * @var string
     */
    protected $model = Hedonist\Entities\Review\Review::class;

    /**
     * Run the mapping.
     *
     * @return void
     */
    public function map()
    {
        Map::create($this->getModelType(), function (Blueprint $map) {
            $map->integer('id');
            $map->addField('text', 'description');
            $map->object('user', function (Blueprint $map) {
                $map->integer('id');
                $map->addField('text', 'email');
                $map->addField('text', 'first_name');
                $map->addField('text', 'last_name');
            });
            $map->integer('likes_count');
            $map->integer('place_id');
            $map->nested('likes', function (Blueprint $map) {
            });
            $map->nested('dislikes', function (Blueprint $map) {
            });
            $map->date('created_at', ['format' => 'yyyy-MM-dd HH:mm:ss']);
        }, $this->getModelIndex());
    }
}
