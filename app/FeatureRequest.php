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

    public function __construct($pmSerial, $issue, $contactName, $contactPhone, $contactEmail, $storeName)
    {
        $this->pmSerial = $pmSerial;
        $this->issue = $issue;
        $this->contactName = $contactName;
        $this->contactPhone = $contactPhone;
        $this->contactEmail = $contactEmail;
        $this->storeName = $storeName;
    }
}
