<?php

use FewAgency\FluentHtml\Testing\ComparesFluentHtml;
use FewAgency\FluentForm\FluentForm;

class FluentFormTest extends PHPUnit_Framework_TestCase
{
    use ComparesFluentHtml;

    public function testCreate()
    {
        $f = FluentForm::create();
        $this->assertHtmlEquals('<form method="POST"></form>', $f);
    }

    public function testWithToken()
    {
        $f = FluentForm::create()->withToken('ABC');
        $this->assertHtmlEquals('<form method="POST"><input name="_token" type="hidden" value="ABC"></form>', $f);

        $f = FluentForm::create()->withToken('ABC', 'overriden_name');
        $this->assertHtmlEquals(
            '<form method="POST"> <input name="overriden_name" type="hidden" value="ABC"> </form>',
            $f);
    }

}