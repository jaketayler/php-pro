<?php

namespace app\controllers;

class Home{
    public function index($params){
        return [
            'view' => 'home',
            'data' => ['name' => 'Thainã']
        ];
    }
}