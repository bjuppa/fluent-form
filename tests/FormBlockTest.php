<?php

use FewAgency\FluentHtml\Testing\ComparesFluentHtml;
use FewAgency\FluentForm\FluentForm;

class FormBlockTest extends PHPUnit_Framework_TestCase
{
    use ComparesFluentHtml;

    /**
     * @return \FewAgency\FluentForm\FormBlock\InputBlock
     */
    protected function getTestBlock()
    {
        return FluentForm::create()->containingInputBlock('test');
    }

    public function testGetInputElement()
    {
        $b = $this->getTestBlock();

        $this->assertInstanceOf('FewAgency\FluentForm\FormInput\FormInputElement', $b->getInputElement());
    }

    public function testGetLabelElement()
    {
        $b = $this->getTestBlock();

        $this->assertInstanceOf('FewAgency\FluentForm\FormLabel\LabelElement', $b->getLabelElement());
    }
}