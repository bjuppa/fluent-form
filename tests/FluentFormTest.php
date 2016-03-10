<?php

use FewAgency\FluentHtml\Testing\ComparesFluentHtml;
use FewAgency\FluentForm\FluentForm;

class FluentFormTest extends PHPUnit_Framework_TestCase
{
    use ComparesFluentHtml;

    /**
     * @return FluentForm
     */
    protected function getTestForm()
    {
        return FluentForm::create();
    }

    public function testCreate()
    {
        $f = $this->getTestForm();
        $this->assertHtmlEquals('<form class="form-block-container" method="POST"></form>', $f);
    }

    public function testWithToken()
    {
        $f = $this->getTestForm()->withToken('ABC');
        $this->assertHtmlEquals('<form class="form-block-container" method="POST"> <input name="_token" type="hidden" value="ABC"> </form>',
            $f);

        $f = $this->getTestForm()->withToken('ABC', 'overriden_name');
        $this->assertHtmlEquals(
            '<form class="form-block-container" method="POST"> <input name="overriden_name" type="hidden" value="ABC"> </form>',
            $f);
    }

    public function testWithMethod()
    {
        $f = $this->getTestForm()->withMethod('DELETE');
        $this->assertHtmlEquals('<form class="form-block-container" method="POST"> <input name="_method" type="hidden" value="DELETE"> </form>',
            $f);

        $f = $this->getTestForm()->withMethod('put', 'overriden_name');
        $this->assertHtmlEquals(
            '<form class="form-block-container" method="POST"> <input name="overriden_name" type="hidden" value="put"> </form>',
            $f);
    }

    public function testWithInputBlock()
    {
        $f = $this->getTestForm()->withInputBlock('test');
        $this->assertHtmlContentEquals('<div class="form-block"> <div><label class="form-block__label" for="test4">Test</label></div> <div> <input name="test" type="text" class="form-block__control" id="test4"> </div> </div>',
            $f);
    }

    public function testContainingInputBlock()
    {
        $block = $this->getTestForm()->containingInputBlock('test');

        $this->assertInstanceOf('FewAgency\FluentForm\FormBlock\InputBlock', $block);
        $this->assertContains('<input name="test" type="text" class="form-block__control"', (string)$block);
        $this->assertContains('<label class="form-block__label"', (string)$block);
    }

    public function testInputNameDotNotation()
    {
        $f = $this->getTestForm()->withInputBlock('test.test');
        $this->assertHtmlContentEquals(
            '<div class="form-block"> <div><label class="form-block__label" for="test.test">Test Test</label></div> <div> <input name="test[test]" type="text" class="form-block__control" id="test.test"> </div> </div>',
            $f);
    }

    public function testWithTelInput()
    {
        $f = $this->getTestForm()->withInputBlock('phone', 'tel');

        $this->assertContains('type="tel"', (string)$f);
        $this->assertContains('autocorrect="off"', (string)$f);
        $this->assertContains('autocomplete="tel"', (string)$f);
    }

    public function testWithEmailInput()
    {
        $f = $this->getTestForm()->withInputBlock('mail', 'email');

        $this->assertContains('type="email"', (string)$f);
        $this->assertContains('autocapitalize="off"', (string)$f);
        $this->assertContains('autocorrect="off"', (string)$f);
        $this->assertContains('autocomplete="email"', (string)$f);
    }
}