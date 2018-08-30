<?php

namespace Baytek\Commerce\Sage50;

use Carbon\Carbon;
use Baytek\Commerce\Sage50\Allocation;


class Journal 
{
    // use Traits\StringifyColumn;
    protected $allocations = [];

    /**
     * Constructor for Sage50 Journal builder
     *
     * @param Carbon\Carbon $date        The date that the batch was processed
     * @param string        $id          Id used to display in the header
     * @param string        $description Description of the document
     * @param string        $currency    Currency to be saved in the software
     * @param float         $exchange    The exchange rate to be saved in software
     */
    public function __construct(
        Carbon $date, 
        string $id, 
        string $description = '', 
        string $currency = '', 
        float $exchange = 0
    ) {
        $this->header = new Header([
            'date' => $date->format('m-d-y'),
            'id' => $id,
            'description' => $description,
            'currency' => $currency,
            'exchange' => $exchange,
        ]);
    }

    /**
     * Export the file
     *
     * @return string
     */
    public function __toString(): string 
    {
        return $this->export();
    }
    
    /**
     * Empty method for now since we do not need to use this
     *
     * @return void
     */
    public function addTaxes()
    {

    }

    /**
     * Add an allocation to the list
     *
     * @param string $account     Account number of Sage50 entry
     * @param float  $amount      Amount to credit or deposit
     * @param string $description Description of the transaction
     * 
     * @return void
     */
    public function addAllocation(string $account, float $amount, string $description = '')
    {
        $allocation = new Allocation(
            [
                'account' => $account,
                'amount' => $amount,
                'description' => $description
            ]
        );

        array_push($this->allocations, $allocation);
    }

    /**
     * Count all of the entries and generate a balance accounts entry
     *
     * @param string $account Account number of Sage50 entry
     * 
     * @return string
     */
    public function allocateDiff(string $account)
    {
        $amount = 0;
        foreach ($this->allocations as $allocation) {
            $amount += $allocation->amount;
        }

        $this->addAllocation($account, $amount * -1);
    }

    /**
     * Export the file
     *
     * @return string
     */
    public function export(): string
    {
        $buffer = '';
        $buffer .= $this->header;

        foreach ($this->allocations as $allocation) {
            $buffer .= $allocation;
        }

        return trim($buffer);
    }
}