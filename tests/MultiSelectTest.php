<?php

use FewAgency\FluentHtml\Testing\ComparesFluentHtml;
use FewAgency\FluentForm\FluentForm;

class MultiSelectTest extends PHPUnit_Framework_TestCase
{
    use ComparesFluentHtml;

    /**
     * @return \FewAgency\FluentForm\SelectBlock
     */
    protected function getTestBlock()
    {
        $f = FluentForm::create();
        $f->idRegistrar(new \FewAgency\FluentHtml\HtmlIdRegistrar());

        return $f->containingMultiSelectBlock('A');
    }

    function testMultiSelectBlock()
    {
        $b = $this->getTestBlock();
        $b->withOptions(['a' => 'A', 'b' => 'B']);
        $b->withSelectedOptions(['a', 'b']);

        $this->assertTrue($b->isOptionSelected('a'));
        $this->assertTrue($b->isOptionSelected('b'));
        $this->assertHtmlEquals(
            '<form class="form-block-container" method="POST"> <div class="form-block"> <div> <label class="form-block__label" for="A">A</label> </div> <div> <select name="A[]" class="form-block__control" multiple id="A"> <option value="a" selected>A</option><option value="b" selected>B</option> </select> </div> </div> </form>',
            $b
        );
    }

}