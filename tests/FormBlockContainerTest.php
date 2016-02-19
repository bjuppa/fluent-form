<?php

use FewAgency\FluentHtml\Testing\ComparesFluentHtml;
use FewAgency\FluentForm\FluentForm;

class FormBlockContainerTest extends PHPUnit_Framework_TestCase
{
    use ComparesFluentHtml;

    public function testValues()
    {
        $c = FluentForm::create();

        $c->withValues(['a' => 'A', 'b' => 'B']);

        $this->assertEquals('A', $c->getValue('a'));
        $this->assertNull($c->getValue('c'));
    }

    public function testValuesWithObject() {
        //TODO: implement test
    }

    public function testValuesWithArrayable() {
        //TODO: implement test
    }

    public function testValuesWithDotNotation() {
        //TODO: implement test
    }

    public function testValuesFromParentContainer() {
        //TODO: implement test with multi-level of form block containers, i.e. a fieldset
    }
}