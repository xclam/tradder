<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CalculIntrinsicCF extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calcul:intrinsicCF {symbol?}';

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
		$symbol = $this->argument('symbol');
			
		if(!is_null($symbol)){
			$intrinsic_values = DB::table('intrinsic_values')->where('symbol', $symbol)->get();
		}else{
			$intrinsic_values = DB::table('intrinsic_values')->where('normal_0-5','>', 0)->where('cashflow','>',0)->get();
		}
		
		$normal = [];
		$best = [];
		$worst = [];
		foreach($intrinsic_values as $iv){
			$ocf = DB::table('cash_flows')->select("operatingCashflow")->where('symbol',$iv->symbol)->orderBy("fiscalDateEnding", "desc")->limit(1)->get();
			$iv->calculDate = date("Y-m-d");
			
			$iv->cf_n_0 = $iv->cashflow; 
			$iv->cf_b_0 = $iv->cashflow;
			$iv->cf_w_0 = $iv->cashflow;

			for($i=1;$i<6;$i++){
				$j = $i-1;
				$iv->{"cf_n_$i"} = $iv->{"cf_n_$j"}*(1+$iv->{"normal_0-5"}/100);
				$iv->{"cf_b_$i"} = $iv->{"cf_b_$j"}*(1+$iv->{"best_0-5"}/100);
				$iv->{"cf_w_$i"} = $iv->{"cf_w_$j"}*(1+$iv->{"worst_0-5"}/100);

			}
			for($i=6;$i<11;$i++){
				$j = $i-1;
				$iv->{"cf_n_$i"} = $iv->{"cf_n_$j"}*(1+$iv->{"normal_6-10"}/100);
				$iv->{"cf_b_$i"} = $iv->{"cf_b_$j"}*(1+$iv->{"best_6-10"}/100);
				$iv->{"cf_w_$i"} = $iv->{"cf_w_$j"}*(1+$iv->{"worst_6-10"}/100);
			}
			
			$iv->cf_n_selling_year = $iv->{"cf_n_10"}*$iv->normal_terminalMultiplier;
			$iv->cf_b_selling_year = $iv->{"cf_b_10"}*$iv->best_terminalMultiplier;
			$iv->cf_w_selling_year = $iv->{"cf_w_10"}*$iv->worst_terminalMultiplier;
			
			$iv->cf_n_value = $iv->cf_n_selling_year/pow((1+$iv->normal_discountRate/100),11);
			$iv->cf_b_value = $iv->cf_b_selling_year/pow((1+$iv->best_discountRate/100),11);
			$iv->cf_w_value = $iv->cf_w_selling_year/pow((1+$iv->worst_discountRate/100),11);
			
			$shares = DB::table('stocks')->select("SharesOutstanding")->where('symbol',$iv->symbol)->get();
			
			$iv->cf_value = (($iv->cf_n_value * $iv->normal_ponderation / 100) + ($iv->cf_b_value * $iv->best_ponderation / 100) + ($iv->cf_w_value * $iv->worst_ponderation / 100)) / $shares[0]->SharesOutstanding;
			
			unset($iv->cf_n_0,$iv->cf_b_0,$iv->cf_w_0);
			
			
			DB::table('intrinsic_values')
				->where('symbol', $iv->symbol)
				->update((array)$iv);			  
		}
    }
}
