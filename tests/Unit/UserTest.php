<?php

namespace Tests\Unit;

use App;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * a user may have words
     */
    public function a_user_may_have_words()
    {
        $user = factory(App\User::class)->create();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->words);
    }

    /**
     * @test
     * a user can add words
     */
    public function a_user_can_add_words()
    {
        $user = factory(App\User::class)->create();

        $user->addWord([
            'spelling' => 'some spelling',
            'meaning' => 'some meaning',
            'excerpt' => '',
            'from' => '',
        ]);

        $this->assertCount(1, $user->words);
    }
}
