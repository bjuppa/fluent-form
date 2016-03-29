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
        $b->selected(['a', 'b']);

        $this->assertFalse($b->isSelected('a'));
        $this->assertTrue($b->isSelected('b'));
        $this->assertHtmlEquals(
            '<form class="form-block-container" method="POST"> <div class="form-block"> <div> <label class="form-block__label" for="A">A</label> </div> <div> <select name="A" class="form-block__control" id="A"> <option value="a">A</option><option value="b" selected>B</option> </select> </div> </div> </form>',
            $b
        );
    }

    //TODO: test optgroups

    //TODO: test disabled options on block

    //TODO: test disabled options on container

}