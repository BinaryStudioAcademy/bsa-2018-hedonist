<?php

namespace Tests\Feature\Repository\Place;

use Hedonist\Entities\Place\Location;
use Hedonist\Entities\Place\Place;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlaceRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private $placeRepository;

    protected function setUp()
    {
        parent::setUp();

        $this->placeRepository = app(\Hedonist\Repositories\Place\PlaceRepository::class);
    }

    public function testFindByCoordinates()
    {
        $place = factory(Place::class)->create();
        $location = new Location($place->longitude, $place->latitude);
        $result = $this->placeRepository->findByCoordinates($location, 50);

        $ids = [];
        foreach ($result as $item) {
            $ids[] = $item->id;
        }
        $this->assertContains($place->id, $ids);
    }
}