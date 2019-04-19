<?php

namespace DavidMorenoCortina\DependencyContainer;


use ArrayAccess;

class Container implements ArrayAccess {
    protected $dependencies;

    protected $initialized;

    public function __construct(array $settings = []) {
        $this->dependencies = [];
        $this->initialized = [];

        if(!is_array($settings)){
            $settings = [];
        }

        $this['settings'] = function () use($settings){
            return $settings;
        };
    }

    public function offsetSet($key, $value) {
        $this->dependencies[$key] = $value;
    }

    public function offsetGet($key) {
        if(!array_key_exists($key, $this->initialized)){
            $this->initialized[$key] = $this->dependencies[$key]($this);
        }
        return $this->initialized[$key];
    }

    public function offsetExists($key) {
        return array_key_exists($key, $this->dependencies);
    }

    public function offsetUnset($key) {
        unset($this->dependencies[$key]);
        if(array_key_exists($key, $this->initialized)){
            unset($this->initialized[$key]);
        }
    }
}