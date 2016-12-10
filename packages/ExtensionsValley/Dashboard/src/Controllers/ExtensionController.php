<?php
namespace ExtensionsValley\Dashboard;

use ExtensionsValley\Dashboard\Validators\GroupValidation;
use ExtensionsValley\Dashboard\Models\Extension;
use ExtensionsValley\Dashboard\Helpers\PackagerHelper;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ExtensionController extends Controller
{

    protected $helper;

    public function __construct(PackagerHelper $helper)
    {

        $this->helper = $helper;
    }

    public function getIndex()
    {

        $title = 'Extension Manager';

        if (\Auth::guard('admin')->user()->groups != 1) {
            return redirect('admin/dashboard')->with(['error' => 'Unauthorized action detected']);
        }

        $extensions = Extension::WhereNull('deleted_at')->orderBy('id','DESC');
        $full_extensions = $extensions->get();

        if(\Input::has('status')){
            $extensions = $extensions->Where('status',\Input::get('status'));
        }

        $extensions = $extensions->get();

        return \View::make('Dashboard::extension.default', compact('title','extensions','full_extensions'));
    }

    public function uploadPackage(Request $request){

        if (\Auth::guard('admin')->user()->groups != 1) {
            return redirect('admin/dashboard')->with(['error' => 'Unauthorized action detected']);
        }

        if($request->hasFile('zipfile')){

            $validation = \Validator::make($request->all()
                , ['zipfile' => "required|mimes:zip"]);
            if ($validation->fails()) {
                return redirect()->route('extensionsvalley.admin.addnewpackage')
                ->withErrors($validation)->withInput();
            }
            $destinationPath = "packages/extensionsvalley/dashboard/packages/";
            $final_location = $destinationPath;
           /* if(!\File::cleanDirectory(base_path().DIRECTORY_SEPARATOR.$final_location)){
                 return redirect()->route('extensionsvalley.admin.addnewpackage')
                    ->with(['error' => 'unable to clean upload directory!']);
            }*/
            $file_name = $request->file('zipfile')->getClientOriginalName();
            $request->file('zipfile')->move($final_location, $file_name );
            $path  = $final_location . $file_name;

        try{
            ## EXtract the Zip file and read the composer json then move to packages dir
            $file = $path;
            $path = $final_location;
            $zip = new \ZipArchive;
            $res = $zip->open($file);
            if ($res === TRUE) {
              $zip->extractTo($path);
              $extracted_folder_name =  trim($zip->getNameIndex(0), '/');
              $zip->close();
              $extracted_folder_name = $final_location . $extracted_folder_name;
              $response =  $this->ExtractDetails($extracted_folder_name);
              if(!is_writable( base_path().DIRECTORY_SEPARATOR."packages")){
                return redirect()->route('extensionsvalley.admin.addnewpackage')->with(['error' => 'Folder Permission issue! check the Permission of packages folder !'] );
              }

              if($response == "insert" || $response == "update"){
                  if($this->MovePackages($extracted_folder_name)
                        && $this->firePackageAction($extracted_folder_name,$response)){
                    $this->RemoveUploadedfiles($extracted_folder_name,$file);
                  }
              }
              switch($response){

                    case 'error1' :
                                    $this->RemoveUploadedfiles($extracted_folder_name,$file);
                                    return redirect()->route('extensionsvalley.admin.addnewpackage')->with(['error' => 'Composer json is invalid and unable to parse!' ] );
                                    break;
                    case 'error2' :
                                    $this->RemoveUploadedfiles($extracted_folder_name,$file);
                                    return redirect()->route('extensionsvalley.admin.addnewpackage')->with(['error' => 'Invalid Package format composer.json not found !' ] );
                                    break;
                    case 'error3' :
                                    $this->RemoveUploadedfiles($extracted_folder_name,$file);
                                    return redirect()->route('extensionsvalley.admin.addnewpackage')->with(['error' => 'Invalid Package format composer.json not found !' ] );
                                    break;
                    case 'insert' :
                                    return redirect()->route('extensionsvalley.admin.addnewpackage')->with(['message' => 'File uploaded successfully . Activate using Manage Extension' ] );
                                    break;
                    case 'update' :
                                    return redirect()->route('extensionsvalley.admin.addnewpackage')->with(['message' => 'Package update successfully Enjoy new features!' ] );
                                    break;
              }
            } else {

              return redirect()->route('extensionsvalley.admin.addnewpackage')->with(['error' => 'The zip file unable to extract please check the zip file is not corrupted' ] );
              exit;
            }
        }catch(Exception $e){
             return redirect()->route('extensionsvalley.admin.addnewpackage')->with(['error' => 'The zip file unable to extract please check the zip file is not corrupted'.$e->getMessage() ] );
              exit;
        }


            return redirect()->route('extensionsvalley.admin.addnewpackage')->with(['message' => 'File uploaded successfully . Activate using Manage Extension' ] );
        }else{
            $validation = \Validator::make($request->all()
                , ['zipfile' => "required|mimes:zip"]);
            if ($validation->fails()) {
                return redirect()->route('extensionsvalley.admin.addnewpackage')->withErrors($validation)->withInput();
            }
        }

    }

    public function firePackageAction($file_path,$action){

       $package_details =  PackagerHelper::getPackageInfo($file_path);
       if(sizeof($package_details)){
            $pkgdata = explode("/",$package_details->name);
            $className = str_replace("/",'\\',$package_details->name).'\\Helpers\\PackageAction';
            if(class_exists($className)){

                if($action == "insert" && method_exists($className,'install')){
                    with(new $className)->install();
                }
                if($action == "update" && method_exists($className,'update')){

                    if($package_details->packagetype === "Core Theme"
                        || $package_details->packagetype === "laflux-theme"){
                         with(new $className)->update();
                    }else{
                        if(function_exists('exec')) {
                            exec('composer dumpautoload -o');
                        }
                        $serviceProvider = $pkgdata[0]."\\".$pkgdata[1]."\\"
                                    .$pkgdata[1]."ServiceProvider";
                        \Artisan::call('vendor:publish', ["--force"=> true
                            ,"--provider" => $serviceProvider]);
                        if(function_exists('exec')) {
                            exec('composer dumpautoload -o');
                        }
                        \Artisan::call('migrate', ["--force"=> true ]);
                        with(new $className)->update();
                    }
                }
                return true;

            }else{
                return true;
            }
       }else{
            return false;
       }

    }

    public function RemoveUploadedfiles($file_path,$zip_file){

        if(file_exists($zip_file)){
               unlink($zip_file);
        }

        if(file_exists($file_path)){
              \File::deleteDirectory($file_path);
        }
    }

    public function MovePackages($file_details){

        ##Check Vendor folder exists or not
        $ds = DIRECTORY_SEPARATOR;
        $file_path = str_replace(".zip", "", $file_details);
        if(file_exists($file_path."/composer.json")){
            $json_data = file_get_contents($file_path."/composer.json");
            $parseData = json_decode($json_data);
            $package_details = explode("/",$parseData->name);
            $destination = base_path().$ds."packages".$ds.$package_details[0]
                                .$ds.$package_details[1].$ds;
            $dest_folder = base_path().$ds."packages".$ds.$package_details[0]
                                .$ds.$package_details[1];
            $sourceDir = str_replace(".zip", "", $file_details);

            try{
                ## TODO need to check this section on server
                if(!is_dir($dest_folder)){
                     mkdir($dest_folder, 0777, true);
                }
                if(file_exists($destination)){
                        if(is_writable( base_path().$ds."packages")){
                            return \File::copyDirectory($sourceDir, $destination);
                        }else{
                             return redirect()->route('extensionsvalley.admin.addnewpackage')->with(['error' => 'Folder Permission issue! check the Permission of packages folder !'] );
                             exit;
                        }
                }
                ## @chmod($dest_folder, 0755);

            }catch(Exception $e){
                return redirect()->route('extensionsvalley.admin.addnewpackage')->with(['error' => 'Folder Permission issue! check ownership of packages folder !'.$e->getMessage() ] );
            }




        }
    }

    public function ExtractDetails($file_path){

        $file_path = str_replace(".zip", "", $file_path);
        if(file_exists($file_path."/composer.json")){
            $json_data = file_get_contents($file_path."/composer.json");
            $parseData = json_decode($json_data);
            if(sizeof($parseData)){
               $status =  $this->insertPackage($parseData,$file_path);
               return $status;
            }else{
                return 'error1';
                exit;
            }
        }else{
            return 'error2';
                exit;
        }

    }

    public function insertPackage($data,$file_path){


        try{
            $ds = DIRECTORY_SEPARATOR;
            $package_details = explode("/",$data->name);
            $pack_name = !empty($package_details[1]) ? $package_details[1] : 0;
            $vendor = !empty($package_details[0]) ? $package_details[0] : 0;
            $version = !empty($data->version) ? $data->version : "1.0";
            $paid = !empty($data->paid) ? $data->paid : 0 ;
            $paid = ($paid == "true") ? 1 : 0;
            $packagetype = !empty($data->type) ? $data->type : "Packages";
            $description = !empty($data->description) ? $data->description : "";
            $updatelink = !empty($data->updatelink) ? $data->updatelink : "";
            $website = !empty($data->homepage) ? $data->homepage : "";
            $file_path = $file_path."/icon.png";
            if(file_exists($file_path)){
                $dest =  public_path().$ds."packages/extensionsvalley/dashboard/package_icons";
                if(!is_dir($dest)){
                     mkdir($dest, 0777, true);
                }

                $icon_name = time().".png";
                if(file_exists($dest.$ds)){
                    if(is_writable($dest))
                    \File::copy(public_path().$ds.$file_path, $dest.$ds.$icon_name);
                }
                $icon = "packages/extensionsvalley/dashboard/package_icons".$ds.$icon_name;
            }else{
                $icon = "";
            }
            $autor_name = "";
            $author_email = "";
            if(sizeof($data->authors)){
                foreach($data->authors as $values){
                    $autor_name .= $values->name." ";
                    $author_email .= $values->email." ";
                }
            }

            if($pack_name !== 0 && $vendor !== 0){

                $exists = Extension::WhereNull('deleted_at')
                            ->Where('name',$pack_name)
                            ->Where('vendor',$vendor)
                            ->first();
                if(sizeof($exists)){
                    ##unlink old package icon
                    if(file_exists($exists->icon)){
                        unlink($exists->icon);
                    }
                    Extension::WhereNull('deleted_at')->Where('name',$pack_name)->Where('vendor',$vendor)->update([
                        'version' => $version
                        ,'icon' => $icon
                        ,'description' => $description
                        ,'is_paid' => $paid
                        ,'status' => 0
                        ,'package_type' => $packagetype
                        ,'update_url' => $updatelink
                        ,'website' => $website
                        ,'author' => substr($autor_name, 0,250)
                        ,'contact_email' => substr($author_email, 0,250)
                        ]);

                  return "update";

                }else{

                    Extension::Create([
                        'name' => $pack_name
                        ,'vendor' => $vendor
                        ,'version' => $version
                        ,'icon' => $icon
                        ,'status' => 0
                        ,'package_type' => $packagetype
                        ,'description' => $description
                        ,'is_paid' => $paid
                        ,'update_url' => $updatelink
                        ,'website' => $website
                        ,'author' => substr($autor_name, 0,250)
                        ,'contact_email' => substr($author_email, 0,250)
                        ]);
                  return "insert";
                }
            }else{
                return 'error1';
                exit;
            }
        }catch (Exception $e) {
              return 'error1';
              exit;
        }

    }

    public function addNewPackage(){

         $title = 'Install New Package';
         if (\Auth::guard('admin')->user()->groups != 1) {
            return redirect('admin/dashboard')->with(['error' => 'Unauthorized action detected']);
         }
         return \View::make('Dashboard::extension.addnewpackage', compact('title'));
    }

    public function checkPrivilage(){
         if (\Auth::guard('admin')->user()->groups != 1) {
            return redirect('admin/dashboard')->with(['error' => 'Unauthorized action detected']);
         }
    }

    public function activatePackage($package_id){

        if (\Auth::guard('admin')->user()->groups != 1) {
            return redirect('admin/dashboard')->with(['error' => 'Unauthorized action detected']);
        }

        $packageinfo = Extension::WhereNull('deleted_at')->Where('id',$package_id)->first();

        if($packageinfo->package_type == "laflux-theme"){

          $active_theme =  Extension::WhereNull('deleted_at')
                ->Where('package_type','laflux-theme')
                ->Where('status',1)
                ->Where('name','<>','Basetheme')
                ->count();
                if($active_theme > 0){
                   return redirect()->route('extensionsvalley.admin.manageextension')->with(['warning' => 'Please make sure you deactivated the current active theme before activating another theme!']);
                   exit;
                }
        }

        $current_jsn_txt = '"'.$packageinfo->vendor.'\\\\'.$packageinfo->name.'\\\\": "packages/'
                .$packageinfo->vendor.'/'.$packageinfo->name.'/src",';

        $current_cng_txt = $packageinfo->vendor."\\".$packageinfo->name."\\"
                                .$packageinfo->name."ServiceProvider::class,";
        $composer_json_text = '"psr-4": {
            "'.$packageinfo->vendor.'\\\\'.$packageinfo->name.'\\\\": "packages/'
                .$packageinfo->vendor.'/'.$packageinfo->name.'/src",';

        $service_provider_text = $packageinfo->vendor."\\".$packageinfo->name."\\"
                                .$packageinfo->name."ServiceProvider::class,\r\n";
        $serviceProvider = $packageinfo->vendor."\\".$packageinfo->name."\\"
                                .$packageinfo->name."ServiceProvider";
        $service_provider_text .= "ExtensionsValley\Dashboard\DashboardServiceProvider::class,";

        $error_message =  "";
        if(is_writable(base_path().'/composer.json')){
            $this->helper->replaceAndSave(base_path().'/composer.json', $current_jsn_txt
                        , '');
            $this->helper->replaceAndSave(base_path().'/composer.json', '"psr-4": {'
                        , $composer_json_text);
        }else{
            $error_message = "Unable to write to composer.json! Permission denied.<br/>";
        }
        if(is_writable(base_path().'/config/app.php')){
           $this->helper->replaceAndSave(base_path().'/config/app.php',$current_cng_txt,'');
           $this->helper->replaceAndSave(base_path().'/config/app.php', 'ExtensionsValley\Dashboard\DashboardServiceProvider::class,', $service_provider_text);
        }else{
            $error_message = "Unable to write to Config/app.php Permission denied.<br/>";
        }


            @\Artisan::call('vendor:publish', ["--tag" => "public","--force"=> true ,"--provider" => $serviceProvider]);
            @\Artisan::call('vendor:publish', ["--force"=> true ,"--provider" => $serviceProvider]);
            if(function_exists('exec')) {
                exec('composer dumpautoload -o');
            }else{
                $error_message .= "Unable to run composer dumpautoload -o command.<br/>";
            }
            @\Artisan::call('migrate', ["--force"=> true ]);



        if(trim($error_message) != ""){
             return redirect()->route('extensionsvalley.admin.manageextension')
                        ->with(['error' => $error_message ] );
        }else{

            Extension::Where('id',$package_id)->update(['status' => 1]);
            return redirect()->route('extensionsvalley.admin.manageextension')->with(['message' => 'Package Activated' ] );
        }
    }

    public function disablePackage($package_id){

        if (\Auth::guard('admin')->user()->groups != 1) {
            return redirect('admin/dashboard')->with(['error' => 'Unauthorized action detected']);
        }

        $packageinfo = Extension::WhereNull('deleted_at')->Where('id',$package_id)->first();

        $composer_json_text = '"'.$packageinfo->vendor.'\\\\'.$packageinfo->name.'\\\\": "packages/'.$packageinfo->vendor.'/'.$packageinfo->name.'/src",';

        $service_provider_text = $packageinfo->vendor."\\".$packageinfo->name."\\"
                                .$packageinfo->name."ServiceProvider::class,";

        $error_message =  "";
        if(@chmod(base_path().'/composer.json',0777)){
            $this->helper->replaceAndSave(base_path().'/composer.json', $composer_json_text, '');
            @chmod(base_path().'/composer.json',0755);
        }else{
            $error_message = "Unable to write to composer.json! Permission denied.<br/>";
        }
        if(@chmod(base_path().'/config/app.php',0777)){
           $this->helper->replaceAndSave(base_path().'/config/app.php', $service_provider_text,'');
           @chmod(base_path().'/config/app.php',0755);
        }else{
            $error_message = "Unable to write to composer.json! Permission denied.<br/>";
        }

        if(function_exists('exec')) {
            exec('composer dumpautoload -o');
        }else{
            $error_message .= "Unable to run composer dumpautoload -o command.<br/>";
        }

        if(trim($error_message) != ""){
             return redirect()->route('extensionsvalley.admin.manageextension')
                        ->with(['error' => $error_message ] );
        }else{

            Extension::Where('id',$package_id)->update(['status' => 0]);

            return redirect()->route('extensionsvalley.admin.manageextension')->with(['warning' => 'Package Deactivated successfully!' ] );
        }
    }



    public function uninstallPackage($package_id){

        if (\Auth::guard('admin')->user()->groups != 1) {
            return redirect('admin/dashboard')->with(['error' => 'Unauthorized action detected']);
        }

        $ds = DIRECTORY_SEPARATOR;
        $packageinfo = Extension::WhereNull('deleted_at')->Where('id',$package_id)->first();

         ## Trigger Remove scripts for DB
        $className = $packageinfo->vendor.'\\'.$packageinfo->name.'\\Helpers\\PackageAction';
        if(class_exists($className)){

            if(method_exists($className,'uninstall')){
                with(new $className)->uninstall();
                ## Remove all migrations table entries related to this component
                $folder_path = base_path().$ds."packages".$ds.$packageinfo->vendor.$ds.$packageinfo->name.$ds."src".$ds."database".$ds."migrations";
                $files = \File::allFiles($folder_path);
                $migration_files = [];
                foreach ($files as $file){
                    $file_name  = explode("/",$file);
                    $migration_files[] = str_replace(".php","",$file_name[sizeof($file_name)-1]);
                }
                \DB::table('migrations')->WhereIn('migration',$migration_files)->delete();

            }


        }

        ##unlink old package icon
        if(file_exists($packageinfo->icon)){
            unlink($packageinfo->icon);
        }

        $file_path = base_path().$ds."packages".$ds.$packageinfo->vendor.$ds.$packageinfo->name;

        if($packageinfo->package_type == "laflux-theme"){
            $public_asset = base_path().$ds."public".$ds."template".$ds.strtolower($packageinfo->vendor).$ds.strtolower($packageinfo->name);
            ##Remove public assests of theme
            if(file_exists($public_asset)){
                @\File::deleteDirectory($public_asset);
            }
            $resouces_view = base_path().$ds."resources".$ds."template".$ds.strtolower($packageinfo->vendor).$ds.strtolower($packageinfo->name);
            ##Remove public assests of theme
            if(file_exists($resouces_view)){
                @\File::deleteDirectory($resouces_view);
            }
        }

        ## Remove Package folder
        if(file_exists($file_path)){
              if(\File::deleteDirectory($file_path)){

                Extension::WhereNull('deleted_at')->Where('id',$package_id)->delete();
                return redirect()->route('extensionsvalley.admin.manageextension')->with(['warning' => 'Package uninstalled successfully!' ] );

             }else{
                 return redirect()->route('extensionsvalley.admin.manageextension')->with(['warning' => 'Package cannot be uninstall Permission denied!' ] );

             }
        }else{
             return redirect()->route('extensionsvalley.admin.manageextension')->with(['error' => 'unable to remove package!' ] );

        }


    }


}
