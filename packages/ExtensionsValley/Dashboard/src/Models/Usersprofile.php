<?php
namespace ExtensionsValley\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usersprofile extends Model
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_profile';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'address', 'street', 'city', 'state', 'media', 'first_name', 'zip', 'mobile', 'last_name'];

    public function Usersprofile()
    {

        return $this->hasMany('ExtensionsValley\Dashboard\Models\Usersprofile');
    }

    public static function getUsersprofile()
    {

        return self::Where('deleted_at', NULL)->pluck('user_id', 'id');
    }

    //Prevent relation breaking
    public static function getRlationstatus($cid)
    {
        return 0;

    }

}
