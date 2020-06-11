<?php


namespace app\Processors;


use app\entities\Screen;

interface ProductInterface
{
    public function process(Screen $previousScreen, Screen $screen);

    public function finalize();
}