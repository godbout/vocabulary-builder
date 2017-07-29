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
     * unauthenticated users can only see grid of demo words
     */
    public function unauthenticated_users_can_only_see_grid_of_demo_words()
    {
        $demoWord = App\Word::find(1);

        $notDemoWord = factory(App\Word::class)->create([
            'user_id' => 2
        ]);

        $this->get('/words')
            ->assertSee(url($demoWord->path()))
            ->assertDontSee(url($notDemoWord->path()));
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
     * an authenticated user can only see grid of his own words
     */
    public function an_authenticated_user_can_only_see_grid_of_his_own_words()
    {
        $user = App\User::find(2);
        $this->be($user);

        $userWord = factory(App\Word::class)->create([
            'user_id' => $user->id,
        ]);

        $demoWord = factory(App\Word::class)->create([
            'user_id' => 1,
        ]);

        $this->get('/words')
            ->assertSee(url($userWord->path()))
            ->assertDontSee(url($demoWord->path()));
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

    /** 
     * @test
     * searching a term returns words of the user which spelling or excerpt contain the term
     */
    public function searching_a_term_returns_words_of_the_user_which_spelling_or_excerpt_contain_the_term()
    {
        
    }
}
