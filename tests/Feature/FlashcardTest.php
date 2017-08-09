<?php

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
        $this->be($user = factory(App\User::class)->create());

        $this->get('/flashcards')
            ->assertSee('No words yet? Create some');
    }
}
