Lórum Ipse fake text generator
====================

**With this package you can generate random sentences and paragraphs with made up Hungarian-like words.**

This package uses the api of http://www.lorumipse.hu/ website. The text generating algorithm is developed by the Lórum Ipse team.
The package only gets the generated text from the api url and parses it by the needs.

Please note that because of calling an external api url, getting a random text might take a longer time.

### Docs

* [Demo](#demo)
* [Installation](#installation)

## Demo

When instantiating the faker, it already gives you a paragraph, a sentence and a single word, but you can generate a new one by calling them as methods (see below)

```php
  <?php $faker = Baueri\LorumIpse\LorumIpseFaker::make();
```

**Getting a paragraph**

```php
  echo $faker->paragraph;

  //Calling as method. You can set the number of sentences you want to retrieve
  echo $faker->paragraph(4);
```

**Getting a sentence with specific number of words**

```php
  echo $faker->sentence;
  
  //Calling as method, setting number of words as parameter
  echo $faker->sentence(10);
```

**Get a single random word**

```php
  echo $faker->word;

  //or with a function (this generates a new word)
  echo $faker->word();
```

### Installation

To install, you have to add the following lines to the composer

```json
{
  "repositories": [
    {
        "url": "https://baueri@bitbucket.org/baueri/lorum-ipse-faker.git",
        "type": "git"
    }
  ],
  "require": {
       "baueri/lorum-ipse-faker": "dev-master"
    }
}
```

Then run
```json
compser update
```