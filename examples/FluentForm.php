<?php
require __DIR__ . '/../vendor/autoload.php';

use FewAgency\FluentForm\FluentForm;

echo "\n";

// Generate a simple inline search form
echo FluentForm::create()
    ->inline()
    ->containingInputBlock('query', 'search')
    ->followedByButtonBlock('Search!');

echo "\n\n";

// Login form with error messages and some customizations
echo FluentForm::create()
    ->withAction('/auth/login')
    ->withValues(['username' => 'abc123'])
    ->withErrors(['username' => 'Must be a valid email address', 'toc' => 'You have to agree'])
    ->withRequired('username', 'password', 'toc')
    ->containingInputBlock('username', 'email')
    ->followedByPasswordBlock()->withLabel('Your password')
    ->followedByCheckboxBlock('toc')->withLabel('I agree')
    ->followedByButtonBlock('Log in!');

echo "\n\n";

// Form with options
echo FluentForm::create()
    ->withAction('/login')
    ->withMethod('DELETE')
    ->withToken('12345');

echo "\n\n";

// Form with controls
echo FluentForm::create()
    ->containingInputBlock('username')->withLabel('Your username')
    ->followedByPasswordBlock()->withLabel('Your password');

echo "\n\n";

// Element with description
echo FluentForm::create()
    ->containingInputBlock('name')->withDescription('Your full name');

echo "\n\n";

// Element with error message
echo FluentForm::create()
    ->containingInputBlock('name')->withError('Must not contain numbers');

echo "\n\n";

// Checkboxes
echo FluentForm::create()
    ->containingCheckboxBlock('toc')->required()->unchecked()
    ->withCheckbox('other');

echo "\n\n";

// Select with optgroup, disabled and selected options
echo FluentForm::create()
    ->containingSelectBlock('pet')->withSelectedOptions('dog')->withDisabledOptions('cat')
    ->withOptions(['cat' => 'Cat', 'Reptiles' => ['turtle' => 'Turtle'], 'dog' => 'Dog']);

echo "\n\n";

// Buttons
echo FluentForm::create()
    ->containingButtonBlock('Submit')
    ->withButton('Reset', 'reset');

echo "\n\n";

// Adding maps to containers
FluentForm::create()
    ->withSuccess('name', 'phone')
    ->withRequired(['name' => true, 'phone' => false]);

echo "\n\n";

// Fieldset
echo FluentForm::create()
    ->containingFieldset()->withLegend('A Group')
    ->containingInputBlock('inside')
    ->getFormBlockContainer()
    ->followedByInputBlock('outside');

echo "\n\n";