<?php

namespace App\Components;

use App\Http\Models\Config;
use App\Http\Models\CouponLog;
use App\Http\Models\EmailLog;
use App\Http\Models\Level;
use App\Http\Models\User;
use App\Http\Models\UserSubscribe;
use App\Http\Models\UserTrafficModifyLog;

class Helpers
{

    // 获取系统配置
    public static function systemConfig()
    {
        $config = Config::query()->get();
        $data = [];
        foreach ($config as $vo) {
            $data[$vo->name] = $vo->value;
        }

        return $data;
    }

    // 等级
    public static function levelList()
    {
        return Level::query()->get()->sortBy('level');
    }

    // 生成用户的订阅码
    public static function makeSubscribeCode()
    {
        $code = makeRandStr(5);
        if (UserSubscribe::query()->where('code', $code)->exists()) {
            $code = self::makeSubscribeCode();
        }

        return $code;
    }

    /**
     * 添加邮件投递日志
     *
     * @param string $address 收信地址
     * @param string $title   标题
     * @param string $content 内容
     * @param int    $status  投递状态
     * @param string $error   投递失败时记录的异常信息
     *
     * @return int
     */
    public static function addEmailLog($address, $title, $content, $status = 1, $error = '')
    {
        $log = new EmailLog();
        $log->type = 1;
        $log->address = $address;
        $log->title = $title;
        $log->content = $content;
        $log->status = $status;
        $log->error = $error;
        $log->save();

        return $log->id;
    }

    /**
     * 添加优惠券操作日志
     *
     * @param int    $couponId 优惠券ID
     * @param int    $goodsId  商品ID
     * @param int    $orderId  订单ID
     * @param string $desc     备注
     *
     * @return int
     */
    public static function addCouponLog($couponId, $goodsId, $orderId, $desc = '')
    {
        $log = new CouponLog();
        $log->coupon_id = $couponId;
        $log->goods_id = $goodsId;
        $log->order_id = $orderId;
        $log->desc = $desc;

        return $log->save();
    }

    /**
     * 记录流量变动日志
     *
     * @param int    $userId 用户ID
     * @param string $oid    订单ID
     * @param int    $before 记录前的值
     * @param int    $after  记录后的值
     * @param string $desc   描述
     *
     * @return int
     */
    public static function addUserTrafficModifyLog($userId, $oid, $before, $after, $desc = '')
    {
        $log = new UserTrafficModifyLog();
        $log->user_id = $userId;
        $log->order_id = $oid;
        $log->before = $before;
        $log->after = $after;
        $log->desc = $desc;

        return $log->save();
    }
}