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
        Map::create($this->getModelType(),function(Blueprint $map){
            $map->integer('id')->index('not_analyzed');
            $map->string('description');
            $map->nested('user',function (Blueprint $map){
               $map->integer('id')->index('not_analyzed');
               $map->string('email');
            });
            $map->nested('place', function(Blueprint $map){
                $map->integer('id')->index('not_analyzed');
                $map->string('location');
                $map->string('name');
            });
        },$this->getModelIndex());
    }
}
