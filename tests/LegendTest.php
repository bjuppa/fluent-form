<?php

use FewAgency\FluentHtml\Testing\ComparesFluentHtml;
use FewAgency\FluentForm\FluentForm;

class LegendTest extends PHPUnit_Framework_TestCase
{
    use ComparesFluentHtml;

    /**
     * @expectedException     Exception
     */
    public function testPrecededBy()
    {
        $legend = new \FewAgency\FluentForm\LegendElement();

        $legend->precededBy('A');
    }

    /**
     * @expectedException     Exception
     */
    public function testPrecededByElement()
    {
        $legend = new \FewAgency\FluentForm\LegendElement();

        $legend->precededByElement('p', 'A');
    }

    /**
     * @expectedException     Exception
     */
    public function testInsertIntoNonFieldset()
    {
        $legend = new \FewAgency\FluentForm\LegendElement();

        \FewAgency\FluentHtml\FluentHtml::create('div', $legend);
    }
}