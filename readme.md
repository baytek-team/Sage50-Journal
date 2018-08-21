# Generate Sage50 Journal Entry Files
This simple library is used to generate Sage 50 journal files. There is little
validation but the purpose is to have the library here in the event that we want to 
extend functionality.

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