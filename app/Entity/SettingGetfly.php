<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 3/2/2018
 * Time: 8:29 AM
 */

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SettingGetfly extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];

    protected $table = 'setting_getfly';

    protected $primaryKey = 'setting_getfly_id';

    protected $fillable = [
        'setting_getfly_id',
        'user_id',
        'api_key',
        'base_url',
        'created_at',
        'deleted_at',
        'updated_at'
    ];

    public static function getApiKey() {
        try {
            $settingGetFly = static::first();
            if(empty($settingGetFly)) {
                return null;
            }

            return $settingGetFly->api_key;
        } catch (\Exception $e) {
            Log::error('Entity->SettingGetFly->getApiKey: Lỗi lấy api_key của getfly');

            return null;
        }
    }

    public static function getBaseUrl() {
        try {
            $settingGetFly = static::first();
            if(empty($settingGetFly)) {
                return null;
            }

            return $settingGetFly->base_url;
        } catch (\Exception $e) {
            Log::error('Entity->SettingGetFly->getBaseUrl: Lỗi lấy api_key của getfly');

            return null;
        }
    }

    public static function checkSettingGetfly() {
        try {
            $settingGetFly = static::first();
            if(empty($settingGetFly)) {
                return false;
            }

            if (empty($settingGetFly->base_url) || empty($settingGetFly->api_key)) {
                return false;
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Entity->SettingGetFly->checkSettingGetfly: Kiểm tra tồn tại cài đặt getfly');

            return false;
        }
    }
}