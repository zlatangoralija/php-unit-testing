<?php

namespace Tests\Feature;

use App\MailTracking;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class EmailTest extends TestCase
{
    use MailTracking;

    public function testEmailCanBeSent(){
        Mail::raw('Test email', function ($message){
            $message->to('foo@bar.com');
            $message->from('bar@foo.com');
        });

        Mail::raw('Test email', function ($message){
            $message->to('foo@bar.com');
            $message->from('bar@foo.com');
        });

        $this->seeEmailWasSent()
            ->seeEmailSent(2)
            ->seeEmailTo('foo@bar.com')
            ->seeEmailFrom('bar@foo.com')
            ->seeBodyEquals('Test email')
            ->seeEmailContains('Test');

        //this->seeEmailWasNotSent();
    }
}
