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
through the control block and its block containers up to the form element itself.
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

Subsequent controls are added after another control block using the `followedBy...Block()` methods,
for example `followedByInputBlock($name, $type = 'text')`.

#### Block types available and their parameters:
- `...InputBlock($name, $type = 'text')`
- `...PasswordBlock($name = 'password')`
- `...SelectBlock($name, $options = null)`
- `...MultiSelectBlock($name, $options = null)`
- `...ButtonBlock($button_contents, $type = 'submit')`
- `...CheckboxBlock($name)`

#### Adding control blocks example

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

`withInputValue($value)` is available on most control blocks and will set the underlying input's value directly.

`withInputAttribute($attributes, $value = true)` is available on most control blocks and will set attributes
directly on the underlying input element.

`withDescription($html_contents)` adds descriptive content related to the input using `aria-describedby`.

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

##### Text inputs
`InputBlock($name, $type = 'text')` handles all the text-type inputs specified by `$type`, including `textarea`.

Some types get special treatments:
- `password` won't print the `value` attribute unless you specifically set it on the input element.
- `email` and `tel` have some preset `autocapitalize`, `autocorrect`, and `autocomplete` attributes
that you are free to override using `withInputAttribute()`.

##### Checkboxes
`CheckboxBlock($name)` is a checkbox input with a default `value` attribute of "1". 
`withInputValue($value)` can be used to set a custom `value` on the checkbox.
`checked($checked = true)` and `unchecked()` manipulates the `checked` attribute on the underlying input.
More checkboxes can be added using `withCheckbox($name)` or `containingCheckbox($name)`.
The first checkbox is treated as the block's main input,
extra checkboxes won't have any messages or descriptions displayed automatically.

```php
// Checkboxes
echo FluentForm::create()
    ->containingCheckboxBlock('toc')->required()->unchecked()
    ->withCheckbox('other');
```

```html
<form class="form-block-container" method="POST">
<div class="form-block form-block--required">
<div>
<label>
<input name="toc" type="checkbox" value="1" required>
Toc
</label>
<label>
<input name="other" type="checkbox" value="1" required>
Other
</label>
</div>
</div>
</form>
```

##### Select inputs
`SelectBlock($name, $options = null)` can be easily turned into a multiselect using `multiple($multiple = true)`.
The `$options` (any collection of option display strings keyed by option value)
can be provided on creation or added later through `withOptions($options)`.
`<optgroup>`s can be generated by putting a collection of options keyed by an optgroup label within `$options`.
Options are selected using `withSelectedOptions($options)` and disabled using `withDisabledOptions($options)`.

```php
// Select with optgroup, disabled and selected options
echo FluentForm::create()
    ->containingSelectBlock('pet')->withSelectedOptions('dog')->withDisabledOptions('cat')
    ->withOptions(['cat' => 'Cat', 'Reptiles' => ['turtle' => 'Turtle'], 'dog' => 'Dog']);
```

```html
<form class="form-block-container" method="POST">
<div class="form-block">
<div><label class="form-block__label" for="pet">Pet</label></div>
<div>
<select name="pet" class="form-block__control" id="pet">
<option value="cat" disabled>Cat</option>
<optgroup label="Reptiles"><option value="turtle">Turtle</option></optgroup>
<option value="dog" selected>Dog</option>
</select>
</div>
</div>
</form>
```

##### Buttons
`ButtonBlock($button_contents, $type = 'submit')` is a block containing one button from start.
More buttons can be added using `withButton($button_contents, $type = "submit")` or
`containingButton($button_contents, $type = "submit")`.
The first button is treated as the block's main input,
extra buttons won't have any messages or descriptions displayed automatically.

```php
// Buttons
echo FluentForm::create()
    ->containingButtonBlock('Submit')
    ->withButton('Reset', 'reset');
```

```html
<form class="form-block-container" method="POST">
<div class="form-block">
<div>
<button type="submit">Submit</button>
<button type="reset">Reset</button>
</div>
</div>
</form>
```

### Container options
On a control block container, defaults options can be set that are used for any form controls within that container.

`withValues($map)` adds key-value maps used for populating inputs' values and selected options.
If given a PHP object, input values will be pulled from that object's public properties.
These maps are checked in order from the last to the first added until a matching key is found.
For example you can first set a map of default values, like the currently stored data,
and then add a map containing the user's last input. 

`withLabels($map)` adds key-value maps for populating inputs' labels.

`withErrors($messages)` and `withWarnings($messages)` adds messages keyed by control name.

To set *success*, *disabled*, *readonly*, or *required* states on controls within a container,
use `withSuccess($map)`, `withDisabled($map)`, `withReadonly($map)`, and `withRequired($map)`.
Input to those methods can be strings of control names or key-boolean maps keyed by control name.

```php
// Adding maps to containers
FluentForm::create()
    ->withSuccess('name', 'phone')
    ->withRequired(['name' => true, 'phone' => false]); 
```

To add a hidden input, simply call `withHiddenInput($name, $value = null)`.

#### Laravel example
```php
{{
FluentForm::create()
  // Put the Laravel CSRF token on the form
  ->withToken(csrf_token())
  // Use default values from an Eloquent model, and old user input if flashed into session
  ->withValues($model, old())
   // Add Laravel validation errors to the form
  ->withErrors($errors) 
  // Pick default labels from the validation language file 
  ->withLabels(trans('validation.attributes'))
}}
```

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
