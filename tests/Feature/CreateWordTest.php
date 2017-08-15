<?php

namespace Tests\Feature;

use App;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateWordTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        $array = ['something' => 'something else'];

        parent::setUp();

        $this->artisan('db:seed');
    }

    /**
     * @test
     * unauthenticated users cannot record new word in database
     */
    public function unauthenticated_users_cannot_record_new_word_in_database()
    {
        $word = factory(App\Word::class)->make();

        $this->post('/words', $word->toArray());
        $this->assertDatabaseMissing('words', [
            'id' => $word->id
        ]);
    }

    /**
     * @test
     * an authenticated user can create word for themselves
     */
    public function an_authenticated_user_can_create_word_for_themselves()
    {
        $this->be(App\User::find(2));

        $word = factory(App\Word::class)->make();

        $this->post('/words', $word->toArray());

        $this->get("/words/{$word->id}")
            ->assertSee($word->spelling);
    }
}
