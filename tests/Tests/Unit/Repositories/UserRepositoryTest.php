<?php

namespace Tests\Unit\Repositories;

use App\Models\Article;
use App\Models\Category;
use App\Models\Episode;
use App\Models\Season;
use App\Models\Show;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * UserRepositoryTest.
 */
class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::createApplication();
        parent::setUp();
    }

    public function testGetByID()
    {
        $users = User::factory()
            ->count(2)
            ->create();
        $want = $users[1];

        $repository = new UserRepository(new User());

        $got = $repository->getByID($want->id);

        $this->assertEquals($want->getAttributes(), $got->getAttributes());
    }

    public function testGetByIDNotFound()
    {
        $repository = new UserRepository(new User());

        $this->expectException(ModelNotFoundException::class);
        $repository->getByID(1);
    }

    public function testGetByUsername()
    {
        $users = User::factory()->count(2)->create();
        $want = $users[1];

        $repository = new UserRepository(new User());

        $got = $repository->getByUsername($want->username);

        $this->assertEquals($want->getAttributes(), $got->getAttributes());
    }

    public function testGetByUsernameNotFound()
    {
        $repository = new UserRepository(new User());

        $this->expectException(ModelNotFoundException::class);
        $repository->getByUsername('abcdef');
    }

    public function testGetByURL()
    {
        $users = User::factory()
            ->count(2)
            ->has(
                Article::factory()
                    ->count(3)
                    ->for(
                        Category::factory()
                    )
            )
            ->create();
        $want = $users[1];

        $repository = new UserRepository(new User());

        $got = $repository->getByURL($want->user_url);

        $this->assertEquals($want->getAttributes(), $got->getAttributes());
        $this->assertCount(2, $got->articles);
    }

    public function testGetByURLNotFound()
    {
        $repository = new UserRepository(new User());

        $this->expectException(ModelNotFoundException::class);
        $repository->getByURL('toto');
    }

    public function testList()
    {
        $users = User::factory()
            ->count(2)
            ->create();
        $want = $users->toArray();

        $repository = new UserRepository(new User());

        $gotUsers = $repository->list();
        $got = json_decode(json_encode($gotUsers->toArray()), true);

        $this->assertEquals(sort($want), sort($got));
    }

    public function testGetEpisodePlanning()
    {
        $user = User::factory()
            ->count(1)
            ->hasAttached(
                Show::factory()
                    ->count(1)
                    ->has(
                        Season::factory()
                            ->count(1)
                            ->has(
                                Episode::factory()
                                    ->count(6)
                                    ->sequence(
                                        [
                                            'diffusion_us' => date_create(),
                                            'diffusion_fr' => date_create(),
                                        ],
                                        [],
                                    )
                            )
                    ),
                ['state' => 1]
            )
            ->create();
        $want = $user[0];

        $repository = new UserRepository(new User());

        $got = $repository->getEpisodePlanning($want->id, 1);

        $this->assertCount(3, $got);
    }
}
