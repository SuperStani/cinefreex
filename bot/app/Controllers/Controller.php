<?php

namespace superbot\App\Controllers;

abstract class Controller {
    public function callAction($method, array $params) {
        $this->user->update();
        return $this->{$method}(...array_values($params));
    }
}