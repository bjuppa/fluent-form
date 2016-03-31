<?php

use FewAgency\FluentHtml\Testing\ComparesFluentHtml;
use FewAgency\FluentForm\FluentForm;

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
        $b->withInputValue('A');

        $this->assertContains("<div class=\"form-block\">
<div><label class=\"form-block__label\" for=\"test\">Test</label></div>
<div>
<input name=\"test\" type=\"checkbox\" value=\"A\" class=\"form-block__control\" id=\"test\">
</div>
</div>", $b->toHtml());
    }
}