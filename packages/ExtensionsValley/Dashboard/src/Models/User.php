<?php
namespace ExtensionsValley\Dashboard\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{

    use Authenticatable, CanResetPassword;
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

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
    protected $fillable = ['name', 'email', 'status', 'groups', 'password', 'is_corp'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function groups()
    {

        return $this->belongsTo('ExtensionsValley\Dashboard\Models\Group', 'groups');
    }

    public static function getUsers()
    {

        return self::WhereNull('deleted_at')->Where('status', 1)->pluck('name', 'id');
    }

    ##Prevent relation breaking
    public static function getRlationstatus($cid)
    {

        return 0;
    }
}
