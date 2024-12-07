<?php

namespace App\Helpers\Sidooh\USSD;

use App\Helpers\Sidooh\USSD\Entities\Option;
use App\Helpers\Sidooh\USSD\Entities\Screen;
use Karriere\JsonDecoder\Bindings\ArrayBinding;
use Karriere\JsonDecoder\Bindings\FieldBinding;
use Karriere\JsonDecoder\ClassBindings;
use Karriere\JsonDecoder\Transformer;

class ScreenTransformer implements Transformer
{
    public function register(ClassBindings $classBindings)
    {
        $classBindings->register(new ArrayBinding('options', 'options', Option::class));
        $classBindings->register(new FieldBinding('option', 'option', Option::class));
        $classBindings->register(new FieldBinding('previous', 'previous', Screen::class));
    }

    public function transforms()
    {
        return Screen::class;
    }
}
