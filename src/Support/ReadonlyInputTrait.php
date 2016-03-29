<?php
namespace FewAgency\FluentForm\Support;

trait ReadonlyInputTrait
{
    /**
     * Make this input readonly
     * @param bool|callable $readonly
     * @return $this
     */
    public function readonly($readonly = true)
    {
        $this->withAttribute('readonly', $readonly);

        return $this;
    }
}