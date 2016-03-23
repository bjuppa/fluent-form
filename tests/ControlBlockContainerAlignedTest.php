<?php

use FewAgency\FluentHtml\Testing\ComparesFluentHtml;
use FewAgency\FluentForm\FluentForm;

class ControlBlockContainerAlignedTest extends PHPUnit_Framework_TestCase
{
    use ComparesFluentHtml;

    /**
     * @return FluentForm
     */
    protected function getTestForm()
    {
        $form = FluentForm::create();
        $form->idRegistrar(new \FewAgency\FluentHtml\HtmlIdRegistrar());

        return $form->aligned();
    }

    public function testAlignedForm()
    {
        $form = $this->getTestForm();
        $form->containingInputBlock('test');
        $form->withErrors(['test' => 'error']);

        $this->assertHtmlEquals(
            '<form class="form-block-container form-block-container--aligned" method="POST">
              <div class="form-block form-block--aligned form-block--error">
                <span class="form-block__align1">
                  <label class="form-block__label" for="test">Test</label>
                </span>
                <span class="form-block__align2">
                  <input name="test" type="text" aria-describedby="test-desc" class="form-block__control" aria-invalid="true" id="test">
                </span>
                <div class="form-block__description form-block__align3" id="test-desc">
                  <ul class="form-block__messages form-block__messages--error">
                    <li>error</li>
                  </ul>
                </div>
              </div>
            </form>',
            $form
        );
    }

    public function testAncestorAligned()
    {
        $form = $this->getTestForm();
        $form->withErrors(['field' => 'error']);
        $form->containingInputBlock('test');
        $fieldset = $form->containingFieldset();
        $fieldset->containingInputBlock('field');

        $this->assertContains('<fieldset class="form-block-container form-block-container--aligned">', $fieldset->toHtml());
        $this->assertContains('<span class="form-block__align1">', $fieldset->toHtml());
        $this->assertContains('<span class="form-block__align2">', $fieldset->toHtml());
        $this->assertContains(
            '<div class="form-block__description form-block__align3" id="field-desc">',
            $fieldset->toHtml()
        );
    }
}