<?php
namespace ExtensionsValley\Dashboard\Facades;

use Illuminate\Support\Facades\Facade;

class WebConf extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    public static $version = "1.0";

    protected static function getFacadeAccessor()
    {
        return 'WebConf';
    }

    public static function get($key)
    {
        if (!\Cache::has($key)) {
            $vals =  \DB::table('gen_settings')
                    ->where('settings_key', $key)
                    ->value('settings_value');

            \Cache::forever($key, $vals);
        }else{
            $vals =  \Cache::get($key);
        }
        return $vals;
    }

    public static function checkKey($key)
    {
        return \DB::table('gen_settings')
            ->where('settings_key', $key)
            ->count();
    }
}
