<?php

use FewAgency\FluentHtml\Testing\ComparesFluentHtml;
use FewAgency\FluentForm\FluentForm;

// These are tests for simple checkbox inputs in standard InputBlock

class CheckboxTest extends PHPUnit_Framework_TestCase
{
    use ComparesFluentHtml;

    /**
     * @return \FewAgency\FluentForm\InputBlock
     */
    protected function getTestBlock()
    {
        return FluentForm::create()->containingInputBlock('test', 'checkbox');
    }

    function testCheckboxInputBlock()
    {
        $b = $this->getTestBlock();

        $this->assertContains("<div class=\"form-block\">
<div><label class=\"form-block__label\" for=\"test\">Test</label></div>
<div>
<input name=\"test\" type=\"checkbox\" value=\"1\" class=\"form-block__control\" id=\"test\">
</div>
</div>", $b->toHtml());
    }

    function testCheckedCheckbox()
    {
        $b = $this->getTestBlock();
        $b->getFormBlockContainer()->withValues(['test' => 'on']);

        $this->assertContains('checked', (string)$b);
    }

    function testCheckboxWithValue()
    {
        $b = $this->getTestBlock();
        $b->getFormBlockContainer()->withValues(['test' => 'on']);
        $b->withInputValue('other');

        $this->assertNotContains('checked', (string)$b);
    }
}