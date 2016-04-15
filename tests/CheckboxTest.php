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
        return FluentForm::create()->containingCheckboxBlock('test');
    }

    function testCheckboxInputBlock()
    {
        $b = $this->getTestBlock();

        $this->assertContains("<div class=\"form-block\">
<div>
<div class=\"form-block__checkbox-wrapper\">
<label>
<input name=\"test\" type=\"checkbox\" value=\"1\">
Test
</label>
</div>
</div>
</div>", $b->toHtml());
    }

    function testWithLabel()
    {
        $b = $this->getTestBlock();

        $this->assertContains("Test\n</label>", (string)$b);

        $b->getControlBlockContainer()->withLabels(['test' => 'C']);

        $this->assertNotContains("Test", (string)$b);
        $this->assertContains('C', (string)$b);

        $b->withLabel('L');

        $this->assertNotContains('C', (string)$b);
        $this->assertContains('L', (string)$b);
    }

    function testCheckedCheckbox()
    {
        $b = $this->getTestBlock();
        $b->getControlBlockContainer()->withValues(['test' => 'on']);

        $this->assertContains('checked', (string)$b);
    }

    function testCheckboxWithValue()
    {
        $b = $this->getTestBlock();
        $b->getControlBlockContainer()->withValues(['test' => 'on']);
        $b->withInputValue('other');

        $this->assertNotContains('checked', (string)$b);
    }
}