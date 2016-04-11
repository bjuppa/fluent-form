# [Fluent interface](https://en.wikipedia.org/wiki/Fluent_interface) HTML form builder for PHP
An extension to [fluent-html](https://github.com/fewagency/fluent-html)
for building accessible, well-formated, yet customizable HTML forms.

```php
// Generate a simple search form
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
`FluentForm`s are built up by [*control blocks*](src/AbstractControlBlock.php),
grouped within [*control block containers*](src/AbstractControlBlockContainer.php).
The base `FluentForm` element is such a container together with `FieldsetElement`, an example of a nested container.
`InputBlock` and `CheckboxBlock` are examples of control blocks, each block basically consisting of an input, its label, 
and any messages or hints describing it.

Many properties can be set on the container level, affecting the form controls within that container.
Properties are first checked on an individual element and if not specified there we check upwards in the html tree,
through the form block and its block containers up to the form element itself.
This makes it easy to set and override properties in sections of a form.

Naming principles are based upon
[those of the base-package `fewagency/fluent-html`](https://github.com/fewagency/fluent-html#naming-principles).
Some examples of methods in this package returning a new element relative the current one are
the `containing...Block()` methods on control block containers, and `followedBy...Block()` methods on control blocks. 

## Usage
TODO: document usage

### Start a form

### Add form controls

#### Form control types and options

### Options on containers

## Authors
I, Björn Nilsved, work at the largest communication agency in southern Sweden.
We call ourselves [FEW](http://fewagency.se) (oh, the irony).
From time to time we have positions open for web developers and programmers in the Malmö/Copenhagen area,
so please get in touch!

## License
The FEW Agency Fluent HTML form builder is open-sourced software licensed under the
[MIT license](http://opensource.org/licenses/MIT)
