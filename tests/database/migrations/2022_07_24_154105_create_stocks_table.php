<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->string('symbol', 15)->primary();
            $table->string('name', 200);
            $table->text('description')->nullable();
            $table->string('cik', 5)->nullable();
            $table->string('currency', 5)->nullable();
            $table->string('exchange', 10)->nullable();
            $table->string('country', 50)->nullable();
            $table->string('sector', 50)->nullable();
            $table->string('industry', 50)->nullable();
            $table->string('asset_type', 50)->nullable();
            $table->string('address', 250)->nullable();
            $table->date('datetime')->nullable();
            $table->timestamp('timestamp')->default('current_timestamp()');
            $table->decimal('open', 9, 4)->nullable();
            $table->decimal('high', 9, 4)->nullable();
            $table->decimal('low', 9, 4)->nullable();
            $table->decimal('price', 9, 4)->nullable();
            $table->bigInteger('volume')->nullable();
            $table->date('latest_trading_day')->nullable();
            $table->decimal('previous_close', 9, 4)->nullable();
            $table->decimal('change', 9, 4)->nullable();
            $table->string('change_percent', 10)->nullable();
            $table->string('fiscal_year_end', 20)->nullable();
            $table->date('latest_quarter')->nullable();
            $table->decimal('market_capitalization', 17, 4)->nullable();
            $table->decimal('ebitda', 17, 4)->nullable();
            $table->decimal('pe_ratio', 9, 4)->nullable();
            $table->decimal('peg_ratio', 9, 4)->nullable();
            $table->decimal('book_value', 9, 4)->nullable();
            $table->decimal('dividend_per_share', 9, 4)->nullable();
            $table->decimal('dividend_yield', 9, 4)->nullable();
            $table->decimal('eps', 9, 4)->nullable();
            $table->decimal('revenue_per_share_ttm', 9, 4)->nullable();
            $table->decimal('profit_margin', 9, 4)->nullable();
            $table->decimal('operating_margin_ttm', 9, 4)->nullable();
            $table->decimal('return_on_assets_ttm', 9, 4)->nullable();
            $table->decimal('return_on_equity_ttm', 9, 4)->nullable();
            $table->decimal('revenue_ttm', 17, 4)->nullable();
            $table->decimal('gross_profit_ttm', 17, 4)->nullable();
            $table->decimal('diluted_eps_ttm', 9, 4)->nullable();
            $table->decimal('quarterly_earnings_growth_yoy', 9, 4)->nullable();
            $table->decimal('quarterly_revenue_growth_yoy', 9, 4)->nullable();
            $table->decimal('analyst_target_price', 9, 4)->nullable();
            $table->decimal('trailing_pe', 9, 4)->nullable();
            $table->decimal('forward_pe', 9, 4)->nullable();
            $table->decimal('price_to_sales_ratio_ttm', 9, 4)->nullable();
            $table->decimal('price_to_book_ratio', 9, 4)->nullable();
            $table->decimal('ev_to_revenue', 9, 4)->nullable();
            $table->decimal('ev_to_ebitda', 9, 4)->nullable();
            $table->decimal('beta', 9, 4)->nullable();
            $table->decimal('52_week_high', 9, 4)->nullable();
            $table->decimal('52_week_low', 9, 4)->nullable();
            $table->decimal('50_day_moving_average', 9, 4)->nullable();
            $table->decimal('200_day_moving_average', 9, 4)->nullable();
            $table->decimal('shares_outstanding', 17, 4)->nullable();
            $table->date('dividend_date')->nullable();
            $table->date('ex_dividend_date')->nullable();
            $table->string('ipo_date', 50)->nullable();
            $table->string('delisting_date', 50)->nullable();
            $table->string('status', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
}
