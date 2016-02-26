<?php

use FewAgency\FluentHtml\Testing\ComparesFluentHtml;
use FewAgency\FluentForm\FluentForm;

class ButtonTest extends PHPUnit_Framework_TestCase
{
    use ComparesFluentHtml;

    /**
     * @return \FewAgency\FluentForm\FormBlock\ButtonBlock
     */
    protected function getTestBlock()
    {
        return FluentForm::create()->containingButtonBlock('A');
    }

    function testButtonBlock()
    {
        $b = $this->getTestBlock();

        $this->assertContains('<button type="submit">A</button>', (string)$b);
    }

    function testButtonName()
    {
        $b = $this->getTestBlock();
        $b->withInputName('test');

        $this->assertContains('name="test"', (string)$b);
    }

    function testButtonValue()
    {
        $b = $this->getTestBlock();
        $b->withInputValue('A');

        $this->assertContains('value="A"', (string)$b);
    }

    function testButtonAttribute()
    {
        $b = $this->getTestBlock();
        $b->withInputAttribute('formmethod', 'GET');

        $this->assertContains('formmethod="GET"', (string)$b);
    }
}