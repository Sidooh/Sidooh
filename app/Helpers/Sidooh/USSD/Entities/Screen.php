<?php

namespace App\Helpers\Sidooh\USSD\Entities;

class Screen
{

    public string $key = "";
    public string $title;
//    TODO: Does type need instantiation?
    public ?string $type = null;
    public bool $super_product;
    public Option $option;
    public ?string $next;
    public string $option_string;
    public array $options;
    public ?Screen $previous = null;
    public ?string $option_type;

    public function findOption(string $option): ?Option
    {
//        print_r('option search...');

        if (!isset($this->options))
            return null;

        $neededObject = array_filter(
            $this->options,
            function ($e) use (&$option) {
                return $e->value == $option;
            }
        );

        return count($neededObject) > 0 ? reset($neededObject) : null;
    }

//    TODO: To be continued...
    public function __toString()
    {
        $str = "{$this->key}\n";
        $str .= "{$this->title}\n";
//        $str .= "{$this->type}\n";
//        $str .= "{$this->super_product}\n";
//        $str .= "{$this->next}\n";

        return $str;
    }
}
