<?php

use FewAgency\FluentHtml\Testing\ComparesFluentHtml;
use FewAgency\FluentForm\FluentForm;

class SelectTest extends PHPUnit_Framework_TestCase
{
    use ComparesFluentHtml;

    /**
     * @return \FewAgency\FluentForm\SelectBlock
     */
    protected function getTestBlock()
    {
        return FluentForm::create()->containingSelectBlock('A');
    }

    function testSelectBlock()
    {
        $b = $this->getTestBlock();
        $b->withOptions(['a' => 'A', 'b' => 'B']);
        $b->withSelectedOptions(['a', 'b']);

        $this->assertFalse($b->isOptionSelected('a'));
        $this->assertTrue($b->isOptionSelected('b'));
        $this->assertHtmlEquals(
            '<form class="form-block-container" method="POST"> <div class="form-block"> <div> <label class="form-block__label" for="A">A</label> </div> <div> <select name="A" class="form-block__control" id="A"> <option value="a">A</option><option value="b" selected>B</option> </select> </div> </div> </form>',
            $b
        );
    }

    function testOptgroup()
    {
        $b = $this->getTestBlock();
        $b->withOptions(['a' => 'A', 'Label' => ['b' => 'B'], 'c' => 'C']);

        $this->assertContains("</option>\n<optgroup label=\"Label\"><option value=\"b\">B</option></optgroup>\n<option", (string)$b);
    }

    //TODO: test disabled options on block

    //TODO: test disabled options on container

}