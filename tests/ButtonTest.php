<?php

use FewAgency\FluentHtml\Testing\ComparesFluentHtml;
use FewAgency\FluentForm\FluentForm;

class ButtonTest extends PHPUnit_Framework_TestCase
{
    use ComparesFluentHtml;

    /**
     * @return \FewAgency\FluentForm\FormBlock\InputBlock
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

    //TODO: test setting name and/or value on button block
}