<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public $user;

    public function singIn($user = null){
        if(!$user){
            $user = factory(User::class)->create();
            $this->actingAs($user);
        }

        $this->user = $user;
        $this->actingAs($this->user);

        return $this;
    }
}
