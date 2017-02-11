## HtTextin

This stands for **HTML Text Input**. It's a library that catters for generating "one-line" text fields through a standard API which provides utilities for data formatting, processing and much more.

This is the first concrete implementation of the `HtWidget` class. You can [click here](https://github.com/flsouto/htwidget) and read more about it in order to better understand the whole philosophy.

## Installation

Run composer:
```
composer require flsouto/httextin
```



## Usage
By default, the textin widget is rendered in writable mode which will expect input from the user:

```php
<?php
use FlSouto\HtTextin;
require_once('vendor/autoload.php');

$field = new HtTextin('email');
$field->context(['email'=>'user@domain.com']);

echo $field;
```

Outputs:

```html

<div class="widget 589f735d7ab67" style="display:block">
 <input name="email" value="user@domain.com" />
 <div style="color:yellow;background:red" class="error">
 </div>
</div>

```

### Changing to Readonly Mode

```php
use FlSouto\HtTextin;
require_once('vendor/autoload.php');

$field = new HtTextin('email');
$field->readonly(true);

echo $field;
```

Outputs:

```html

<div class="widget 589f735d7c63b" style="display:block">
 <input name="email" value="" readonly="readonly" />
 <div style="color:yellow;background:red" class="error">
 </div>
</div>

```


To turn readonly off and go back to writable:

```php
use FlSouto\HtTextin;

$field = new HtTextin('email');
$field->readonly(true);
$field->readonly(false);

echo $field;
```

Outputs:

```html

<div class="widget 589f735d7cb2c" style="display:block">
 <input name="email" value="" />
 <div style="color:yellow;background:red" class="error">
 </div>
</div>

```

### Set size attribute

```php

$field = new HtTextin('email');
$field->size(40);

echo $field;
```

Outputs:

```html

<div class="widget 589f735d7d012" style="display:block">
 <input name="email" size="40" value="" />
 <div style="color:yellow;background:red" class="error">
 </div>
</div>

```

### Set placeholder attribute

```php

$field = new HtTextin('email');
$field->size(40)->placeholder("eg: user@domain.com");

echo $field;
```

Outputs:

```html

<div class="widget 589f735d7d4d2" style="display:block">
 <input name="email" size="40" value="" />
 <div style="color:yellow;background:red" class="error">
 </div>
</div>

```

### Using a formatter
The `fromatter` method allows you to format the value that is pulled from the context for showing on the input field:

```php

$field = new HtTextin('price');
$field->formatter(function($value){
	return '$'.number_format((float)$value, 2, '.',',');
});

$field->context(['price'=>30.9]);

echo $field;
```

Outputs:

```html

<div class="widget 589f735d7d9c7" style="display:block">
 <input name="price" value="$30.90" />
 <div style="color:yellow;background:red" class="error">
 </div>
</div>

```

### Using filters
The `filters` method returns an object which allows you to add filters for processing incoming data.
While `formatter` will be applied only when the widget is rendered, `filters` are always applied, às soon as the 
the `$field->value()` method gets called: 

```php

$field = new HtTextin('price');
$field->filters()->strip('$')->replace(',','.')->trim();
$field->context(['price'=>'$ 30,90']);

echo $field->value();
```

Outputs:

```html
30.90
```

### Validation
Validation constraints are added through the same `filters` api:

```php

$field = new HtTextin('amount');
$field->filters()->maxval(10, "Cannot exceed 10.");
$field->context(['amount'=>15]);
$field->error(true); // activates error reporting on the UI

echo $field;
```

Outputs:

```html

<div class="widget 589f735d7e48a" style="display:block">
 <input name="amount" value="" />
 <div style="color:yellow;background:red" class="error">
    Cannot exceed 10.
 </div>
</div>

```

**Notice:** For more information about the `filters` api, please referer to [this documentation](https://github.com/flsouto/param/#paramfilters)
