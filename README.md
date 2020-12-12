# tas-wrapper
TelegramApiServer simple API wrapper for easy manage.

### Install 
```bash
composer require aethletic/tas-wrapper
```

### Example
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
