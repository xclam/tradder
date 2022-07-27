<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashFlow extends Model
{
    use HasFactory;
	
	protected $table = "cash_flows";
	
	protected $fillable = [
		"symbol",
		"fiscalDateEnding",
		"reportedCurrency",
		"operatingCashflow",
		"paymentsForOperatingActivities",
		"proceedsFromOperatingActivities",
		"changeInOperatingLiabilities",
		"changeInOperatingAssets",
		"depreciationDepletionAndAmortization",
		"capitalExpenditures",
		"changeInReceivables",
		"changeInInventory",
		"profitLoss",
		"cashflowFromInvestment",
		"cashflowFromFinancing",
		"proceedsFromRepaymentsOfShortTermDebt",
		"paymentsForRepurchaseOfCommonStock",
		"paymentsForRepurchaseOfEquity",
		"paymentsForRepurchaseOfPreferredStock",
		"dividendPayout",
		"dividendPayoutCommonStock",
		"dividendPayoutPreferredStock",
		"proceedsFromIssuanceOfCommonStock",
		"proceedsFromIssuanceOfPreferredStock",
		"proceedsFromRepurchaseOfEquity",
		"proceedsFromSaleOfTreasuryStock",
		"changeInCashAndCashEquivalents",
		"changeInExchangeRate",
		"netIncome"
	];
	
	public function stock()
    {
        return $this->belongsTo(Stock::class, 'symbol', 'Symbol');
    }
}
