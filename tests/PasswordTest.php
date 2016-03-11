<?php

use FewAgency\FluentHtml\Testing\ComparesFluentHtml;
use FewAgency\FluentForm\FluentForm;

class PasswordTest extends PHPUnit_Framework_TestCase
{
    use ComparesFluentHtml;

    /**
     * @return \FewAgency\FluentForm\InputBlock
     */
    protected function getTestBlock()
    {
        return FluentForm::create()->containingPasswordBlock('test');
    }

    function testPasswordValue()
    {
        $b = $this->getTestBlock()->withInputValue('A');

        $this->assertContains('name="test"', (string)$b);
        $this->assertContains('type="password"', (string)$b);
        $this->assertNotContains('value="', (string)$b);
    }
}