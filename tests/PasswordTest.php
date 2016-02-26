<?php

use FewAgency\FluentHtml\Testing\ComparesFluentHtml;
use FewAgency\FluentForm\FluentForm;

class PasswordTest extends PHPUnit_Framework_TestCase
{
    use ComparesFluentHtml;

    /**
     * @return \FewAgency\FluentForm\FormBlock\InputBlock
     */
    protected function getTestBlock()
    {
        return FluentForm::create()->containingInputBlock('test', 'password');
    }

    function testPasswordValue()
    {
        $b = $this->getTestBlock()->withInputValue('A');

        $this->assertNotContains('value="', (string)$b);
    }
}