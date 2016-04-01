<?php
namespace FewAgency\FluentForm\Support;

interface CheckableControlContract
{
    /**
     * Make input selected.
     * @param bool|callable $checked
     * @return $this
     */
    public function checked($checked = true);

    /**
     * Make input not selected.
     * @return $this
     */
    public function unchecked();

    /**
     * Check if input is selected.
     * @return bool
     */
    public function isChecked();
}