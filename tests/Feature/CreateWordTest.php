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
        $this->be($user = App\User::find(2));

        $word = factory(App\Word::class)->make([
            'user_id' => $user->id,
            'spelling' => 'hello',
        ]);

        $this->post('/words', $word->toArray());

        $this->get($word->path())
            ->assertSee($word->spelling);
    }

    /**
     * @test
     * a word requires a spelling
     */
    public function a_word_requires_a_spelling()
    {
        $this->createWord([
            'spelling' => null
        ])->assertSessionHasErrors('spelling');
    }

    /**
     * @test
     * a word requires a meaning
     */
    public function a_word_requires_a_meaning()
    {
        $this->createWord([
            'meaning' => null
        ])->assertSessionHasErrors('meaning');
    }

    public function createWord($attributes)
    {
        $this->withExceptionHandling()->be($user = App\User::find(2));

        $word = factory(App\Word::class)->raw($attributes);

        return $this->post('/words', $word);
    }

    /**
     * @test
     * form field is prefilled with latest word data if any
     */
    public function form_field_is_prefilled_with_latest_word_data_if_any()
    {
        $word = factory(App\Word::class)->create(['user_id' => 1]);
        $this->get('/words/create')
            ->assertViewHas('lastFrom', $word->from);

        $newUser = factory(App\User::class)->create();
        $this->be($newUser);

        $this->get('/words/create')
            ->assertViewHas('lastFrom', null);

        $newUserWord = factory(App\Word::class)->create(['user_id' => $newUser->id]);
        $this->get('/words/create')
            ->assertViewHas('lastFrom', $newUserWord->from);
    }

    /**
     * @test
     * a unique slug is created when a word is recorded
     */
    public function a_unique_slug_is_created_when_a_word_is_created()
    {
        $this->be(App\User::find(2));

        $word = factory(App\Word::class)->make([
            'spelling' => "trompe l'oeil",
        ]);

        $this->post('/words', $word->toArray());
        $this->assertDatabaseHas('words', ['slug' => 'trompe-loeil']);

        $this->post('/words', $word->toArray());
        $this->assertDatabaseHas('words', ['slug' => 'trompe-loeil-2']);

        $this->post('/words', $word->toArray());
        $this->assertDatabaseHas('words', ['slug' => 'trompe-loeil-3']);
    }
}
