<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Str;

class AlphaVantageAPI extends Model
{
    use HasFactory;
	
	protected static $client = null;
	
	protected static $base_url = "https://www.alphavantage.co/query?apikey=11AKGCV19MA586IY&function=";
	
	protected static $api_key = "11AKGCV19MA586IY";

	protected static $request = null;
	
	public function __construct()
	{
		$this->client = new Client();
	}

	// Get the list of all stocks for one Exchange
	public function getStocksList($date=null, $state=null)
	{	
		$url = $this->base_url.'LISTING_STATUS';
		if(!is_null($date))
			$url .= '&date='.$date;
		if(!is_null($state))
			$url .= '&state='.$state;
		
		$this->request = new Request('GET', $url);
		$this->execute();
	}
	
	// Get the value of a stock
	public static function getQuote($symbol)
	{
		self::$request = new Request('GET', self::$base_url.'GLOBAL_QUOTE&symbol='.$symbol);
		$result = self::execute();
		
		$result = preg_replace("/(\d+.\ )/","",$result);

		$result = json_decode($result);
		$result = (array)$result->{'Global Quote'};
		
		foreach($result as $key=>$val){
			$result[Str::camel($key)] = $val;
			unset($result[$key]);
		}
		
		return $result;
	}
	
	// Get 
	public static function getOverview($symbol)
	{
		self::$request = new Request('GET', self::$base_url.'OVERVIEW&symbol='.$symbol);
		$result = self::execute();
		return (array)json_decode($result);

	}
	
	// Get the balance sheet
	public static function getBalanceSheet($symbol)
	{
		self::$request = new Request('GET', self::$base_url.'BALANCE_SHEET&symbol='.$symbol);
		$result = self::execute();
		return (array)json_decode($result);
	}
	
	// Get cash flow
	public static function getCashFlow($symbol)
	{
		self::$request = new Request('GET', self::$base_url.'CASH_FLOW&symbol='.$symbol);
		$result = self::execute();
		return (array)json_decode($result);
	}
	
	//execute the API
	public static function execute()
	{
		self::$client = new Client();
		$response = self::$client->sendAsync(self::$request)->wait();
		
		if($response->getStatusCode() == 200){
			return $response->getBody()->getContents();
		}else{
			return $response->getReasonPhrase();
		}
	}
}
