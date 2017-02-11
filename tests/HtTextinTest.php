<?php

use PHPUnit\Framework\TestCase;

#mdx:h use
use FlSouto\HtTextin;

#mdx:h al
require_once('vendor/autoload.php');

/*
## HtTextin

This stands for **HTML Text Input**. It's a library that catters for generating "one-line" text fields through a standard API which provides utilities for data formatting, processing and much more.

This is the first concrete implementation of the `HtWidget` class. You can [click here](https://github.com/flsouto/htwidget) and read more about it in order to better understand the whole philosophy.

## Installation

Run composer:
```
composer require flsouto/httextin
```

*/
class HtTextinTest extends TestCase{

/*

## Usage
By default, the textin widget is rendered in writable mode which will expect input from the user:

#mdx:Writable

Outputs:

#mdx:Writable -o httidy
*/
	function testWritable(){
		#mdx:Writable
		$field = new HtTextin('email');
		$field->context(['email'=>'user@domain.com']);
		#/mdx echo $field
		$this->expectOutputRegex('/input.+value.+user/');
		echo $field;
	}

/*
### Changing to Readonly Mode

#mdx:Readonly -php

Outputs:

#mdx:Readonly -o httidy
*/
	function testReadonly(){
		#mdx:Readonly
		$field = new HtTextin('email');
		$field->readonly(true);
		#/mdx echo $field
		$this->expectOutputRegex('/input.+readonly/');
		echo $field;
	}

/*

To turn readonly off and go back to writable:

#mdx:ReadonlyOff -php -h:al

Outputs:

#mdx:ReadonlyOff -o httidy
*/
	function testReadonlyOff(){
		#mdx:ReadonlyOff
		$field = new HtTextin('email');
		$field->readonly(true);
		$field->readonly(false);
		#/mdx echo $field
		$this->assertNotContains("readonly", "$field");
	}

/*
### Set size attribute

#mdx:Size -php -h:al,use

Outputs:

#mdx:Size -o httidy
*/
	function testSize(){
		#mdx:Size
		$field = new HtTextin('email');
		$field->size(40);
		#/mdx echo $field
		$this->assertContains('size="40"',"$field");
	}

/*
### Set placeholder attribute

#mdx:Placeholder idem

Outputs:

#mdx:Placeholder -o httidy
*/
	function testPlaceholder(){
		#mdx:Placeholder
		$field = new HtTextin('email');
		$field->size(40)->placeholder("eg: user@domain.com");
		#/mdx echo $field
		$this->assertContains('placeholder="eg: user@domain.com"',"$field");

	}

/*
### Using a formatter
The `fromatter` method allows you to format the value that is pulled from the context for showing on the input field:

#mdx:Formatter idem

Outputs:

#mdx:Formatter -o httidy
*/
	function testFormatter(){
		#mdx:Formatter
		$field = new HtTextin('price');
		$field->formatter(function($value){
			return '$'.number_format((float)$value, 2, '.',',');
		});

		$field->context(['price'=>30.9]);
		#/mdx echo $field
		$this->expectOutputRegex('/input.+value.+'+preg_quote('$30.90','/')+'/');
		echo $field;
	}

/*
### Using filters
The `filters` method returns an object which allows you to add filters for processing incoming data.
While `formatter` will be applied only when the widget is rendered, `filters` are always applied, às soon as the 
the `$field->value()` method gets called: 

#mdx:Filters idem

Outputs:

#mdx:Filters -o httidy
*/
	function testFilters(){

		#mdx:Filters
		$field = new HtTextin('price');
		$field->filters()->strip('$')->replace(',','.')->trim();
		$field->context(['price'=>'$ 30,90']);
		#/mdx echo $field->value()
		$this->assertEquals('30.90',$field->process()->output);

	}

/*
### Validation
Validation constraints are added through the same `filters` api:

#mdx:Validation idem

Outputs:

#mdx:Validation -o httidy

**Notice:** For more information about the `filters` api, please referer to [this documentation](https://github.com/flsouto/param/#paramfilters)

*/
	function testValidation(){

		#mdx:Validation
		$field = new HtTextin('amount');
		$field->filters()->maxval(10, "Cannot exceed 10.");
		$field->context(['amount'=>15]);
		$field->error(true); // activates error reporting on the UI
		#/mdx echo $field
		$this->assertContains('Cannot exceed 10',"$field");

	}


}