<?php

namespace Modules\DomenyTv\App\Http\Resources;

class AccountBalanceResource
{
    protected $accountBalanceResult;

    public function __construct($accountBalanceResult)
    {
        $this->accountBalanceResult = $accountBalanceResult;
    }

    public function accountBalanceResult()
    {
        return $this->accountBalanceResult;
    }
}
