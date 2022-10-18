<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Models\Enums\AirlineTransactionTypes;
use App\Models\Enums\TransactionTypes;
use App\Services\FinanceService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SetStartingBalance
{
    protected FinanceService $financeService;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(FinanceService $financeService)
    {
        $this->financeService = $financeService;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        $this->financeService->addAirlineTransaction(AirlineTransactionTypes::GeneralExpenditure, 200, $event->user->id.' joining bonus');
        $this->financeService->addUserTransaction($event->user->id, TransactionTypes::Bonus, 200, null, 'Joining bonus');
    }
}
