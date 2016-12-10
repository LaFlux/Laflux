<?php
namespace ExtensionsValley\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Extension extends Model
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'extension_manager';

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
    protected $fillable = ['name', 'vendor', 'description', 'version','is_paid','status','package_type','icon','update_url','author','website','contact_email'];



    public static function getExtensions()
    {

        return self::Where('deleted_at', NULL)
            ->Where('status', 1)
            ->pluck('name', 'vendor');
    }


}
