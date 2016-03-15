<?php

use FewAgency\FluentHtml\Testing\ComparesFluentHtml;
use FewAgency\FluentForm\FluentForm;

class ControlBlockContainerInlineTest extends PHPUnit_Framework_TestCase
{
    use ComparesFluentHtml;

    public function testInlineForm()
    {
        $form = FluentForm::create()->inline();
        $form->containingInputBlock('test');
        $form->withErrors(['test' => 'error']);

        $this->assertHtmlEquals(
            '<form class="form-block-container form-block-container--inline" method="POST"> <div class="form-block__description" id="test-desc"> <ul class="form-block__messages form-block__messages--error"><li>error</li></ul> </div> <span class="form-block form-block--error"> <span><label class="form-block__label" for="test">Test</label></span> <span> <input name="test" type="text" aria-describedby="test-desc" class="form-block__control" aria-invalid="true" id="test"> </span> </span> </form>',
            $form
        );
    }

    public function testAncestorInline()
    {
        $form = FluentForm::create()->inline();
        $form->withErrors(['field' => 'error']);
        $form->containingInputBlock('test');
        $fieldset = $form->containingFieldset();
        $fieldset->containingInputBlock('field');

        $this->assertContains('<div class="form-block__description" id="field-desc">', (string)$form);
        $this->assertContains('<span', $fieldset->toHtml());
        $this->assertNotContains('<div', $fieldset->toHtml());
    }
}