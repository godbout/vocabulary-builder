<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class FlashcardTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->artisan('db:seed');
    }

    /**
     * @test
     * guests can only receive demo words
     */
    public function guests_can_only_receive_demo_words()
    {
        /**
         * TODO
         */
    }

    /**
     * @test
     * authenticated users can only receive their own words
     */
    public function authenticated_users_can_only_receive_their_own_words()
    {
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
