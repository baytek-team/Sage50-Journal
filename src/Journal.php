<?php

namespace Baytek\Commerce\Sage50;

use Carbon\Carbon;
use Baytek\Commerce\Sage50\Allocation;


class Journal 
{
    // use Traits\StringifyColumn;

    private $date;
    private $id;
    private $description;
    private $currency;
    private $exchange;
    private $allocations = [];

    public function __construct(
        Carbon $date, 
        string $id, 
        string $description = "", 
        string $currency = 'CAD', 
        float $exchange = 1
    ) {
        $this->date = $date;
        $this->id = $id;
        $this->description = $description;
        $this->currency = $currency;
        $this->exchange = $exchange;
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

        $header = [
            $this->date->format('m-d-y'),
            "\"{$this->id}\"",
            "\"{$this->description}\"",
            $this->currency,
            $this->exchange
        ];

        $buffer .= implode(', ', $header)."\r\n";

        foreach ($this->allocations as $allocation) {
            $buffer .= $allocation;
        }


        return $buffer;
    }

}