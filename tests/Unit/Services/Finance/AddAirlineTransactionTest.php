<?php

namespace Tests\Unit\Services\Finance;

use App\Models\Enums\AirlineTransactionTypes;
use App\Services\FinanceService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddAirlineTransactionTest extends TestCase
{
    use RefreshDatabase;

    protected FinanceService $financeService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->financeService = app()->make(FinanceService::class);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_credit_added()
    {
        $this->financeService->addAirlineTransaction(AirlineTransactionTypes::ContractIncome, 200, 'Flight 1', '32432fsfdf', 'credit');
        $this->assertDatabaseHas('account_ledgers', [
            'total' => 200.00,
            'transaction_type' => AirlineTransactionTypes::ContractIncome
        ]);
    }

    public function test_dedit_added()
    {
        $this->financeService->addAirlineTransaction(AirlineTransactionTypes::AircraftMaintenanceFee, 200, 'Maintenances');
        $this->assertDatabaseHas('account_ledgers', [
            'total' => -200.00,
            'memo' => 'Maintenances'
        ]);
    }
}
