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

    public function testWithMethod()
    {
        $f = FluentForm::create()->withMethod('DELETE');
        $this->assertHtmlEquals('<form method="POST"><input name="_method" type="hidden" value="DELETE"></form>', $f);

        $f = FluentForm::create()->withMethod('put', 'overriden_name');
        $this->assertHtmlEquals(
            '<form method="POST"> <input name="overriden_name" type="hidden" value="put"> </form>',
            $f);
    }

    public function testWithInputBlock()
    {
        $f = FluentForm::create()->withInputBlock('test');
        $this->assertHtmlContentEquals('<div> <label for="test">Test</label> <input name="test" type="text" id="test"> </div>', $f);
    }
}