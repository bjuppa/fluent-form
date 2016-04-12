<?php
require __DIR__ . '/../vendor/autoload.php';

use FewAgency\FluentForm\FluentForm;

echo "\n";

// Generate a simple inline search form
echo FluentForm::create()
    ->inline()
    ->containingInputBlock('search')
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
    ->containingInputBlock('username')
    ->followedByPasswordBlock();

echo "\n\n";