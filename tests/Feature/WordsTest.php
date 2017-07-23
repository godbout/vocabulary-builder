<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WordsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->artisan('db:seed');
    }

    /** 
     * @test
     * unauthenticated users can see demo words
     */
    public function unauthenticated_users_can_only_see_and_access_demo_words()
    {
        $this->get('/words')
            ->assertSee(url('/words/1'))
            ->assertDontSee(url('/words/70'));

        $this->get('/words/1')
            ->assertStatus(200);

        $extraWord = factory(App\Word::class)->create([
            'user_id' => 2,
        ]);

        $this->get("/words/{$extraWord->id}")
            ->assertStatus(403);
    }

    /** 
     * @test
     * an authenticated user can only see his own words
     */
    public function an_authenticated_user_can_only_see_and_access_his_own_words()
    {
        $this->be(App\User::find(2));

        $word = factory(App\Word::class)->create([
            'user_id' => 2,
        ]);

        $this->get('/words')
            ->assertSee(url("/words/{$word->id}"))
            ->assertDontSee(url('/words/1'));

        $this->get("/words/{$word->id}")
            ->assertStatus(200);
            
        $this->get('/words/1')
            ->assertStatus(403);
    }

    /** 
     * @test
     * searching a term returns words of the user which spelling or excerpt contain the term
     */
    public function searching_a_term_returns_words_of_the_user_which_spelling_or_excerpt_contain_the_term()
    {
        
    }
}
