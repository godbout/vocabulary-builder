<?php

namespace Tests\Feature;

use App;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class ViewWordTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->artisan('db:seed');
    }

    /**
     * @test
     * unauthenticated users can only access demo words
     */
    public function unauthenticated_users_can_only_access_demo_words()
    {
        $demoWord = App\Word::find(1);

        $notDemoWord = factory(App\Word::class)->create([
            'user_id' => 2
        ]);

        $this->get($demoWord->path())
            ->assertStatus(200)
            ->assertSee($demoWord->spelling);

        $this->get($notDemoWord->path())
            ->assertRedirect('/words');
    }

    /**
     * @test
     * an authenticated user can only access his own words
     */
    public function an_authenticated_user_can_only_access_his_own_words()
    {
        $user = App\User::find(2);
        $this->be($user);

        $userWord = factory(App\Word::class)->create([
            'user_id' => $user->id,
        ]);

        $demoWord = factory(App\Word::class)->create([
            'user_id' => 1,
        ]);

        $this->get($userWord->path())
            ->assertStatus(200)
            ->assertSee($userWord->spelling);

        $this->get($demoWord->path())
            ->assertRedirect('/words');
    }
}
