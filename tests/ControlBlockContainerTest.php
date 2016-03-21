<?php

use FewAgency\FluentHtml\Testing\ComparesFluentHtml;
use FewAgency\FluentForm\FluentForm;

class ControlBlockContainerTest extends PHPUnit_Framework_TestCase
{
    use ComparesFluentHtml;

    public function testValuesWithAssociativeArray()
    {
        $c = FluentForm::create();

        $c->withValues(['a' => 'A', 'b' => 'B']);

        $this->assertEquals('A', $c->getValue('a'));
        $this->assertNull($c->getValue('c'));
    }

    public function testValuesWithIndexedArray()
    {
        $c = FluentForm::create();

        $c->withValues(['A', 'B']);

        $this->assertEquals('A', $c->getValue(0));
        $this->assertEquals('B', $c->getValue('1'));
        $this->assertNull($c->getValue('c'));
    }

    public function testValuesWithObject()
    {
        $c = FluentForm::create();

        $array = ['a' => 'A', 'b' => 'B'];
        $object = (object)$array;
        $c->withValues($object);

        $this->assertEquals('A', $c->getValue('a'));
        $this->assertNull($c->getValue('c'));
    }

    public function testValuesWithArrayable()
    {
        $c = FluentForm::create();

        $arrayable = new \Illuminate\Support\MessageBag(['a' => 'A', 'b' => 'B']);
        $c->withValues($arrayable);

        //Must check for numeric key as MessageBag turns all entries into an array
        $this->assertEquals('A', $c->getValue('a.0'));
        $this->assertNull($c->getValue('c'));
    }

    public function testValuesWithDotNotation()
    {
        $c = FluentForm::create();

        $c->withValues(['a' => ['b' => 'C']]);

        $this->assertEquals('C', $c->getValue('a.b'));
        $this->assertNull($c->getValue('a.c'));
    }

    public function testGetValueFromAncestor()
    {
        $form = FluentForm::create();
        $fieldset = $form->containingFieldset();

        $form->withValues(['a' => 'formA', 'b' => 'formB']);
        $fieldset->withValues(['b' => 'fieldsetB']);

        $this->assertEquals('formA', $fieldset->getValue('a'));
        $this->assertEquals('fieldsetB', $fieldset->getValue('b'));
    }

    public function testWithErrors()
    {
        $c = FluentForm::create();

        $c->withErrors(['test' => ['Message A', 'Message B']]);

        $this->assertEquals(['Message A', 'Message B'], $c->getErrors('test'));
        $this->assertEquals([], $c->getErrors('name'));
    }

    public function testWithSingleError()
    {
        $c = FluentForm::create();

        $c->withErrors(['test' => 'Message A']);

        $this->assertEquals(['Message A'], $c->getErrors('test'));
    }

    public function testWithErrorFromAncestor()
    {
        $form = FluentForm::create();
        $fieldset = $form->containingFieldset();

        $form->withErrors(['test' => ['Message Form']]);
        $fieldset->withErrors(['test' => ['Message Fieldset']]);

        $this->assertEquals(['Message Fieldset', 'Message Form'], $fieldset->getErrors('test'));
    }

    public function testWithSuccess()
    {
        $c = FluentForm::create();

        $c->withSuccess(
            'test',
            'before',
            function () {
                return [
                    'true' => true,
                    'false' => false,
                ];
            },
            [
                'closure.true' => function () {
                    return true;
                },
                'closure.false' => function () {
                    return false;
                },
                'dot' => ['notation' => true],
                'before' => false,
                'after' => false,
            ],
            'after'
        );

        $this->assertTrue($c->hasSuccess('true'));
        $this->assertFalse($c->hasSuccess('before'));
        $this->assertTrue($c->hasSuccess('true'));
        $this->assertFalse($c->hasSuccess('false'));
        $this->assertTrue($c->hasSuccess('closure.true'));
        $this->assertFalse($c->hasSuccess('closure.false'));
        $this->assertTrue($c->hasSuccess('dot.notation'));
        $this->assertTrue($c->hasSuccess('after'));
    }

    public function testWithSuccessFromAncestor() {
        $form = FluentForm::create();
        $fieldset = $form->containingFieldset();

        $form->withSuccess('form');
        $fieldset->withSuccess('fieldset');

        $this->assertTrue($fieldset->hasSuccess('form'));
        $this->assertTrue($fieldset->hasSuccess('fieldset'));
    }

    public function testWithLabels()
    {
        $form = FluentForm::create();
        $fieldset = $form->containingFieldset();

        $form->withLabels(['test' => 'Form Label']);

        $this->assertEquals('Form Label', $fieldset->getLabel('test'));

        $fieldset->withLabels(['test' => 'Fieldset Label']);

        $this->assertEquals('Fieldset Label', $fieldset->getLabel('test'));
    }

}