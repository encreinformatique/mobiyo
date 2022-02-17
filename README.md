# Mobiyo library

This library allows the use of composer and project management dependencies.
 
We needed a proper code that can be shared easily between our projects instead of the example code of Mobiyo.

## Installation

This library is available on Packagist.

### Step 1

Add the package using composer.

```composer require encreinformatique/mobiyo```

### Step 2

```php
use EncreInformatique\Mobiyo\Client;
use EncreInformatique\Mobiyo\Payload;

...

$client = new Client($login, $password);
$payload = new Payload($numero_sql);

$number = $client->getNumber($payload);
```
