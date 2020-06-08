<?php


namespace App;

class ContactUs
{
    public $name;
    public $email;
    public $message;
    public $state;
    public $city;
    public $phoneNumber;

    public function __construct($name, $email, $message, $city, $state, $phoneNumber)
    {
        $this->name = $name;
        $this->email = $email;
        $this->message = $message;
        $this->state = $state;
        $this->city = $city;
        $this->phoneNumber = $phoneNumber;
    }
}
