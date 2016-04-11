<?php
namespace FewAgency\FluentForm;

class FluentForm extends AbstractControlBlockContainer
{
    private $form_method = 'POST';

    /**
     * FluentForm constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->withHtmlElementName('form');
        $this->withAttribute([
            'method' => function (FluentForm $form) {
                return $form->hasMethodGet() ? $form->form_method : 'POST';
            }
        ]);
    }

    /**
     * Static builder for convenience.
     * @return FluentForm
     */
    public static function create()
    {
        return new static();
    }

    /**
     * Set action url on form.
     * @param string|callable|false $url to set as form's action
     * @return $this
     */
    public function withAction($url)
    {
        $this->withAttribute('action', $url);

        return $this;
    }

    /**
     * Set a hidden CSRF token input on the form.
     * @param $token string|callable
     * @param string $name optional name for the token input
     * @return $this
     */
    public function withToken($token, $name = '_token')
    {
        $this->withHiddenInput($name, $token);

        return $this;
    }

    /**
     * Set a hidden REST method input on the form.
     * @param $method string
     * @param string $name optional name for the method input
     * @return $this
     */
    public function withMethod($method, $name = '_method')
    {
        $this->form_method = $method;
        if (!$this->hasMethodGet()) {
            $this->withHiddenInput($name, $method);
        }

        return $this;
    }

    /**
     * Check if form has a specified method set.
     * @param string $method to check for
     * @return bool
     */
    public function hasMethod($method)
    {
        return strtoupper($this->form_method) == strtoupper($method);
    }

    /**
     * Check if method is GET.
     * @return bool true if form's method is GET
     */
    public function hasMethodGet()
    {
        return $this->hasMethod('GET');
    }

    /**
     * Overrides method in AbstractControlBlockContainer.
     * @return $this
     */
    public function getForm()
    {
        return $this;
    }
}