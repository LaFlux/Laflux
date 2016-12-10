<?php
namespace ExtensionsValley\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'groups';

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
    protected $fillable = ['name', 'status', 'groups', 'status'];

    public function users()
    {

        return $this->hasMany('ExtensionsValley\Dashboard\Models\User');
    }

    public static function getGroups()
    {

        return self::Where('deleted_at', NULL)
            ->Where('status', 1)
            ->pluck('name', 'id');
    }

    //Prevent relation breaking
    public static function getRlationstatus($cid)
    {

        $count = \DB::table('users')
            ->WhereNull('deleted_at')
            ->WhereIn('groups', $cid)
            ->count();

        if ($count > 0) {
            return 1;
        } else {
            return 0;
        }

    }

}
