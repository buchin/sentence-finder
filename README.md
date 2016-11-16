# Sentence Finder
This package find sentence from given word/phrase

## Installation
```bash
composer require buchin/sentence-finder
```

## Usage Example

```php
use Buchin\SentenceFinder\SentenceFinder;

// $sentences will contains array of sentences
$finder = new SentenceFinder;
$sentences = $finder->findSentence('word');
```