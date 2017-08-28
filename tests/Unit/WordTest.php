<?php

namespace Tests\Unit;

use App;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class WordTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * @test
     * a word has an owner
     */
    public function a_word_has_an_owner()
    {
        $word = factory(App\Word::class)->create();

        $this->assertInstanceOf(App\User::class, $word->owner);
    }
}
