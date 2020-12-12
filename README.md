# tas-wrapper
TelegramApiServer simple API wrapper for easy manage.

### Install 
```bash
composer require aethletic/tas-wrapper
```

### Example

#### Client
All methods from MadelineProto supported, methods list [here](https://docs.madelineproto.xyz/API_docs/methods/).

```php
use TelegramApiServer\Client;

require 'vendor/autoload.php';

$client = new Client([
    'host' => '127.0.0.1',
    'port' => '9503',
    'session' => 'session_name',
]);

$response = $client->get('getSelf'); // GET request
$response = $client->post('getSelf'); // POST request

print_r($response);
```

#### Session
Manage TelegramApiServer session, more detail [here](https://github.com/xtrime-ru/TelegramApiServer#session-management).
```php
use TelegramApiServer\Session;

require 'vendor/autoload.php';

// This is example of default config
// NOTE: If you have the same data, you can skip this
Session::setConfig([
    'host' => '127.0.0.1',
    'port' => '9503',
    'schema' => 'http',
]);

// Get sessions list
$response = Session::list();

// Adding new session
$response = Session::add('session_name');

// Removing session (session file will remain)
$response = Session::remove('session_name');

// Remove session file
// WARNING: Don`t forget to logout and call `removeSession` first!
$response = Session::unlink('session_name');
```
