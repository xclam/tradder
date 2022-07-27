<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \App\Models\Stock;
use \App\Models\Balance;
use \App\Models\CashFlow;
use Illuminate\Support\Facades\DB;

class CalculInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calcul:init {symbol?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialise les données utiles au calcul de la valeur intrainsec';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
		$symbol = $this->argument('symbol');
		
		if(!is_null($symbol)){
			$stocks = Stock::where("Symbol",$symbol)->get();
		}else{
			$stocks = Stock::where("AssetType","<>","ETF")->where("OperatingCashflowLastQuarter",">",0)->get();
		}
		
		foreach($stocks as $stock){
			
			$i=0;
			$average = 0;
			$max = 0;
			$min = 0;
			$cf_var=[];
			foreach($stock->cash_flows as $cash_flow){
				if(is_null($cash_flow->operatingCashflow) or $cash_flow->operatingCashflow == '' or $cash_flow->operatingCashflow == 0)
					continue;
				
				$cf[$i] = $cash_flow->operatingCashflow;
				if($i>0){
					$cf_var[$i] = $cf[$i]*100/$cf[$i-1]-100;
				}
				$i++;
			}
			if($i<=1)
				continue;
			
			// $average = min(50,round((array_sum($cf_var)/count($cf_var)),2));
			// if($average <= 0 )
				// continue;
			
			$average = 0;
			$serie = 0;
			for($i=0;$i<count($cf_var);$i++){
				$average = $average + $cf_var[$i+1] * ($i+1);
				$serie += ($i + 1);
			}
			$average = min(50,$average / $serie);
			if($average <= 0 )
				continue;
			
			$max = min(50,round(max($cf_var),2))/10;
			$min = max(-50,round(min($cf_var),2))/10;
			
			DB::table('intrinsic_values')->upsert(
				[
					[
						'symbol' => $stock->Symbol, 
						'normal_0-5' => $average, 'normal_6-10' => $average/2,
						'best_0-5' => $average*(1+$max/100), 'best_6-10' => $average*(1+$max/100)/2,
						'worst_0-5' => $average*(1+(($min*100/$average)-100)/100), 'worst_6-10' => $average*(1+((($min-5)*100/$average)-100)/100),
						'normal_terminalMultiplier' => min(100,$stock->EVToEBITDA),
						'best_terminalMultiplier' => min(100,$stock->EVToEBITDA*(1+0.5)),
						'worst_terminalMultiplier' => min(100,$stock->EVToEBITDA*(1-0.5)),
						'normal_discountRate' => 15, 'normal_ponderation' => 50,
						'best_discountRate' => 15, 'best_ponderation' => 25,
						'worst_discountRate' => 15, 'worst_ponderation' => 25,
						'cashflow' => $stock->OperatingCashflowLastQuarter,
					]
				],
				['symbol'],
				[
					'normal_0-5','normal_6-10','best_0-5','best_6-10','worst_0-5','worst_6-10',
					'normal_terminalMultiplier','best_terminalMultiplier','worst_terminalMultiplier',
					'normal_discountRate','best_discountRate','worst_discountRate',
					'normal_ponderation','best_ponderation','worst_ponderation','cashflow'
				]
			);
		}
    }
}
