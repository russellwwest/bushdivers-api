<?php

namespace App\Services;

use App\Models\AccountLedger;
use App\Models\UserAccount;

class FinanceService
{
    public function addAirlineTransaction(int $type, float $total, string $memo = null, $pirepId = null, $method = 'debit')
    {
        $transactionTotal = 0;
        if ($method == 'debit') {
            $transactionTotal = -$total;
        } elseif ($method == 'credit') {
            $transactionTotal = $total;
        }

        $ledger = new AccountLedger();
        $ledger->transaction_type = $type;
        $ledger->total = $transactionTotal;
        $ledger->memo = $memo;
        $ledger->pirep_id = $pirepId;
        $ledger->save();
    }

    public function addUserTransaction(int $userId, int $type, float $total, string $pirepId = null, string $memo = '')
    {
        $userAccount = new UserAccount();
        $userAccount->user_id = $userId;
        $userAccount->transaction_type = $type;
        $userAccount->total = $total;
        $userAccount->pirep_id = $pirepId;
        $userAccount->memo = $memo;
        $userAccount->save();
    }
}
