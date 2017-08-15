<?php

namespace Tests\Feature;

use App;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class RandomWordsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->artisan('db:seed');
    }

    /**
     * @test
     * the number of returned random words requested by the user is correct
     */
    public function the_number_of_returned_random_words_requested_by_the_user_is_correct()
    {
        /**
         * TODO
         * Should be separated in several test cases
         * If user has less words than asked, then we should show less words
         */
    }

    /**
     * @test
     * guests can only receive demo words
     */
    public function guests_can_only_receive_demo_words()
    {
        $userWord = factory(App\Word::class)->create([
            'user_id' => 2,
        ]);

        $this->get('/random?count=70')
            ->assertDontSee(url($userWord->path()));
    }

    /**
     * @test
     * authenticated users can only receive their own words
     */
    public function authenticated_users_can_only_receive_their_own_words()
    {
        $demoWords = App\User::find(1)->words;

        $this->be(App\User::find(2));

        $response = $this->get('/random');

        foreach ($demoWords as $demoWord) {
            $response->assertDontSee(url($demoWord->path()) . '"');
        }
    }

    /**
     * @test
     * authenticated users with no word see a blank page
     */
    public function authenticated_users_with_no_word_see_an_informative_message()
    {
        $this->be($user = factory(App\User::class)->create());

        $this->get('/random')
            ->assertSee('No words yet? Create some');
    }
}
