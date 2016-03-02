<?php

use FewAgency\FluentForm\FormBlockContainer\FieldsetElement;
use FewAgency\FluentHtml\Testing\ComparesFluentHtml;
use FewAgency\FluentForm\FluentForm;

class FormBlockContainerFieldsetTest extends PHPUnit_Framework_TestCase
{
    use ComparesFluentHtml;

    public function testFieldsetElement()
    {
        $form = FluentForm::create();
        $fieldset = $form->containingFieldset();
        $fieldset->withLegend('legend');
        $fieldset->withInputBlock('test');

        $this->assertContains("<fieldset class=\"form-block-container\">\n<legend>legend</legend>", (string)$form);
    }
}