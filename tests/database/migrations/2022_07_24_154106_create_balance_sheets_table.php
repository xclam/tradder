<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalanceSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balance_sheets', function (Blueprint $table) {
            $table->string('symbol', 10);
            $table->date('fiscal_date_ending');
            $table->string('reported_currency', 5)->nullable();
            $table->decimal('total_assets', 17, 4)->nullable();
            $table->decimal('total_current_assets', 17, 4)->nullable();
            $table->decimal('cash_and_cash_equivalents_at_carrying_value', 17, 4)->nullable();
            $table->decimal('cash_and_short_term_investments', 17, 4)->nullable();
            $table->decimal('inventory', 17, 4)->nullable();
            $table->decimal('current_net_receivables', 17, 4)->nullable();
            $table->decimal('total_non_current_assets', 17, 4)->nullable();
            $table->decimal('property_plant_equipment', 17, 4)->nullable();
            $table->decimal('accumulated_depreciation_amortization_ppe', 17, 4)->nullable();
            $table->decimal('intangible_assets', 17, 4)->nullable();
            $table->decimal('intangible_assets_excluding_goodwill', 17, 4)->nullable();
            $table->decimal('goodwill', 17, 4)->nullable();
            $table->decimal('investments', 17, 4)->nullable();
            $table->decimal('long_term_investments', 17, 4)->nullable();
            $table->decimal('short_term_investments', 17, 4)->nullable();
            $table->decimal('other_current_assets', 17, 4)->nullable();
            $table->decimal('other_non_currrent_assets', 17, 4)->nullable();
            $table->decimal('total_liabilities', 17, 4)->nullable();
            $table->decimal('total_current_liabilities', 17, 4)->nullable();
            $table->decimal('current_accounts_payable', 17, 4)->nullable();
            $table->decimal('deferred_revenue', 17, 4)->nullable();
            $table->decimal('current_debt', 17, 4)->nullable();
            $table->decimal('short_term_debt', 17, 4)->nullable();
            $table->decimal('total_non_current_liabilities', 17, 4)->nullable();
            $table->decimal('capital_lease_obligations', 17, 4)->nullable();
            $table->decimal('long_term_debt', 17, 4)->nullable();
            $table->decimal('current_long_term_debt', 17, 4)->nullable();
            $table->decimal('long_term_debt_noncurrent', 17, 4)->nullable();
            $table->decimal('short_long_term_debt_total', 17, 4)->nullable();
            $table->decimal('other_current_liabilities', 17, 4)->nullable();
            $table->decimal('other_non_current_liabilities', 17, 4)->nullable();
            $table->decimal('total_shareholder_equity', 17, 4)->nullable();
            $table->decimal('treasury_stock', 17, 4)->nullable();
            $table->decimal('retained_earnings', 17, 4)->nullable();
            $table->decimal('common_stock', 17, 4)->nullable();
            $table->decimal('common_stock_shares_outstanding', 17, 4)->nullable();
            
            $table->primary(['symbol', 'fiscal_date_ending']);
            $table->foreign('symbol', 'balance_sheets_ibfk_1')->references('symbol')->on('stocks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('balance_sheets');
    }
}
