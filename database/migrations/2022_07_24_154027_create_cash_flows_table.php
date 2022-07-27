<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashFlowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_flows', function (Blueprint $table) {
            $table->string('symbol', 10);
            $table->date('fiscal_date_ending');
            $table->string('reported_currency', 5)->nullable();
            $table->decimal('operating_cashflow', 17, 4)->nullable();
            $table->decimal('payments_for_operating_activities', 17, 4)->nullable();
            $table->string('proceeds_from_operating_activities', 20)->nullable();
            $table->decimal('change_in_operating_liabilities', 17, 4)->nullable();
            $table->decimal('change_in_operating_assets', 17, 4)->nullable();
            $table->decimal('depreciation_depletion_and_amortization', 17, 4)->nullable();
            $table->decimal('capital_expenditures', 17, 4)->nullable();
            $table->decimal('change_in_receivables', 17, 4)->nullable();
            $table->decimal('change_in_inventory', 17, 4)->nullable();
            $table->decimal('profit_loss', 17, 4)->nullable();
            $table->decimal('cashflow_from_investment', 17, 4)->nullable();
            $table->decimal('cashflow_from_financing', 17, 4)->nullable();
            $table->decimal('proceeds_from_repayments_of_short_term_debt', 17, 4)->nullable();
            $table->string('payments_for_repurchase_of_common_stock', 20)->nullable();
            $table->string('payments_for_repurchase_of_equity', 20)->nullable();
            $table->string('payments_for_repurchase_of_preferred_stock', 20)->nullable();
            $table->decimal('dividend_payout', 17, 4)->nullable();
            $table->decimal('dividend_payout_common_stock', 17, 4)->nullable();
            $table->string('dividend_payout_preferred_stock', 20)->nullable();
            $table->string('proceeds_from_issuance_of_common_stock', 20)->nullable();
            $table->string('proceeds_from_issuance_of_preferred_stock', 20)->nullable();
            $table->decimal('proceeds_from_repurchase_of_equity', 17, 4)->nullable();
            $table->string('proceeds_from_sale_of_treasury_stock', 20)->nullable();
            $table->decimal('change_in_cash_and_cash_equivalents', 17, 4)->nullable();
            $table->string('change_in_exchange_rate', 20)->nullable();
            $table->decimal('net_income', 17, 4)->nullable();
            
            $table->primary(['symbol', 'fiscal_date_ending']);
            $table->foreign('symbol', 'cash_flows_ibfk_1')->references('symbol')->on('stocks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_flows');
    }
}
