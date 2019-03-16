<?php

namespace components;

use lib\DB;

abstract class Model
{
    public $auth;

    public function __construct()
    {
        $this->auth = new \Delight\Auth\Auth(DB::getDbh());
    }

    public function isLoggedIn()
    {
        return $this->auth->isLoggedIn();
    }
}
