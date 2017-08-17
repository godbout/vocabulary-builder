<?php

namespace Tests\Feature;

use App;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class FlashcardTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->artisan('db:seed', ['--class' => 'UsersTableSeeder']);
    }

    /**
     * @test
     * guests can only receive demo words
     */
    public function guests_can_only_receive_demo_words()
    {
        $demoWord = factory(App\Word::class)->create([
            'user_id'  => 1,
            'mastered' => false,
        ]);

        $user = factory(App\User::class)->create();
        factory(App\Word::class)->create([
            'user_id' => $user->id,
        ], 100);

        for ($i = 0; $i < 20; $i++) {
            $this->get('/flashcards')
                ->assertSee($demoWord->spelling);
        }
    }

    /**
     * @test
     * authenticated users can only receive their own words
     */
    public function authenticated_users_can_only_receive_their_own_words()
    {
        factory(App\Word::class)->create([
            'user_id' => 1,
            'mastered' => false,
        ], 100);

        $this->be($user = factory(App\User::class)->create());

        $word = factory(App\Word::class)->create([
            'user_id'  => $user->id,
            'mastered' => false,
        ]);

        for ($i = 0; $i < 20; $i++) {
            $this->get('/flashcards')
                ->assertSee($word->spelling);
        }
    }

    /**
     * @test
     * authenticated users with no word see a blank page
     */
    public function authenticated_users_with_no_word_see_a_informative_message()
    {
        $this->be(factory(App\User::class)->create());

        $this->get('/flashcards')
            ->assertSee('No words yet? Create some');
    }


    /**
     * @test
     * guests cannot master words
     */
    public function guests_cannot_master_words()
    {
        $demoWord = factory(App\Word::class)->create([
            'mastered' => 0
        ]);

        $this->patch("/words/$demoWord->id");
        $this->assertDatabaseMissing('words', [
            'id' => $demoWord->id,
            'mastered' => 1
        ]);
    }


    /**
     * @test
     * authenticated users can master their own words
     */
    public function authenticated_users_can_master_their_own_words()
    {
        $this->be($user = App\User::find(2));

        $word = factory(App\Word::class)->create([
            'user_id' => $user->id,
            'mastered' => 0
        ]);

        $this->patch("/words/$word->id");
        $this->assertDatabaseHas('words', [
            'id' => $word->id,
            'mastered' => 1
        ]);
    }


    /**
     * @test
     * users cannot master the words of others
     */
    public function users_cannot_master_the_words_of_others()
    {
        $this->be(App\User::find(2));

        $demoWord = factory(App\Word::class)->create([
            'user_id' => 1,
            'mastered' => 0
        ]);

        $this->patch('/words/1');
        $this->assertDatabaseMissing('words', [
            'user_id' => 1,
            'mastered' => 1
        ]);
    }
}
