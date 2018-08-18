<?php

namespace Tests\Feature\Repository\Place;

use Hedonist\Entities\Place\Location;
use Hedonist\Entities\Place\Place;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlaceRepositoryTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private $placeRepository;

    protected function setUp()
    {
        parent::setUp();

        $this->placeRepository = app(\Hedonist\Repositories\Place\PlaceRepository::class);
        factory(Place::class, 10)->create([
            'longitude' => $this->faker->randomFloat(4, 10, 50),
            'latitude' => $this->faker->randomFloat(4, 10, 50),
        ]);
    }

    public function testFindByCoordinatesNotFound()
    {
        $location = new Location(100, 90);
        $result = $this->placeRepository->findByCoordinates($location, 1);
        $this->assertEmpty($result);
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