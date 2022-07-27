<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
	
	protected $table = "stocks";
	
	protected $primaryKey = 'Symbol';
	
	public $incrementing = false;
	
	protected $keyType = 'string';
	
	protected $fillable = [
		"Symbol",
		"Name",
		"Description",
		"CIK",
		"Currency",
		"Exchange",
		"Country",
		"Sector",
		"Industry",
		"AssetType",
		"Address",
		"Datetime",
		"Timestamp",
		"Open",
		"High",
		"Low",
		"Price",
		"Volume",
		"LatestTradingDay",
		"PreviousClose",
		"Change",
		"ChangePercent",
		"FiscalYearEnd",
		"LatestQuarter",
		"MarketCapitalization",
		"EBITDA",
		"PERatio",
		"PEGRatio",
		"BookValue",
		"DividendPerShare",
		"DividendYield",
		"EPS",
		"RevenuePerShareTTM",
		"ProfitMargin",
		"OperatingMarginTTM",
		"ReturnOnAssetsTTM",
		"ReturnOnEquityTTM",
		"RevenueTTM",
		"GrossProfitTTM",
		"DilutedEpsTTM",
		"QuarterlyEarningsGrowthYOY",
		"QuarterlyRevenueGrowthYOY",
		"AnalystTargetPrice",
		"TrailingPE",
		"ForwardPE",
		"PriceToSalesRatioTTM",
		"PriceToBookRatio",
		"EVToRevenue",
		"EVToEBITDA",
		"Beta",
		"52WeekHigh",
		"52WeekLow",
		"50DayMovingAverage",
		"200DayMovingAverage",
		"SharesOutstanding",
		"DividendDate",
		"ExDividendDate",
		"OperatingCashflowLastQuarter"
	];
	
	public function balances()
    {
        return $this->hasMany(\App\Models\Balance::class, 'symbol', 'Symbol');
    }
	
	public function cash_flows()
    {
        return $this->hasMany(\App\Models\CashFlow::class, 'symbol', 'Symbol');
    }
}
