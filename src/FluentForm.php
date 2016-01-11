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
                return $form->form_method == 'GET' ? $form->form_method : 'POST';
            }
        ];
        parent::__construct($html_element_name, $tag_contents, $tag_attributes);
    }

    /**
     * @param string|callable $url to set as form's action
     */
    public function withAction($url)
    {
        $this->withAttribute('action', $url);
    }

    /*
TODO: implement these methods on FluentForm
->withToken(token, name=_token)
->withMethod(method, name=_method) sets hidden REST method if needed
    */
}