<?php

namespace App\Http\Resources\Traits;

use App\Constants\OrderConstant;
use App\Constants\StoreConstant;

/**
 * 時間格式。
 *
 * @category   App\Http
 * @package    Resources
 * @subpackage Traits
 */
trait DateTimeFormatTrait
{
    /**
     * 日期時間格式化
     *
     * @param         datetime [必填] 日期時間
     * @param integer type     [選填] 外送=1;自取=2;內用=3
     * @param boolean is_asap  [選填] 0: 非盡快(顯示區間時間); 1: 盡快(顯示當下時間)
     *
     * @return string
     * @throws
     */
    protected function formatDateTime($dateTime, int $deliveryType = 0, bool $isAsap = false)
    {
        $obj = new \DateTime($dateTime);

        // 對應week w 轉出0~6
        $week = ['日', '一', '二', '三', '四', '五', '六'];

        //非盡快狀態
        // 外送：有時間區段（顯示用戶選擇時間區段）
        // 自取、內用：不會顯示時間區段（顯示用戶選擇時間）
        // 盡快狀態
        // 外送：下訂時間＋盡快送達
        // 自取、內用：下訂時間＋盡快出餐
        if (!$isAsap && $deliveryType == OrderConstant::ORDER_PRODUCT_DELIVERY_SHIP) {
            $pickupData = ($this->resource['store']['pickups'])->where('type', OrderConstant::ORDER_PRODUCT_DELIVERY_SHIP)->first();
            $timeType = !empty($pickupData) ? $pickupData['interval_time'] : StoreConstant::ORDER_INTERVAL_TIME_TYPE_DEFAULT;
            $addTime = (int) (StoreConstant::ORDER_INTERVAL_TIME[$timeType] ?? StoreConstant::ORDER_INTERVAL_TIME[StoreConstant::ORDER_INTERVAL_TIME_TYPE_DEFAULT]);
            return sprintf("%s(%s) %s - %s", $obj->format("Y/m/d"), $week[$obj->format('w')], $obj->format("H:i"), $obj->modify("+{$addTime} minutes")->format("H:i"));
        }

        return sprintf("%s (%s) %s", $obj->format("Y/m/d"), $week[$obj->format("w")], $obj->format("H:i"));
    }
}
