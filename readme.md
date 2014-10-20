# Lexicon Template Engine
___

[![Unstable](http://img.shields.io/badge/unstable-0.1-orange.svg?style=flat)](https://packagist.org/packages/anomaly/lexicon)
[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat)](https://packagist.org/packages/anomaly/lexicon)
[![Build Status](http://img.shields.io/travis/anomalylabs/lexicon.svg?style=flat)](https://travis-ci.org/anomalylabs/lexicon)
[![Code Coverage](http://img.shields.io/codeclimate/coverage/github/anomalylabs/lexicon.svg?style=flat)](https://codeclimate.com/github/anomalylabs/lexicon)
[![Code Quality](http://img.shields.io/scrutinizer/g/anomalylabs/lexicon.svg?style=flat)](https://scrutinizer-ci.com/g/anomalylabs/lexicon/)
[![Total Downloads](http://img.shields.io/packagist/dt/anomaly/lexicon.svg?style=flat)](https://packagist.org/packages/anomaly/lexicon)

Lexicon is a template engine that encourages the design of simple and maintainable templates.

## Documentation

The complete documentation for Lexicon can be found at [Lexicon Documentation](http://lexicon.anomaly.is) website.

## Installation

Lexicon is a Composer package named `anomaly/lexicon`. To use it, simply add it to the require section of you `composer.json` file.

```language-php
{
    "require": {
        "anomaly/lexicon": "~0.1"
    }
}
```

Next, update `app/config/app.php` to include a reference to this package's service provider in the providers array.

```language-php
'providers' => [
    'Anomaly\Lexicon\LexiconServiceProvider'
]
```
___

## Credits

- [Osvaldo Brignoni](http://twitter.com/obrignoni)
- Lexicon is inspired on the [PyroCMS Lex Parser](https://github.com/pyrocms/lex), created by [Dan Horrigan](https://twitter.com/dhrrgn). 

We use the following packages.

- `illuminate/view`
- `phpspec/phpspec`

## Contributing

The contribution guide can be found in the [Lexicon Documentation](http://lexicon.anomaly.is/contributing).

### License

Lexicon is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)