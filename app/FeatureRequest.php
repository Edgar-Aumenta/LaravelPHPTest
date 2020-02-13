<?php


namespace App;


class FeatureRequest
{
    public $pmSerial;
    public $requestedFeature;
    public $contactName;
    public $contactPhone;
    public $contactEmail;
    public $storeName;

    public function __construct($pmSerial, $requestedFeature, $contactName, $contactPhone, $contactEmail, $storeName)
    {
        $this->pmSerial = $pmSerial;
        $this->requestedFeature = $requestedFeature;
        $this->contactName = $contactName;
        $this->contactPhone = $contactPhone;
        $this->contactEmail = $contactEmail;
        $this->storeName = $storeName;
    }
}
