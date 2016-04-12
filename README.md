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
`FluentForm::create()` is the base for a new form.

Keep in mind most methods accept collections and closures as parameters
as in any [`fewagency/fluent-html` usage](https://github.com/fewagency/fluent-html#usage).

Depending on where you want the html output you may `echo FluentForm::create();`
or render it using string conversion `(string)FluentForm::create()`.

Within [Blade](http://laravel.com/docs/blade) templates the html will be rendered if placed in echo-tags:
`{{ FluentForm::create() }}`.
Check out the
[Blade documentation of `fewagency/fluent-html`](https://github.com/fewagency/fluent-html#usage-with-blade-templates).

### Convenience methods on forms
`withAction($url)` sets the `action` attribute of the `<form>`.

`withMethod($method, $name = '_method')` changes the `method` attribute on the `<form>` (default is `POST`).
If `$method` is not `GET` or `POST` this will help creating form method spoofing using a hidden input,
which is useful for those `PUT`, `PATCH`, or `DELETE` actions.

`withToken($token, $name = '_token')` adds a hidden token input for your CSRF-protection.

```php
// Form with options
echo FluentForm::create()
    ->withAction('/login')
    ->withMethod('DELETE')
    ->withToken('12345');
```

```html
<form class="form-block-container" method="POST" action="/login">
<input name="_method" type="hidden" value="DELETE">
<input name="_token" type="hidden" value="12345">
</form>
```

Any other desired attributes or behaviour on the form element can be set using
[`FluentHtml`'s standard methods](https://github.com/fewagency/fluent-html#methods-reference)
like `withAttribute()` and `withClass()`. 

### Add form controls
The first control on a form (or other container) is added with one of the `containing...Block()` methods,
for example `containingInputBlock($name, $type = 'text')`.
This call will return the new block so you can chain any methods modifying the block directly afterwards.

Subsequent controls are added after a block using the `followedBy...Block()` methods,
for example `followedByInputBlock($name, $type = 'text')`.

```php
// Form with controls
echo FluentForm::create()
    ->containingInputBlock('username')->withLabel('Your username')
    ->followedByPasswordBlock()->withLabel('Your password');
```

```html
<form class="form-block-container" method="POST">
<div class="form-block">
<div>
<label class="form-block__label" for="username2">Your username</label>
</div>
<div>
<input name="username" type="text" class="form-block__control" id="username2">
</div>
</div>
<div class="form-block">
<div><label class="form-block__label" for="password2">Your password</label></div>
<div>
<input name="password" type="password" class="form-block__control" id="password2">
</div>
</div>
</form>
```

#### Common control block options
`withLabel($html_contents)` adds contents to the control block's labeling element.
If not called, the default label will be based on the input's name.

`withDescription($html_contents)` adds descriptive content related to an input using `aria-describedby`.

```php
// Element with description
echo FluentForm::create()
    ->containingInputBlock('name')->withDescription('Your full name');
```

```html
<for class="form-block-container" method="POST">
<div class="form-block">
<div><label class="form-block__label" for="name">Name</label></div>
<div>
<input name="name" type="text" aria-describedby="name-desc" class="form-block__control" id="name">
</div>
<div class="form-block__description" id="name-desc">Your full name</div>
</div>
</form>
```

`disabled($disabled = true)`, `readonly($readonly = true)`, and `required($required = true)`
sets an attribute on the form control and a css class on the control block.

`withSuccess($has_success = true)` sets a css class on the control block element.

`withError($messages)` and `withWarning($messages)`
put message lists in the input's descriptive element and a css class on the control block.
Added error messages also sets the `aria-invalid` attribute on the input element.

```php
// Element with error message
echo FluentForm::create()
    ->containingInputBlock('name')->withError('Must not contain numbers');
```

```html
<form class="form-block-container" method="POST">
<div class="form-block form-block--error">
<div><label class="form-block__label" for="name2">Name</label></div>
<div>
<input name="name" type="text" aria-describedby="name2-desc" class="form-block__control" aria-invalid="true" id="name2">
</div>
<div class="form-block__description" id="name2-desc">
<ul class="form-block__messages form-block__messages--error">
<li>Must not contain numbers</li>
</ul>
</div>
</div>
</form>
```

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
