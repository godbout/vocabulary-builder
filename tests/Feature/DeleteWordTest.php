<?php

namespace Tests\Feature;

use App;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DeleteWordTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->artisan('db:seed');
    }

    /**
     * @test
     * guest users cannot delete words
     */
    public function guest_users_cannot_delete_words_from_database()
    {
        $word = App\Word::find(1);

        $this->delete("/words/{$word->id}", $word->toArray());

        $this->assertDatabaseHas('words', ['id' => 1]);
    }

    /**
     * @test
     * authenticated users can delete their own words
     */
    public function authenticated_users_can_delete_their_own_words()
    {
        $this->be($user = factory(App\User::class)->create());

        $word = factory(App\Word::class)->create([
            'user_id' => $user->id
        ]);

        $this->delete("/words/{$word->id}");

        $this->assertDatabaseMissing('words', ['id' => $word->id]);
    }

    /**
     * @test
     * a user cannot delete a word that doesnt belong to them
     */
    public function a_user_cannot_delete_a_word_that_doesnt_belong_to_them()
    {
        $this->withExceptionHandling();

        $userWord = factory(App\Word::class)->create([
            'user_id' => 2
        ]);

        $this->delete("/words/{$userWord->id}");
        $this->assertDatabaseHas('words', ['id' => $userWord->id]);

        $this->be(factory(App\User::class)->create());
        $this->delete("/words/{$userWord->id}")
            ->assertStatus(404);
        $this->assertDatabaseHas('words', ['id' => $userWord->id]);

        $this->be(App\User::find(2));
        $demoWord = factory(App\Word::class)->create([
            'user_id' => 1
        ]);
        $this->delete("/words/{$demoWord->id}");
        $this->assertDatabaseHas('words', ['id' => $demoWord->id]);
    }
}
