<?php


namespace App;


use Illuminate\Support\Facades\Mail;

trait MailTracking
{
    protected $emails = [];

    //before notation means that this method will be run before the test is run
    /** @before */
    public function setUpMailTracking(): void
    {
        parent::setUp();
        Mail::getSwiftMailer()
            ->registerPlugin(new TestingMailEventListener($this));
    }

    public function seeEmailWasSent(){
        $this->assertNotEmpty(
            $this->emails,
            'No emails have been sent'
        );

        return $this;
    }

    public function seeEmailSent($count){
        $emailsSent = count($this->emails);
        $this->assertCount(
            $count, $this->emails,
            'Expected ' .$count . ' emails to have been sent, but ' . $emailsSent . ' was/were.'
        );

        return $this;
    }

    public function seeEmailWasNotSent(){

        $this->assertEmpty(
            $this->emails,
            'Did not expect any emails to have been sent'
        );

        return $this;
    }

    public function seeEmailTo($mailTo, \Swift_Message $message = null){
        $this->assertArrayHasKey(
            $mailTo, $this->getEmail($message)->getTo(),
            'No email was sent to ' . $mailTo
        );

        return $this;
    }

    public function seeEmailFrom($mailFrom, \Swift_Message $message = null){
        $this->assertArrayHasKey(
            $mailFrom, $this->getEmail($message)->getFrom(),
            'No email was sent from ' . $mailFrom
        );

        return $this;
    }

    public function seeBodyEquals($body, \Swift_Message $message = null){
        $this->assertEquals(
            $body, $this->getEmail($message)->getBody(),
            'No email was sent with provided body'
        );

        return $this;
    }

    public function seeEmailContains($body, \Swift_Message $message = null){
        $this->assertStringContainsString(
            $body, $this->getEmail($message)->getBody(),
            'No email containing the provided body was found'
        );

        return $this;
    }

    public function getEmail(\Swift_Message $message = null){
        $this->seeEmailWasSent();
        return $message ?: $this->lastEmail();
    }

    public function lastEmail(){
        return end($this->emails);
    }


    public function addEmail(\Swift_Message $email){
        $this->emails[] = $email;
    }
}

class TestingMailEventListener implements \Swift_Events_EventListener
{
    protected $test;
    public function __construct($test)
    {
        $this->test = $test;
    }

    public function beforeSendPerformed($event){
        $this->test->addEmail($event->getMessage());
    }
}

