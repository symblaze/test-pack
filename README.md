# Symblaze Test Pack

Whenever you write a new line of code, you should write a test for it. The Symfony test pack is quite good,
but it's not so easy to keep your test suite organized and clean. This package aims to help you with:

1. Organizing your tests in way that mirrors your code structure.
2. Stop thinking about which base class to extend. A single base class to extend for all your tests.
3. A rich set of assertions to make your tests more readable.

## Installation

```bash
composer require --dev symblaze/test-pack
```

## Usage

All your tests should extend the `Symblaze\TestPack\TestCase` class. This class extends the PHPUnit `TestCase` class
but adds some extra functionality.

### Unit Tests

```php
<?php

declare(strict_types=1);

namespace App\Tests;

use Symblaze\TestPack\TestCase;

class ExampleTest extends TestCase
{
    public function testExample(): void
    {
        $this->assertTrue(true);
    }
}
```

### Integration Tests

If your test needs to interact with Symfony's Service Container, all you need is to use the `KernelTestTrait` trait.
Then you have all the same functionality as the `KernelTestCase` class.

```php
namespace App\Tests\Service;

use Symblaze\TestPack\KernelTestTrait;
use Symblaze\TestPack\TestCase;

class NewsletterGeneratorTest extends TestCase
{   
    use KernelTestTrait;
    
    public function testSomething(): void
    {
        self::bootKernel();

        // ...
    }
}
```

### Application Tests

If you need to test the behaviour of your application, send an HTTP request and check the response, you need
to use the `WebTestTrait` trait. Then you have all the same functionality as the `WebTestCase` class.

```php
// tests/Controller/PostControllerTest.php
namespace App\Tests\Controller;

use Symblaze\TestPack\KernelTestTrait;
use Symblaze\TestPack\WebTestTrait;

class PostControllerTest extends TestCase
{   
    use WebTestTrait;

    public function testSomething(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();

        // Request a specific page
        $crawler = $client->request('GET', '/');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello World');
    }
}
```

## License

This package is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
