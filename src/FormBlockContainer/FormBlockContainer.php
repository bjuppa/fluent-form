<?php
namespace FewAgency\FluentForm\FormBlockContainer;

use FewAgency\FluentHtml\FluentHtml;
use FewAgency\FluentForm\Support\FormElementContract;
use FewAgency\FluentForm\FormInput\HiddenInputElement;

abstract class FormBlockContainer extends FluentHtml implements FormElementContract
{
    protected $is_aligned;
    protected $alignment_classes;
    protected $alignment_classes_default = [1 => 'half-width float-left align-right', 2 => 'half-width', 3 => ''];
    protected $alignment_offset_classes;
    protected $alignment_offset_classes_default = [2 => 'half-width half-margin-left', 3 => ''];

    public function withHiddenInput($name, $value)
    {
        $this->withContent(HiddenInputElement::create($name, $value));
    }

    /* TODO: implement these methods on FormBlockContainer
->getForm()
->withAlignmentClasses(col 1, col 2, col 3, offset 2, offset 3=null)
->getAlignmentClasses(column number, bool with_offset=false)
->align(true)
->isAligned()
->withValues(object or array)
->withValues(overriding values)
->withErrors(messages)
->withWarnings(messages)
->with…Block(name, type)
->with…Blocks(array of input names and types)
->containing…Block(name)->withLabel(text)->followedBy…Block()
     */
}