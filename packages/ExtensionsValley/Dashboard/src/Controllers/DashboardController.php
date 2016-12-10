<?php
namespace ExtensionsValley\Dashboard;

use ExtensionsValley\Dashboard\Models\traits\DashboardTraits;
use Illuminate\Routing\Controller;
use ExtensionsValley\Dashboard\Models\WebSettings;
use Illuminate\Http\Request;


class DashboardController extends Controller
{

    use DashboardTraits;

    public function __construct()
    {

        $this->getNavigationBar();
        $this->getWidgets();
    }

    public function getDashboard()
    {

        $title = 'Dashboard';
        return \View::make('Dashboard::dashboard.index', compact('title'));
    }

    public function getBasicView($vendor,$namespace, $table_name)
    {

        $namespace = $vendor."\\" . str_replace(" ", "", ucwords(str_replace('-', " ", $namespace)));
        $table_name = $namespace . '\Tables\\' . ucfirst(str_replace("_", "", $table_name)) . "Table";

        $table = with(new $table_name);
        $table->vendor = $vendor;
        $table->namespace = $namespace;
        if (isset($table->overrideview)) {

            if (trim($table->overrideview) != "") {

                $partials_path = $table->overrideview;

            } else {

                $partials_path = "Dashboard::dashboard.partials.table";
            }


            return \View::make($partials_path, ['title' => $table->page_title
                , 'table' => $table,
            ]);
        }

    }

    public function getAjaxView($namespace, $table_name)
    {

        $namespace =  str_replace(" ", "", ucwords(str_replace('-', " ", $namespace)));

        $table_name = $namespace . '\Tables\\' . ucfirst(str_replace("_", "", $table_name)) . "Table";

        $table = with(new $table_name);

        return $table->getQuery();
    }

    public function getCommonAction()
    {

        $cid = \Input::get('cid');
        $action_type = \Input::get('action_type');
        $table_name = \Input::get('table_name');
        $acl_key = base64_decode(\Input::get('acl_key'));
        $model_name = base64_decode(\Input::get('model_name'));
        $return_url = base64_decode(\Input::get('return_url'));
        $mesaage = "Please select an actions to perform";

        if (\Schema::hasTable($table_name) && sizeof($cid) > 0) {

            $acl_status = 1;




            if ($action_type == "enable") {

                $model_name::whereIn('id', $cid)->update(array('status' => 1));
                $mesaage = "Records Published successfully";

            } elseif ($action_type == "disable") {

                $relation_status = $model_name::getRlationstatus($cid);

                if ($relation_status == 0) {

                    $model_name::whereIn('id', $cid)->update(array('status' => 0));
                    $mesaage = "Records Unpublished successfully";

                } else {
                    return redirect($return_url)->with(['error' => 'Sorry unable to update ! Some related records found.']);
                }

            } elseif ($action_type == "remove") {

                $relation_status = $model_name::getRlationstatus($cid);

                if ($relation_status == 0) {

                    $model_name::whereIn('id', $cid)->delete();
                    $mesaage = "Records Trashed successfully";

                } else {
                    return redirect($return_url)->with(['error' => 'Sorry unable to trash ! Some related records found, may be in Trashed list.']);
                }
            } elseif ($action_type == "restore") {

                    $model_name::whereIn('id', $cid)->restore();
                    $mesaage = "Records Restored successfully";


            } elseif ($action_type == "forcedelete") {

                    $model_name::whereIn('id', $cid)->forceDelete();
                    $mesaage = "Records Deleted successfully";


            } elseif ($action_type == "view") {

                $redirect_path = $model_name::$view_route;

                return redirect()->route($redirect_path, ['id' => $cid[0], 'return_url' => base64_encode($return_url)]);
            }

            if (method_exists($model_name, 'getCommonActionHandler')) {
                //Check Action function in modles.
                call_user_func_array([$model_name, 'getCommonActionHandler'], [$action_type, $cid]);
            }
            return redirect($return_url)->with(['message' => $mesaage]);

        } else {

            return redirect($return_url)->with(['error' => 'Unauthorized action detected !']);
        }

    }


    public function getSettings()
    {


        $title = 'General Settings';
        if (\Auth::guard('admin')->user()->groups != 1) {
            return redirect('admin/dashboard')->with(['error' => 'Unauthorized action detected']);
        }

        return \View::make('Dashboard::dashboard.settings', compact('title'));
    }

    public function updateSettings(Request $request)
    {

        $settings = \Input::get('settings');

        foreach ($settings as $key => $value) {

            if (\DB::table('gen_settings')->Where('settings_key', $key)->count()){
                \DB::table('gen_settings')->Where('settings_key', $key)
                ->update(['settings_value' => $value]);
            }else{
                WebSettings::Create(['settings_key' => $key, 'settings_value' => $value]);

            }
             ## Reset or update cache entries
            \Cache::forget($key);
            \Cache::forever($key, $value);

        }

        ## Validate Logo
        $validation = \Validator::make($request->all()
            , ['site_log' => 'mimes:jpeg,jpg,png,gif|max:10000'
                , 'fav_icon' => 'mimes:ico|max:1024'
            ]);
        if ($validation->fails()) {
            return redirect('admin/gensettings')->withErrors($validation)->withInput();
        }


        $media = "";
        if ($request->file('site_logo')) {
            $destinationPath = "packages/extensionsvalley/dashboard/images/";
            $final_location = $destinationPath;
            $file_name = "logo";
            $request->file('site_logo')->move($final_location, $file_name . '.' . $request->file('site_logo')->getClientOriginalExtension());
            $media = $final_location . $file_name . '.' . $request->file('site_logo')->getClientOriginalExtension()."?i=".rand(1,10);
        } else {
            $media = \WebConf::get('site_logo');
        }
        $favicon = "";
        if ($request->file('fav_icon')) {
            $destinationPath = "packages/extensionsvalley/dashboard/images/";
            $final_location = $destinationPath;
            $file_name = "favicon";
            $request->file('fav_icon')->move($final_location, $file_name . '.' . $request->file('fav_icon')->getClientOriginalExtension());
            $favicon = $final_location . $file_name . '.' . $request->file('fav_icon')->getClientOriginalExtension()."?i=".rand(1,10);
        } else {
            $favicon = \WebConf::get('fav_icon');
        }

        if ($media != "") {
            if (\WebConf::checkKey('site_logo')) {
                \DB::table('gen_settings')->Where('settings_key', 'site_logo')
                    ->update(['settings_value' => $media]);
            } else {
                WebSettings::Create([
                    'settings_key' => 'site_logo'
                    , 'settings_value' => $media
                ]);
            }
             ## Reset or update cache entries
            \Cache::forget('site_logo');
            \Cache::forever('site_logo', $media);
        }
        if ($favicon != "") {

            if (\WebConf::checkKey('fav_icon')) {
                \DB::table('gen_settings')->Where('settings_key', 'fav_icon')
                    ->update(['settings_value' => $favicon]);
            } else {
                WebSettings::Create([
                    'settings_key' => 'fav_icon'
                    , 'settings_value' => $favicon
                ]);
            }
             ## Reset or update cache entries
            \Cache::forget('fav_icon');
            \Cache::forever('fav_icon', $favicon);
        }

        return redirect('admin/gensettings')->with(['message' => 'Settings update successfully!']);
    }

}
