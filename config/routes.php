<?php

return [
    'engwo/words/([0-9]+)' => 'main/words/$1',
    'engwo/words' => 'main/words',
    'engwo/ajaxanswer' => 'main/ajaxanswer',
    'engwo/ajax' => 'main/ajax',
    'engwo/testing' => 'main/testing',
    'engwo/dashboard/([0-9]+)/([0-9]+)/([\s\S]*+)' => 'main/dashboard/$1/$2/$3',
    'engwo/dashboard' => 'main/dashboard',
    'engwo/statistics' => 'main/statistics',
    'engwo/add' => 'main/add',
    'engwo/register' => 'auth/register',
    'engwo/login' => 'auth/login',
    'engwo/password/([0-9a-zA-Z]*+)/([0-9a-zA-Z]*+)' => 'auth/password/$1/$2',
    'engwo/password' => 'auth/password',
    'engwo/recovery' => 'auth/recovery',
    'engwo/delete/([0-9]+)' => 'main/delete/$1',
    'engwo/edit/([0-9]+)' => 'main/edit/$1',
    'engwo/edit' => 'main/edit',
    'engwo' => 'main/index',
];