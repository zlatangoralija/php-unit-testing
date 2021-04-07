<?php

namespace Tests\Integration;

use App\Article;
use App\Team;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TeamTest extends TestCase
{
    use DatabaseTransactions;

    public $team;
    public $team2;
    public $team3;
    public $user;
    public $user2;
    public $user3;
    public $users;
    public $users2;

    public function setUp(): void
    {
        parent::setup();
        $this->team = factory(Team::class)->create();
        $this->team2 = factory(Team::class)->create(['size' => 2]);
        $this->team3 = factory(Team::class)->create(['size' => 3]);
        $this->user = factory(User::class)->create();
        $this->user2 = factory(User::class)->create();
        $this->user3 = factory(User::class)->create();
        $this->users = factory(User::class, 2)->create();
        $this->users2 = factory(User::class, 3)->create();
    }

    public function testATeamHasAName()
    {
        $this->assertIsString($this->team->name);
    }

    public function testATeamCanAddMembers(){
        $this->team->add($this->user);
        $this->team->add($this->user2);
        $this->assertEquals(2, $this->team->count());
    }

    public function testATeamHasMaximumSize(){
        $this->team2->add($this->user);
        $this->team2->add($this->user2);

        $this->assertEquals(2, $this->team2->count());

        //Asserting that the exception will be thrown. Making sure that beyond this point, exception will be thrown.
        $this->expectException('Exception');
        $this->team2->add($this->user3);
    }

    public function testATeamCanAddMultipleMembers(){
        $this->team->add($this->users);

        $this->assertEquals(2, $this->team->count());
    }

    public function testATeamCanRemoveMember(){
        $this->team->add($this->user);
        $this->team->add($this->user2);

        $this->team->removeMember($this->user);

        $this->assertEquals(1, $this->team->count());
    }

    public function testATeamCanRemoveAllMembers(){
        $this->team->add($this->user);
        $this->team->add($this->user2);
        $this->team->add($this->user3);

        $this->team->removeMembers();

        $this->assertEquals(0, $this->team->count());
    }

    public function testATeamCanRemoveMoreThanOneMemberAtOnce(){
        $this->team3->add($this->users2);

        $this->team3->removeMembers($this->users2->slice(0, 2));

        $this->assertEquals(1, $this->team3->count());
    }

    public function testWhenAddingManyMembersAtOnceYouStillMayNotExceedTheTeamMaximumSize(){
        $this->expectException('Exception');
        $this->team2->add($this->users2);
    }
}
