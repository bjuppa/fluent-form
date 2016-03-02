<?php

use FewAgency\FluentHtml\Testing\ComparesFluentHtml;
use FewAgency\FluentForm\FluentForm;

class FormBlockTest extends PHPUnit_Framework_TestCase
{
    use ComparesFluentHtml;

    /**
     * @return \FewAgency\FluentForm\FormBlock\InputBlock
     */
    protected function getTestBlock()
    {
        return FluentForm::create()->containingInputBlock('test');
    }

    public function testGetInputElement()
    {
        $b = $this->getTestBlock();

        $this->assertInstanceOf('FewAgency\FluentForm\FormInput\FormInputElement', $b->getInputElement());
    }

    public function testGetLabelElement()
    {
        $b = $this->getTestBlock();

        $this->assertInstanceOf('FewAgency\FluentForm\FormLabel\LabelElement', $b->getLabelElement());
    }

    public function testWithInputAttribute()
    {
        $input = $this->getTestBlock()->withInputAttribute('autocorrect', 'off')->getInputElement();

        $this->assertContains('autocorrect="off"', $input->toHtml());
    }

    public function testGetFormBlockContainer()
    {
        $b = $this->getTestBlock();

        $this->assertInstanceOf('FewAgency\FluentForm\FormBlockContainer\FormBlockContainer',
            $b->getFormBlockContainer());
    }

    public function testWithLabel()
    {
        $b = $this->getTestBlock();
        $b->getForm()->withLabels(['test' => 'Form Label']);
        $b->withLabel('custom label');

        $this->assertContains('>custom label</label>', (string)$b);
    }

    public function testLabelsFromForm()
    {
        $b = $this->getTestBlock();
        $b->getForm()->withLabels(['test' => 'Form Label']);

        $this->assertContains('>Form Label</label>', (string)$b);
    }

    public function testFollowedByInputBlock()
    {
        $b = $this->getTestBlock()->followedByInputBlock('follow');

        $this->assertContains('<input name="test" ', (string)$b);
        $this->assertContains('<input name="follow" ', (string)$b);
    }

    public function testDisabled()
    {
        $b = $this->getTestBlock()->disabled();

        $this->assertContains('<div class="form-block form-block--disabled">', (string)$b);
        $this->assertContains('<input name="test" type="text" class="form-block__control" disabled ', (string)$b);

        $b->withHtmlElementName('fieldset');
        $this->assertContains('<fieldset class="form-block form-block--disabled" disabled>', (string)$b);
    }

    public function testReadonly()
    {
        $b = $this->getTestBlock()->readonly();

        $this->assertContains('<input name="test" type="text" class="form-block__control" readonly ', (string)$b);
    }

    public function testRequired()
    {
        $b = $this->getTestBlock()->required();

        $this->assertContains('<div class="form-block form-block--required">', (string)$b);
        $this->assertContains('<input name="test" type="text" class="form-block__control" required ', (string)$b);
    }

    public function testWithDescription()
    {
        $b = $this->getTestBlock()->withDescription('custom description');

        $this->assertContains('<input name="test" type="text" class="form-block__control" aria-describedby="test10-desc"',
            (string)$b);
        $this->assertContains('<div class="form-block__description" id="test10-desc">custom description</div>',
            (string)$b);
    }

    public function testWithEmptyDescription()
    {
        $b = $this->getTestBlock()->withDescription('');

        $this->assertNotContains('aria-describedby', (string)$b);
    }

    public function testValuesFromForm()
    {
        $b = $this->getTestBlock();
        $b->getForm()->withValues(['test' => 'Form Value']);

        $this->assertContains('value="Form Value"', (string)$b);
    }

    public function testWithInputValue()
    {
        $b = $this->getTestBlock()->withInputValue('Input Value');
        $b->getForm()->withValues(['test' => 'Form Value']);

        $this->assertContains('value="Input Value"', (string)$b);
    }

    public function testErrorsFromForm()
    {
        $b = $this->getTestBlock();
        $b->getForm()->withErrors(['test' => 'Form Error']);

        $this->assertContains('<li>Form Error</li>', (string)$b);
    }

    public function testWithErrors()
    {
        $b = $this->getTestBlock();

        $b->withError('Message A');

        $this->assertContains('<li>Message A</li>', (string)$b);
        $this->assertContains('<ul class="form-block__messages form-block__messages--error">', (string)$b);
        $this->assertContains('<div class="form-block form-block--error">', (string)$b);
        $this->assertContains('aria-invalid="true"', (string)$b);
    }

    public function testWarningsFromForm()
    {
        $b = $this->getTestBlock();
        $b->getForm()->withWarnings(['test' => 'Form Warning']);

        $this->assertContains('<li>Form Warning</li>', (string)$b);
    }

    public function testWithWarnings()
    {
        $b = $this->getTestBlock();

        $b->withWarning('Message A');

        $this->assertContains('<li>Message A</li>', (string)$b);
        $this->assertContains('<ul class="form-block__messages form-block__messages--warning">', (string)$b);
        $this->assertContains('<div class="form-block form-block--warning">', (string)$b);
        $this->assertNotContains('aria-invalid="true"', (string)$b);
    }
}