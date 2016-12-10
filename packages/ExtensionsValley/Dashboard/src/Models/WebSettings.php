<?php
namespace ExtensionsValley\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WebSettings extends Model
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'gen_settings';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['settings_key', 'settings_value'];


    public static function getSettings()
    {

        return self::get();
    }

}
