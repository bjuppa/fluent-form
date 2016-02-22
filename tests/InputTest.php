<?php

use FewAgency\FluentForm\FormBlockContainer\FieldsetElement;
use FewAgency\FluentHtml\Testing\ComparesFluentHtml;
use FewAgency\FluentForm\FluentForm;

class InputTest extends PHPUnit_Framework_TestCase
{
    use ComparesFluentHtml;

    /**
     * @return \FewAgency\FluentForm\FormBlock\InputBlock
     */
    protected function getTestBlock()
    {
        return FluentForm::create()->containingInputBlock('test');
    }

    function testDisabled()
    {
        $input = $this->getTestBlock()->getInputElement();

        $this->assertFalse($input->isDisabled());

        $input->disabled();

        $this->assertTrue($input->isDisabled());
        $this->assertContains(' disabled ', (string)$input);
    }

    function testRequired()
    {
        $input = $this->getTestBlock()->getInputElement();

        $this->assertFalse($input->isRequired());

        $input->required();

        $this->assertTrue($input->isRequired());
        $this->assertContains(' required ', (string)$input);
    }
}