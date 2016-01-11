<?php

use FewAgency\FluentHtml\Testing\ComparesFluentHtml;
use FewAgency\FluentForm\FluentForm;

class FluentFormTest extends PHPUnit_Framework_TestCase
{
    use ComparesFluentHtml;

    public function testConstructor()
    {
        $f = new FluentForm();
        $this->assertHtmlEquals('<form method="POST"></form>', $f);
    }
}