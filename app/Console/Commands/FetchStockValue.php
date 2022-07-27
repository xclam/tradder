<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \App\Models\Stock;
use \App\Models\Balance;
use \App\Models\CashFlow;
use \App\Models\AlphaVantageAPI as API;


class FetchStockValue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:stockValue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
		// \Log::info("Cron is working fine!");
        // echo "Cron is working fine!\r\n";
		
		// $stocks = Stock::orderBy('updated_at', 'asc')->limit(5)->get();
		$stock = Stock::where('Status','=','Active')->orderBy('updated_at', 'asc')->limit(1)->first();
		
		// $stock = Stock::where(["Symbol"=>"AJG"])->first();
		
		\Log::info("Fetching $stock->Symbol");
		$stock_value = API::getQuote($stock->Symbol);
		$stock_detail = API::getOverview($stock->Symbol);
		$stock_balance = API::getBalanceSheet($stock->Symbol);
		$stock_cash_flow = API::getCashFlow($stock->Symbol);
		
		if(isset($stock_cash_flow["quarterlyReports"])){
			$stock_merged = array_merge($stock_value, $stock_detail, ["OperatingCashflowLastQuarter" => $stock_cash_flow["quarterlyReports"][0]->operatingCashflow+$stock_cash_flow["quarterlyReports"][1]->operatingCashflow+$stock_cash_flow["quarterlyReports"][2]->operatingCashflow+$stock_cash_flow["quarterlyReports"][3]->operatingCashflow]);
		}else{
			$stock->where('Symbol',$stock->Symbol)->update(['Status'=>'inactive']);
			return 0;
		}
		
		try{			
			$ret = $stock->where('Symbol',$stock->Symbol)->update(array_filter($stock_merged, fn($value) => $value !== 'None' && $value !== '-'));
		}catch(\Illuminate\Database\QueryException $qe){
			\Log::info("QueryException : ".$qe);
			$stock->where('Symbol',$stock->Symbol)->update(['Status'=>'inactive']);
			return 0;
		}
		
		// Balance Sheet
		foreach($stock_balance["annualReports"] as $sby){
			$balance = $stock->balances()->where('symbol',$stock->Symbol)->where('fiscalDateEnding', $sby->fiscalDateEnding)->first();
			if ($balance !== null) {
				$balance->update(array_filter((array)$sby, fn($value) => $value !== 'None'));
			} else {
				$stock->balances()->create(array_filter((array)$sby, fn($value) => $value !== 'None'));
			}
		}
		
		// Cash Flow
		foreach($stock_cash_flow["annualReports"] as $cfy){
			$cash_flow = $stock->cash_flows()->where('symbol',$stock->Symbol)->where('fiscalDateEnding', $cfy->fiscalDateEnding)->first();
			if ($cash_flow !== null) {
				$cash_flow->update(array_filter((array)$cfy, fn($value) => $value !== 'None'));
			} else {
				$stock->cash_flows()->create(array_filter((array)$cfy, fn($value) => $value !== 'None'));
			}
		}

    }
}