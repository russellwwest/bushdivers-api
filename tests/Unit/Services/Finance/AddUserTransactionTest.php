<?php

namespace Tests\Unit\Services\Finance;

use App\Models\Enums\AirlineTransactionTypes;
use App\Models\Enums\TransactionTypes;
use App\Services\FinanceService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddUserTransactionTest extends TestCase
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
    public function test_transaction_added()
    {
        $this->financeService->addUserTransaction(1, TransactionTypes::Bonus, 200, '', 'Starting bonus');
        $this->assertDatabaseHas('user_accounts', [
            'total' => 200.00,
            'transaction_type' => TransactionTypes::Bonus
        ]);
    }
}
