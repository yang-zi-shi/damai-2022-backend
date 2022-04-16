<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExchangeResource;
use App\Services\ExchangeService;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

/**
 *
 */
class QuizController extends Controller
{
    private $exchangeService;

    public function __construct(
        ExchangeService $exchangeService
    ) {
        $this->exchangeService = $exchangeService;
    }

    public function getExchangeRate(Request $request)
    {
        //$client   = new Client();
        //$response = $client->get('https://tw.rter.info/capi.php');
        //$rateData = json_decode($response->getBody(), true);
        $content=file_get_contents('https://tw.rter.info/capi.php');
        $rate = json_decode($content, true);
        $key= $request->input('toVert').$request->input('fromVert');
        return $rate[$key] ?? '找不到匯率結果!';
    }
}
