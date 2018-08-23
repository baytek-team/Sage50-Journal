# Generate Sage50 Journal Entry Files

[![License](http://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://tldrlegal.com/license/mit-license)
[![PHP](https://img.shields.io/badge/PHP-%3E=7.0.0-green.svg)](http://www.php.net/ChangeLog-7.php#7.0.0)

This simple library is used to generate Sage 50 journal files. There is little
validation but the purpose is to have the library here in the event that we want to 
extend functionality.

## Technical Docs
- https://help-sage50.na.sage.com/en-ca/core/2017/Content/Import_Export/ImportingGeneralJournalEntries.htm

## Alternatives
Something to look into as an alternative
- https://github.com/smart-io/php-sage50

## Base use
Below is a sample of how you would create a journal entry file. Note that a carbon
date is required.

``` php
$journal = new Journal(new Carbon, 'BAT-2118-000001', 'Account Payable Entry number one');

$journal->addAllocation('2300', -1819.06, 'PST');
$journal->addAllocation('2302', -291.70,  'HST');
$journal->addAllocation('2304', -499.64,  'PREMIUM TAX');

$journal->allocateDiff('1210');

header('content-type: text/plain');
echo $journal;
```