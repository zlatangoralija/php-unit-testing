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
        $this->user = factory(User::class)->create();
        $this->post = factory(Post::class)->create(['user_id' => $this->user->id]);
    }

    public function testAUserCanLikeAPost(){


        //Set authenticated user in the test
        $this->actingAs($this->user);

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
        //Set authenticated user in the test
        $this->actingAs($this->user);

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

        //Set authenticated user in the test
        $this->actingAs($this->user);

        $this->post->toggle();
        $this->assertTrue($this->post->isLiked());

        $this->post->toggle();
        $this->assertFalse($this->post->isLiked());
    }

    public function testAPostKnowsHowManyLikesItHas(){
        //Set authenticated user in the test
        $this->actingAs($this->user);

        $this->post->toggle();
        $this->assertEquals(1, $this->post->likesCount);
    }
}
