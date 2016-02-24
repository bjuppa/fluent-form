<?php namespace FewAgency\FluentForm\Facades;

use Illuminate\Support\Facades\Facade;

class FluentForm extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'FewAgency\FluentForm\FluentForm';
    }
}