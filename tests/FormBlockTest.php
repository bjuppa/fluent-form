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

    public function testWithInputAttribute()
    {
        $input = $this->getTestBlock()->withInputAttribute('autocorrect', 'off')->getInputElement();

        $this->assertContains('autocorrect="off"', $input->toHtml());
    }

    public function testGetFormBlockContainer()
    {
        $b = $this->getTestBlock();

        $this->assertInstanceOf('FewAgency\FluentForm\FormBlockContainer\FormBlockContainer',
            $b->getFormBlockContainer());
    }

    public function testWithLabel()
    {
        $b = $this->getTestBlock()->withLabel('custom label');

        $this->assertContains('>custom label<', $b->getLabelElement()->toHtml());
    }

    public function testFollowedByInputBlock() {
        $b = $this->getTestBlock()->followedByInputBlock('follow');

        $this->assertContains('<input name="test" ', (string)$b);
        $this->assertContains('<input name="follow" ', (string)$b);
    }
}