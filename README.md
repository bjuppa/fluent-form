# [Fluent interface](https://en.wikipedia.org/wiki/Fluent_interface) HTML form builder for PHP
An extension to [fluent-html](https://github.com/fewagency/fluent-html)
for building accessible, well-formated, yet customizable HTML forms.

```php
// Generate a simple inline search form
echo FluentForm::create()
    ->inline()
    ->containingInputBlock('search')
    ->followedByButtonBlock('Search!');
```

```html
<form class="form-block-container form-block-container--inline" method="POST">
<span class="form-block">
<span><label class="form-block__label" for="search">Search</label></span>
<span>
<input name="search" type="text" class="form-block__control" id="search">
</span>
</span>
<span class="form-block">
<span><button type="submit">Search!</button></span>
</span>
</form>
```

* [Installation](#installation--configuration)
* [Principles](#principles)
* [Usage](#usage)
* [Authors - FEW Agency](#authors)
* [License](#license)

## Installation & configuration
> composer require fewagency/fluent-form

### Optional facades
You may add [Laravel facades](http://laravel.com/docs/facades) in the `aliases` array of your project's
`config/app.php` configuration file:

```php
'FluentForm'  => FewAgency\FluentForm\Facades\FluentForm::class,
```

## Principles
A `FluentForm` consists of [*control blocks*](src/AbstractControlBlock.php),
grouped within [*control block containers*](src/AbstractControlBlockContainer.php).
The base `FluentForm` element is such a container together with `FieldsetElement`, an example of a nested container.
`InputBlock` and `CheckboxBlock` are examples of control blocks, each block basically consisting of an input, its label, 
and any messages or hints describing that input.

Many properties can be set on the container level, affecting the form controls within that container.
Properties are first checked on an individual element and if not specified there we check upwards in the html tree,
through the form block and its block containers up to the form element itself.
This makes it easy to set and override properties in sections of a form.

Naming principles are based upon
[those of the base-package `fewagency/fluent-html`](https://github.com/fewagency/fluent-html#naming-principles).
Some examples of methods in this package returning a new element relative the current one are
the `containing...Block()` methods on control block containers, and `followedBy...Block()` methods on control blocks. 

## Usage
`FluentForm::create()` is the base for starting a new form.
Depending on where you want the html output you may `echo FluentForm::create();`
or convert it to `(string)FluentForm::create()`.

Within [Blade](http://laravel.com/docs/blade) templates the html will be rendered if placed in echo-tags:
`{{ FluentForm::create() }}`.
More info in the
[Blade documentation of `fewagency/fluent-html`](https://github.com/fewagency/fluent-html#usage-with-blade-templates).

### Options on a form
`withAction($url)`
`withMethod($method, $name = '_method')`
`withToken($token, $name = '_token')`

Any other desired attributes or behaviour on the form element can be set using
[`FluentHtml`'s standard methods](https://github.com/fewagency/fluent-html#methods-reference)
like `withAttribute()` and `withClass()`. 

### Add form controls
`containing...Block()` `containingInputBlock($name, $type = 'text')`
`followedBy...Block()` `followedByInputBlock($name, $type = 'text')`

#### Common control block options
`withLabel($html_contents)`
`withDescription($html_contents)`
`disabled($disabled = true)`
`readonly($readonly = true)`
`required($required = true)`
`withError($messages)`
`withWarning($messages)`
`withSuccess($has_success = true)`

#### Control types and options
`InputBlock`
`CheckboxBlock`
`SelectBlock`
`ButtonBlock`

### Container options
`withValues($map)`
`withLabels($map)`
`withErrors($messages)`
`withWarnings($messages)`
`withSuccess($map)`
`withDisabled($map)`
`withReadonly($map)`
`withRequired($map)`
`withHiddenInput($name, $value = null)`

#### Container layout
`inline($inline = true)`
`aligned($align = true)`
`withAlignmentClasses($classes1, $classes2, $classes3, $offset_classes2, $offset_classes3 = null)`

#### Nested containers
`containingFieldset()` `followedByFieldset()`

## Authors
I, Björn Nilsved, work at the largest communication agency in southern Sweden.
We call ourselves [FEW](http://fewagency.se) (oh, the irony).
From time to time we have positions open for web developers and programmers in the Malmö/Copenhagen area,
so please get in touch!

## License
The FEW Agency Fluent HTML form builder is open-sourced software licensed under the
[MIT license](http://opensource.org/licenses/MIT)
