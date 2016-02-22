<?php

use FewAgency\FluentForm\FormBlockContainer\FieldsetElement;
use FewAgency\FluentHtml\Testing\ComparesFluentHtml;
use FewAgency\FluentForm\FluentForm;

class TextareaTest extends PHPUnit_Framework_TestCase
{
    use ComparesFluentHtml;

    /**
     * @return \FewAgency\FluentForm\FormBlock\InputBlock
     */
    protected function getTestBlock()
    {
        return FluentForm::create()->containingInputBlock('test', 'textarea');
    }

    function testTextareaBlock()
    {
        $b = $this->getTestBlock()->withInputValue('A');

        $this->assertContains('<textarea name="test"', (string)$b);
        $this->assertContains('>A</textarea>', (string)$b);
    }
}