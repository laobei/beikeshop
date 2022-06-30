<?php
/**
 * SettingRepo.php
 *
 * @copyright  2022 opencart.cn - All Rights Reserved
 * @link       http://www.guangdawangluo.com
 * @author     Edward Yang <yangjin@opencart.cn>
 * @created    2022-06-30 16:36:40
 * @modified   2022-06-30 16:36:40
 */

namespace Beike\Repositories;

use Beike\Models\Cart;
use Beike\Models\Setting;
use Carbon\Carbon;

class SettingRepo
{
    /**
     * 获取插件默认字段
     *
     * @return array
     */
    public static function getPluginStatusColumn(): array
    {
        return [
            'name' => 'status',
            'label' => '是否开启',
            'type' => 'bool',
            'required' => true,
        ];
    }

    public static function getPluginColumns($pluginCode)
    {
        return Setting::query()
            ->where('type', 'plugin')
            ->where('space', $pluginCode)
            ->get()
            ->keyBy('name');
    }

    public static function getPluginStatus($pluginCode): bool
    {
        $status = Setting::query()
            ->where('type', 'plugin')
            ->where('space', $pluginCode)
            ->where('name', 'status')
            ->value('value');
        return (bool)$status;
    }

    public static function update($type, $code, $fields)
    {
        Setting::query()->where('type', $type)->where('space', $code)->delete();
        $rows = [];
        foreach ($fields as $name => $value) {
            $rows[] = [
                'type' => $type,
                'space' => $code,
                'name' => $name,
                'value' => (string)$value,
                'json' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }
        Setting::query()->insert($rows);
    }

    public static function getShipments()
    {
        return [];
    }

    public static function getPayments()
    {
        return [];
    }
}