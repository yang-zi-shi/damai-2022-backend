<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExchangeResource;
use App\Services\ExchangeService;
use Illuminate\Http\Request;

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
        $response = collect([]);
        // TODO: 實作取得匯率
        // API回傳結果
        return new ExchangeResource($response);
    }
}
