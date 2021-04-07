<?php

namespace Tests\Integration;

use App\Post;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Tests\TestCase;

class LikesTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setup();
        $this->singIn();
        $this->post = factory(Post::class)->create(['user_id' => $this->user->id]);
    }

    public function testAUserCanLikeAPost(){
        $this->post->like();

        //Verify that the user indeed liked a test
        $this->assertDatabaseHas('likes',[
            'user_id' => $this->user->id,
            'likeable_id' => $this->post->id,
            'likeable_type' => get_class($this->post),
        ]);

        $this->assertTrue($this->post->isLiked());
    }

    public function testAUserCanUnlikeAPost(){
        $this->post->like();
        $this->post->unlike();

        //Verify that the user indeed liked a test
        $this->assertDatabaseMissing('likes',[
            'user_id' => $this->user->id,
            'likeable_id' => $this->post->id,
            'likeable_type' => get_class($this->post),
        ]);

        $this->assertFalse($this->post->isLiked());
    }

    public function testAUserCanToggleAPostLikeStatus(){
        $this->post->toggle();
        $this->assertTrue($this->post->isLiked());

        $this->post->toggle();
        $this->assertFalse($this->post->isLiked());
    }

    public function testAPostKnowsHowManyLikesItHas(){
        $this->post->toggle();
        $this->assertEquals(1, $this->post->likesCount);
    }
}
