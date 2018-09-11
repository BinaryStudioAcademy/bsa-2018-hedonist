<?php

namespace tests\Feature\Api\Place;

use Hedonist\Entities\Localization\Language;
use Hedonist\Entities\Place\Place;
use Hedonist\Entities\Place\PlaceCategory;
use Hedonist\Entities\Place\PlaceTaste;
use Hedonist\Entities\User\Taste;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\Feature\Api\ApiTestCase;
use Hedonist\Entities\Place\Tag;
use Hedonist\Entities\Place\PlaceFeature;

class PlaceControllerTest extends ApiTestCase
{
    use DatabaseTransactions;
    use WithFaker;

    private $place;
    const ENDPOINT = '/api/v1/places';

    public function setUp()
    {
        parent::setUp();

        $this->place = factory(Place::class)->create();
    }

    public function testGetCollection()
    {
        $response =  $this->actingWithToken()->json(
            'GET',
            self::ENDPOINT
        );
        $arrayContent = $response->getOriginalContent();
        $this->assertTrue(isset(
            $arrayContent['data'][0]['id'],
            $arrayContent['data'][0]['city'],
            $arrayContent['data'][0]['address'])
        );
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
    }

    public function testGetPlace()
    {
        $routeName = 'getPlace';
        $response =  $this->actingWithToken()->json(
            'GET',
            self::ENDPOINT . "/{$this->place->id}"
        );

        $this->checkJsonStructure($response);
        $this->assertEquals(
            self::ENDPOINT . "/{$this->place->id}",
            route($routeName, ['id' => $this->place->id], false)
        );
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
    }

    public function testAddPlace()
    {
        $routeName = 'addPlace';

        Language::create([
            'code'    => 'en',
            'active'  => 1,
            'default' => 1
        ]);

        Tag::create([
            'name' => 'Ice-cream cafe'
        ]);

        PlaceFeature::create([
            'name' => 'Live music'
        ]);

        $response = $this->actingWithToken()->json(
            'POST', route($routeName),
            [
                'creator_id'   => $this->place->creator->id,
                'localization' => json_encode([
                    'en' => [
                        'name'        => 'Test',
                        'description' => 'Test description....'
                    ]
                ]),
                'category_id'  => $this->place->category->id,
                'tags'         => [1],
                'features'     => [1],
                'city'         => json_encode([
                    'text_en' => 'Kyiv',
                    'center'  => [
                        '30.5241',
                        '50.4501'
                    ]
                ]),
                'longitude'    => -20,
                'latitude'     => 32.3,
                'zip'          => '03322',
                'address'      => 'Test address',
                'phone'        => +380636678400,
                'website'      => 'http://beef.kiev.ua/',
                'facebook'     => 'https://facebook.com/',
                'instagram'    => 'https://instagram.com/',
                'twitter'      => 'https://twitter.com/',
                'menu_url'     => 'https://menu.com/',
                'work_weekend' => 1,
                'worktime'     => json_encode([
                        'mo' => [
                            'start' => '2018-08-30UTC07:00:10.2390',
                            'end'   => '2018-08-30UTC18:00:10.2390'
                        ]
                    ])
            ]
        );
        $newPlace = $response->getOriginalContent();

        $this->assertDatabaseHas('places', [
            'id' => $newPlace['data']['id'],
            'zip' => $newPlace['data']['zip'],
        ]);
        $this->checkJsonStructure($response);
        $response->assertStatus(201);
        $response->assertHeader('Content-Type', 'application/json');

        /* PlaceLocalization */
        $this->assertDatabaseHas('places_tr', [
            'place_name' => 'Test'
        ]);

        /* PlaceTags */
        $this->assertDatabaseHas('place_tag', [
            'place_id' => $newPlace['data']['id']
        ]);

        /* PlaceFeatures */
        $this->assertDatabaseHas('places_places_features', [
            'place_id' => $newPlace['data']['id']
        ]);

        /* PlaceWorktime */
        $this->assertDatabaseHas('place_worktime', [
            'place_id' => $newPlace['data']['id']
        ]);
    }

    public function testUpdatePlace()
    {
        $routeName = 'updatePlace';
        $response = $this->actingWithToken()->json(
            'PUT',
            route($routeName, ['id' => $this->place->id]),
            [
                'creator_id' => $this->place->creator->id,
                'category_id' => $this->place->category->id,
                'city_id' => $this->place->city->id,
                'longitude' => -90,
                'latitude' => 33.3,
                'zip' => '01234',
                'address' => 'sdf',
                'phone' => +380636678400,
                'website' => 'http://beef.kiev.ua/'
            ]
        );
        $updatedPlace = $response->getOriginalContent();

        $this->assertEquals(33.3, $updatedPlace['data']['latitude']);
        $this->assertEquals(1234, $updatedPlace['data']['zip']);
        $this->checkJsonStructure($response);
        $response->assertStatus(201);
        $response->assertHeader('Content-Type', 'application/json');
    }

    public function testRemovePlace()
    {
        $response = $this->actingWithToken()->json(
            'DELETE',
            self::ENDPOINT . "/{$this->place->id}"
        );

        $this->assertDatabaseMissing('places', [
            'id' => $this->place->id,
            'deleted_at' => null
        ]);
        $response->assertStatus(204);
        $response->assertHeaderMissing('Content-Type');
    }

    public function testShowNotExistingPlace()
    {
        $response =  $this->actingWithToken()->json(
            'GET',
            self::ENDPOINT . '/99999999'
        );
        $response->assertStatus(404);
    }

    public function testDestroyNotExistingId()
    {
        $response =  $this->actingWithToken()->json(
            'DELETE',
            self::ENDPOINT . '/99999999'
        );
        $response->assertStatus(404);
    }

    public function testWrongDataUpdate()
    {
        $routeName = 'updatePlace';
        $response = $this->actingWithToken()->json(
            'PUT',
            route($routeName, ['id' => $this->place->id]),
            [
                'creator_id' => -1,
                'category_id' => 'ew',
                'city_id' => 'df',
                'longitude' => -9999,
                'latitude' => 99999999,
                'zip' => '01234',
                'address' => 'sdf',
                'phone' => 'dsd',
                'website' => 'ghf',
            ]
        );

        $response->assertStatus(422);
    }

    public function testGetPlaceCollectionUnauthenticated()
    {
        $response = $this->call('GET', self::ENDPOINT);

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->status());
    }

    public function checkJsonStructure($response)
    {
        /* @var \Illuminate\Foundation\Testing\TestResponse $response */
        $response->assertJsonStructure(['data' => [
            'id',
            'longitude',
            'latitude',
            'zip',
            'address',
            'phone',
            'website'
        ]]);
    }

    public function testGetPlaceCollectionSearchByFilters()
    {
        $category = factory(PlaceCategory::class)->create();
        $longitude = 36.1954606;
        $latitude = 50.059325199999996;

        factory(Place::class)->create([
            'latitude' => 50.0325,
            'longitude' => 36.2261,
            'category_id' => $category->id,
        ]);
        $polygon = '36.22468218610891,50.032931373412566;36.226043431117205,50.03337030919096;36.227241977497954,50.03260391077478;36.22617901327993,50.03175040724011;36.22476895869954,50.03225902749995;36.22468218610891,50.032931373412566';

        $response =  $this->actingWithToken()->json(
            'GET',
            "/api/v1/places/search?filter[category]=$category->id&filter[location]=$longitude,$latitude&filter[polygon]=$polygon&page=1"
        );
        $arrayContent = $response->getOriginalContent();
        $response->assertJsonStructure([
            'data' => [
                0 => [
                    'id',
                    'longitude',
                    'latitude',
                    'zip',
                    'address',
                    'phone',
                    'website'
                ]
            ]
        ]);

        $this->assertEquals(count($arrayContent['data']), 1);
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
    }

    public function testGetPlaceCollectionSearchWithoutFilters()
    {
        $category = factory(PlaceCategory::class)->create();

        factory(Place::class)->create([
            'latitude' => 49.8258,
            'longitude' => 24.0335,
            'category_id' => $category->id,
        ]);

        $response =  $this->actingWithToken()->json(
            'GET',
            "/api/v1/places/search?filter[category]=&filter[location]=&filter[polygon]=&page=1"
        );
        $arrayContent = $response->getOriginalContent();
        $response->assertJsonStructure([
            'data' => [
                0 => [
                    'id',
                    'longitude',
                    'latitude',
                    'zip',
                    'address',
                    'phone',
                    'website'
                ]
            ]
        ]);

        $this->assertEquals(count($arrayContent['data']), 2);
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
    }

    public function testAddTasteToPlace()
    {
        $taste = factory(Taste::class)->create();
        $data = [
            'place_id' => $this->place->id,
            'taste_id' => $taste->id,
        ];
        $response =  $this->actingWithToken()->json(
            'POST',
            "/api/v1/place/add-taste",
            $data
        );

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
        $this->assertDatabaseHas('place_tastes', $data);
    }

    public function testAddTasteToPlaceIfPlaceTasteExist()
    {
        $placeTaste = factory(PlaceTaste::class)->create();
        $data = [
            'place_id' => $placeTaste->place_id,
            'taste_id' => $placeTaste->taste_id,
        ];
        $response =  $this->actingWithToken()->json(
            'POST',
            "/api/v1/place/add-taste",
            $data
        );

        $response->assertStatus(400);
        $response->assertHeader('Content-Type', 'application/json');
    }
}
