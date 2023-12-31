# Getting Started

Symfony testing provides [three different ways](https://symfony.com/doc/current/testing.html#types-of-tests) to test
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

## How to write your tests

### Unit Tests

All your tests whatever type they are should extend the `Symblaze\TestPack\TestCase` class. This class extends the
PHPUnit `TestCase` class but adds some extra functionality.

Let's assume you have a service that registers a new user in your application, and you want to test it.

First, you need to extend the `Symblaze\TestPack\TestCase` class.

```php
use Symblaze\TestPack\TestCase;

final class RegisterUserTest extends TestCase
{
    /** @test */
    public function it_registers_a_new_user(): void 
    {
    } 
}
```

Then you need to fake user data and pass it to your service, to do that you can use the `WithFaker` trait.

```php
use Symblaze\TestPack\TestCase;
use Symblaze\TestPack\Concern\WithFaker;

final class RegisterUserTest extends TestCase
{   
    use WithFaker;
    
    /** @test */
    public function it_registers_a_new_user(): void 
    {
       $data = [
              'name' => $this->faker()->name(),
              'email' => $this->faker()->email(),
              'password' => $this->faker()->password(),
        ];
        $sut = new RegisterUserService();
        
        $sut->execute($data);
        
        // Add your assertions here ...
    }   
}
```

This service should store the user in the database, so you need to interact with the Kernel and the database, to do that
you need to use the `KernelTestTrait` trait.

```php
use Symblaze\TestPack\TestCase;
use Symblaze\TestPack\Concern\WithFaker;
use Symblaze\TestPack\KernelTestTrait;

final class RegisterUserTest extends TestCase
{   
    use KernelTestTrait;
    use WithFaker;
    
    /** @test */
    public function it_registers_a_new_user(): void 
    {
       $data = [
              'name' => $this->faker()->name(),
              'email' => $this->faker()->email(),
              'password' => $this->faker()->password(),
        ];
        $sut = new RegisterUserService();
        
        $sut->execute($data);
        
        $this->assertDocumentExists(User::class, ['email' => $data['email']]); // or you can use `assertEntityExists` if you are using Doctrine ORM
    }   
}
```

If your service should fail when the user already exists, so you need to populate the database with a user before
executing the service, to do that you can use the `WithOdmPopulator` in case you are using Doctrine ODM or the
`WithOrmPopulator` in case you are using Doctrine ORM.

```php
use Symblaze\TestPack\TestCase;
use Symblaze\TestPack\Concern\WithFaker;
use Symblaze\TestPack\KernelTestTrait;
use Symblaze\TestPack\Concern\WithOdmPopulator;

final class RegisterUserTest extends TestCase
{   
    use KernelTestTrait;
    use WithFaker;
    use WithOdmPopulator;
    
    /** @test */
    public function it_should_fail_when_the_user_already_exists(): void 
    {
       $data = [
              'name' => $this->faker()->name(),
              'email' => $this->faker()->email(),
              'password' => $this->faker()->password(),
        ];
        $this->populator()->addEntity(User::class, 1, ['email' => $data['email']]);
        $this->populator()->execute();
        $sut = new RegisterUserService();
        
        $this->expectException(UserAlreadyExistsException::class);
        
        $sut->execute($data);
    }
}
```

### Feature Tests

Feature tests (aka: Application tests) are tests that send a request to your application and assert the response.
As mentioned before, you should put your feature tests in the `tests/Feature` directory, and each test class should
extend the `Symblaze\TestPack\TestCase` class, then use the `WebTestTrait` trait.

```php
use Symblaze\TestPack\TestCase;
use Symblaze\TestPack\WebTestTrait;
// ... other imports omitted for brevity

final class LoginByEmailTest extends TestCase
{   
    use WebTestTrait;
    
    /** @test */
    public function it_should_login_a_user(): void 
    {
        // populate the database with a user as we did in the previous example
        
        $this->postJson('/api/v1/login', $loginData);
        
        $this->assertResponseIsOk();
    }     
}
```

> [!NOTE]
> There are many assertions you can use to assert the response.Find more about them in
> the [Assertions](assertions/response.md)

All HTTP methods are supported, `get`, `getJson`, `post`, `postJson`, `put`, `putJson`, and so on. The JSON methods are
meant to send a JSON request body most commonly used in REST APIs.

#### Authenticate Requests

If you need to authenticate the request, you can use the `actAs` method.

```php
    $this->actAs($user)->postJson('/api/v1/posts', $postData);
```
