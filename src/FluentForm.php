<?php
namespace FewAgency\FluentForm;

use FewAgency\FluentForm\FormBlockContainer\FormBlockContainer;

class FluentForm extends FormBlockContainer
{
    protected $form_method = 'POST';

    public function __construct()
    {
        $html_element_name = 'form';
        $tag_contents = null;
        $tag_attributes = [
            'method' => function (FluentForm $form) {
                return $form->hasMethodGet() ? $form->form_method : 'POST';
            }
        ];
        parent::__construct($html_element_name, $tag_contents, $tag_attributes);
    }

    /**
     * Set action url on form
     * @param string|callable|false $url to set as form's action
     */
    public function withAction($url)
    {
        $this->withAttribute('action', $url);
    }

    /**
     * Check if form has a specified method set
     * @param string $method to check for
     * @return bool
     */
    public function hasMethod($method)
    {
        return strtoupper($this->form_method) == strtoupper($method);
    }

    /**
     * Check if method is GET
     * @return bool true if form's method is GET
     */
    public function hasMethodGet()
    {
        return $this->hasMethod('GET');
    }

    /*
TODO: implement these methods on FluentForm
->withToken(token, name=_token)
->withMethod(method, name=_method) sets hidden REST method if needed
    */
}