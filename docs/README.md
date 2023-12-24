# Getting Started

Symfony testings provides [three different ways](https://symfony.com/doc/current/testing.html#types-of-tests) to test
your application depending on what you want to test. Unit tests, integration tests and application tests.

Symblaze Test Pack does not change this functionality, but it provides a better way to organize your tests, make them
more readable and easier to write through a library of custom assertions, and helper methods.

## How to organize your tests

Assuming you are putting your tests in the `tests` directory, your tests should mirror your code structure. For example:

```
src
├── Application
│   └── Auth
│       └── LoginByEmail.php
├── Domain
│   └── Document
│       └── User.php
├── Foundation
│   └── Security
│       ├── Auth
│       │   ├── Password.php
│       │   └── PasswordInterface.php
│       └── Random
│           └── Randomizer.php
└── Kernel.php
```

Your tests should be organized like this:

```
tests
├── Application
│   └── Auth
│       └── LoginByEmailTest.php
├── Domain
│   └── Document
│       └── UserTest.php
├── Foundation
│   └── Security
│       ├── Auth
│           └── PasswordTest.php
│       └── Random
│           └── RandomizerTest.php
|── Feature // Feature tests (Lists all the features of your application)
│   ├── LoginByEmailTest.php 
│   └── RegisterUserTest.php
|   └── CreatePostTest.php
|   └── UpdatePostTest.php
|   └── ...
```

If you created a new class `App\Domain\Document\User`, you should create a new test
class `App\Tests\Domain\Document\UserTest`. If you created a new class `App\Foundation\Security\Auth\Password`, you
should create a new test class `App\Tests\Foundation\Security\Auth\PasswordTest` and so on.

Besides that, you can also create a directory to test your application features `App\Tests\Feature` and put all your
feature tests there, where each test class represents a feature of your application that sends a request to your
application and asserts the response.
