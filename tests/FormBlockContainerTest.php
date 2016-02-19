<?php

use FewAgency\FluentHtml\Testing\ComparesFluentHtml;
use FewAgency\FluentForm\FluentForm;

class FormBlockContainerTest extends PHPUnit_Framework_TestCase
{
    use ComparesFluentHtml;

    public function testValuesWithAssociativeArray()
    {
        $c = FluentForm::create();

        $c->withValues(['a' => 'A', 'b' => 'B']);

        $this->assertEquals('A', $c->getValue('a'));
        $this->assertNull($c->getValue('c'));
    }

    public function testValuesWithIndexedArray()
    {
        $c = FluentForm::create();

        $c->withValues(['A', 'B']);

        $this->assertEquals('A', $c->getValue(0));
        $this->assertEquals('B', $c->getValue('1'));
        $this->assertNull($c->getValue('c'));
    }

    public function testValuesWithObject()
    {
        $c = FluentForm::create();

        $array = ['a' => 'A', 'b' => 'B'];
        $object = (object)$array;
        $c->withValues($object);

        $this->assertEquals('A', $c->getValue('a'));
        $this->assertNull($c->getValue('c'));
    }

    public function testValuesWithArrayable()
    {
        $c = FluentForm::create();

        $arrayable = new \Illuminate\Support\MessageBag(['a' => 'A', 'b' => 'B']);
        $c->withValues($arrayable);

        //Must check for numeric key as MessageBag turns all entries into an array
        $this->assertEquals('A', $c->getValue('a.0'));
        $this->assertNull($c->getValue('c'));
    }

    public function testValuesWithDotNotation()
    {
        $c = FluentForm::create();

        $c->withValues(['a' => ['b' => 'C']]);

        $this->assertEquals('C', $c->getValue('a.b'));
        $this->assertNull($c->getValue('a.c'));
    }

    public function testValuesFromParentContainer()
    {
        //TODO: implement test with multi-level of form block containers, i.e. a fieldset
    }
}