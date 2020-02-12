<?php


namespace App;


class RequestMoreInfo
{
    public $name;
    public $email;
    public $phoneNumber;
    public $storeName;
    public $address;
    public $city;
    public $state;
    public $zipCode;
    public $currentSoftware;
    public $requestPMTrial;
    public $storeStatus;
    public $comments;

    public function __construct($name, $email, $phoneNumber, $storeName, $address, $city, $state, $zipCode, $currentSoftware, $requestPMTrial, $storeStatus, $comments)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->storeName = $storeName;
        $this->address = $address;
        $this->city = $city;
        $this->state = $state;
        $this->zipCode = $zipCode;
        $this->currentSoftware = $currentSoftware;
        $this->requestPMTrial = $requestPMTrial;
        $this->storeStatus = $storeStatus;
        $this->comments = $comments;
    }
}
