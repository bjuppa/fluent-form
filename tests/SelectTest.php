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
        $f = FluentForm::create();
        $f->idRegistrar(new \FewAgency\FluentHtml\HtmlIdRegistrar());

        return $f->containingSelectBlock('A');
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

    function testSelectedOptionsOnContainer()
    {
        $b = $this->getTestBlock();
        $b->withOptions(['a' => 'A', 'b' => 'B']);
        $b->getControlBlockContainer()->withValues(['A' => 'b']);

        $this->assertNotTrue($b->isOptionSelected('a'));
        $this->assertTrue($b->isOptionSelected('b'));

        $b->withSelectedOptions(null);

        $this->assertFalse($b->isOptionSelected('a'));
        $this->assertFalse($b->isOptionSelected('b'));
    }

    function testOptgroup()
    {
        $b = $this->getTestBlock();
        $b->withOptions(['a' => 'A', 'Label' => ['b' => 'B'], 'c' => 'C']);

        $this->assertContains("</option>\n<optgroup label=\"Label\"><option value=\"b\">B</option></optgroup>\n<option",
            (string)$b);
    }

    function testDisabledOptionsOnBlock()
    {
        $b = $this->getTestBlock();
        $b->withOptions(['a' => 'A', 'b' => 'B']);
        $b->withDisabledOptions('b');

        $this->assertNotContains('<option value="a" disabled>', (string)$b);
        $this->assertContains('<option value="b" disabled>', (string)$b);
    }

    function testDisabledOptionsOnContainer()
    {
        $b = $this->getTestBlock();
        $b->withOptions(['a' => 'A', 'b' => 'B']);
        $b->getControlBlockContainer()->withDisabled('A.b');

        $this->assertNotTrue($b->isOptionDisabled('a'));
        $this->assertTrue($b->isOptionDisabled('b'));
    }

}