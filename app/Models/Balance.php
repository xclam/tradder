<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    use HasFactory;
	
	protected $table = "balance_sheets";
	
	protected $fillable = [
		"symbol",
		"fiscalDateEnding",
		"reportedCurrency",
		"totalAssets",
		"totalCurrentAssets",
		"cashAndCashEquivalentsAtCarryingValue",
		"cashAndShortTermInvestments",
		"inventory",
		"currentNetReceivables",
		"totalNonCurrentAssets",
		"propertyPlantEquipment",
		"accumulatedDepreciationAmortizationPPE",
		"intangibleAssets",
		"intangibleAssetsExcludingGoodwill",
		"goodwill",
		"investments",
		"longTermInvestments",
		"shortTermInvestments",
		"otherCurrentAssets",
		"otherNonCurrrentAssets",
		"totalLiabilities",
		"totalCurrentLiabilities",
		"currentAccountsPayable",
		"deferredRevenue",
		"currentDebt",
		"shortTermDebt",
		"totalNonCurrentLiabilities",
		"capitalLeaseObligations",
		"longTermDebt",
		"currentLongTermDebt",
		"longTermDebtNoncurrent",
		"shortLongTermDebtTotal",
		"otherCurrentLiabilities",
		"otherNonCurrentLiabilities",
		"totalShareholderEquity",
		"treasuryStock",
		"retainedEarnings",
		"commonStock",
		"commonStockSharesOutstanding"
	];
	
	public function stock()
    {
        return $this->belongsTo(Stock::class, 'symbol', 'Symbol');
    }
}
