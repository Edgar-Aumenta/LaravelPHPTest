<?php

namespace App;


class CRMAuth
{
    public $TechnicianKey;
    public $Password;

    public function __construct($key, $pass)
    {
        $this->TechnicianKey = $key;
        $this->Password = $pass;
    }
}
