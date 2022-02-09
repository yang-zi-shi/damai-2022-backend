<?php

namespace App\Http\Resources\Traits;

use Illuminate\Http\Resources\Json\JsonResource;
/**
 * 基礎資源特徵。
 *
 * @category   App\Http
 * @package    Resources
 * @subpackage Traits
 */
trait BaseResourceTrait
{
    /**
     * 不要開啟wrap框架
     *
     * @var mixed
     */
    private $noWrap = false;

    /**
     * 將資源集合轉換成陣列。
     *
     * @param mixed $request Request 請求。
     *
     * @return array
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function toArray($request)
    {
        if (!is_null($this->resource)) {
            return $this->resource;
        }

        $this->noWrap = true;
        return $this->getDefaultFrame($request);
    }

    /**
     * 取得應該與資源陣列一起被回傳的額外的資料。
     *
     * @param mixed $request Request 請求。
     *
     * @return array
     */
    public function with($request)
    {
        parent::with($request);

        if ($this->noWrap) {
            return [];
        }

        Resource::wrap('response');
        return $this->getDefaultFrame($request);
    }

    /**
     * 取得預設框架，
     *
     * @param mixed $request Request 請求。
     *
     * @return array
     */
    private function getDefaultFrame($request)
    {
        // dd('getDefaultFrame', $request);
        // TODO: 之後實際串接取得request_id
        return [
            "request_id" => app()->make('RequestId'),
            "code" => 200,
            "status" => true,
            "message" => $request->resourceMessage
        ];
    }

    /**
     * Customize the outgoing response for the resource.
     *
     * @param Request  $request  Request
     * @param Response $response Response
     *
     * @return void
     */
    public function withResponse($request, $response)
    {
        $response->header('cache-control', 'no-store');
    }
}
