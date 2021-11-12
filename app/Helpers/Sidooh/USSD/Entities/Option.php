<?php

namespace App\Helpers\Sidooh\USSD\Entities;

class Option
{
    public $title;
    public $type;
    public $value;
    public $next;

    public function create($title, $type, $value, $next)
    {
        $this->title = $title;
        $this->type = $type;
        $this->value = $value;
        $this->next = $next;

        return $this;
    }

    public function __toString()
    {
        $str = "{$this->title}\n";
        $str .= "{$this->type}\n";
        $str .= "{$this->value}\n";
        $str .= "{$this->next}\n";

        return $str;
    }
}
