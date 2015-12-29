<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Sentinel;
use Activation;
use Illuminate\Support\Facades\Input;

class ManageController extends Controller
{

    public function index()
    {
        return view('manage.index');
    }

    /**
     * 帳號首頁
     *
     * @return \Illuminate\Http\Response
     */
    public function accountIndex()
    {
        $userData = \App\User::whereHas('roles',function($query){

            $query->where('slug','<>','SuperAdmin');

        })->get();

        return view('manage.accountIndex',['userData' => $userData]);
    }

    public function accountAddView()
    {
        return view('manage.accountAdd');
    }

    public function accountDoAdd()
    {
        $user_name  = Input::get('user_name');
        $user_account   = Input::get('user_account');
        $userPwd    = Input::get('user_pwd');
        $activated  = Input::get('activated');


        $credentials = [
            'first_name'=>  $user_name,
            'email'     =>  $user_account,
            'password'  =>  $userPwd
        ];

        $checkCreate = Sentinel::findByCredentials($credentials);
        if(isset($checkCreate)){

            return Response()->json(['success' => false,'message'=>'重複帳號' ]);
        }

        try {
            
            $user = Sentinel::create($credentials);

            if($user == true){
                // 加入角色
                $role = Sentinel::findRoleBySlug('User');  
                $role->users()->attach($user);  

                // 啟用帳號 
                if(isset($activated) || $activated == 1){
                  
                    $activation = Activation::create($user);  
                    Activation::complete($user, $activation->code); 

                }
                return Response()->json(['success' => true,'message' => 'Account Create Success.']);
            }
            else{
                return Response()->json(['success' => false,'message'=>'建立失敗' ]);
            }
                
        } catch (\Cartalyst\Sentinel\Checkpoints\NotActivatedException $e) {
            return Response()->json(['success' => false,'message'=>'Account Not Activated.' ]);
        }

    }

    public function accountEditView($id)
    {
        $userData = \App\User::find($id);
        if(!isset($userData))
        {
            return  Response()->json(['message'=>'Account Not Exists.' ]);
        }
        return view('manage.accountEdit',['userData' => $userData]);
    }

    public function accountDoEdit()
    {
        $id = Input::get('id');
        $user_name = Input::get('user_name');
        $user_pwd = Input::get('user_pwd');
        $activated = Input::get('activated');

        //確認帳號存在
        $user = Sentinel::findById($id);
        if(!isset($user))
        {
            return  Response()->json(['message'=>'Account Not Exists.' ]);
        }

        $update = [
            'first_name' => $user_name
        ];

        if(isset($user_pwd)){
            $update = array_add($update,'password',$user_pwd);
        }

        //修改
        Sentinel::update($user,$update);

        //修正啟用,停用
        $act = \App\activations::where('user_id',$id)->update(['completed' => $activated]);

        return Response()->json(['success' => true,'message' => 'Account was Update.']);

    }
    
    public function accountDoDel()
    {
        $id = Input::get('id');

        $user = \App\User::find($id);
        if(isset($user)){
            $user->delete();
            return Response()->json(['success' => true,'message' => '刪除成功']);
        }
        return Response()->json(['success' => false,'message' => '刪除失敗']);

    }


    /*
     *
     *  板塊管理
     * 
     */


    public function categoriesIndex(){
        $categoriesData = \App\categories::class;

        $mainfilter = $categoriesData::whereNull('parent_categories')->get();

        $resultData = collect([]);

        foreach ($mainfilter as $main) {
            $sub = $categoriesData::where('parent_categories',$main->id)->get();
            $subCount = 0;

            foreach ($sub as $key) {
                $subCount += $key->categories_auth->count();
            }

            $data = collect([
                'main' => $main,
                'sub'  => $sub,
                'subCount' => $subCount
            ]);
            $resultData->push($data);
        }

        return view('manage.categoriesIndex',['categoriesData' => $resultData]);
    }

    public function CategoriesAddView($parent_id = null){
        if(isset($parent_id)){
            $data = \App\categories::find($parent_id);
            if(isset($data)){
                $parent = collect([
                    'name'  =>  $data->title,
                    'id'    =>  $data->id
                ]);
                return view('manage.categoriesAdd',['parent' => $parent]);
            }
        }
        return view('manage.categoriesAdd');
    }

    public function categoriesDoAdd(){
        $cateName = Input::get('cateName');
        $parent_id = Input::get('parent_id');
        $catedesc = Input::get('catedesc');
        $activated = Input::get('activated');

        $data = [
            'title'         =>  $cateName,
            'description'   =>  $catedesc
        ];

        if(isset($parent_id)){
            $check = \App\categories::find($parent_id);
            if(!isset($check)){
                return Response()->json(['success' => false,'message' => '查無主類別']);
            }
            $data = array_add($data,'parent_categories',$parent_id);
        }

         // 啟用類別
        if(!isset($activated) || $activated == 0){
          
            $data = array_add($data,'deactivate',time());

        }

        $ins = \App\categories::create($data);

        if(isset($ins->id)){
            return Response()->json(['success' => true,'message' => '新增成功']);
        }
        else{
            return Response()->json(['success' => false,'message' => '新增失敗']);
        }
    }

    public function categoriesEditView($id){
        $data = \App\categories::find($id);
        if(!isset($data))
        {
            return  Response()->json(['message'=>'Categories Not Exists.' ]);
        }

        $parents = NULL;
        if(isset($data->parent_categories)){
            $parents = \App\categories::find($data->parent_categories);
            return view('manage.categoriesEdit',['data' => $data,'parent' => $parents]);
        }
        return view('manage.categoriesEdit',['data' => $data]);
    }

    public function categoriesDoEdit(){
        $id       = Input::get('id');
        $cateName = Input::get('cateName');
        $catedesc = Input::get('catedesc');
        $activated = Input::get('activated');

        $cateData = \App\categories::find($id);

        if(!isset($cateData)){
            return  Response()->json(['message'=>'Categories Not Exists.' ]);
        }

        $cateData->title = $cateName;
        $cateData->description = $catedesc;

        if(!isset($activated) || $activated == 0){
            $cateData->deactivate = time();
        }
        else{
            $cateData->deactivate = NULL;
        }

        $cateData->save();

        return Response()->json(['success' => true,'message' => 'Categories was Update.']);
    }

    public function categoriesDoDel(){
        $id = Input::get('id');

        $data = \App\categories::find($id);
        if(isset($data)){
            $data->delete();
            return Response()->json(['success' => true,'message' => '刪除成功']);
        }
        return Response()->json(['success' => false,'message' => '刪除失敗']);
    }




/*
 *
 * 板塊權限管理
 * 
 */

public function CategoriesAuthIndex($uid){
    $user = \App\User::find($uid);

    if(!isset($user)){
        return Response()->json(['success' => false,'message' =>'查無此帳號']);
    }

    $authList = \App\categories_auth::where('user_id',$uid)->get();

    return view('manage.categoriesAuthIndex',['user' => $user , 'authList' => $authList]);

}

public function CategoriesAuthAddView($uid){
    $user = \App\User::find($uid);
    if(!isset($user)){
        return Response()->json(['success' => false,'message' =>'查無此帳號']);
    }

    $categoryList = \App\categories::whereNull('parent_categories')->whereNull('deactivate')->lists('title','id');

    return view('manage.categoriesAuthAdd',['user' => $user , 'categoryList' => $categoryList]);

}

public function CategoriesAuthDoAdd(){
    $uid = Input::get('uid');
    $category = Input::get('category');

    $user = \App\User::find($uid);
    if(!isset($user)){
        return Response()->json(['success' => false,'message' =>'查無此帳號']);
    }

    $cate = \App\categories::find($category);
    if(!isset($cate)){
        return Response()->json(['success' => false,'message' =>'查無此類別']);
    }

    //查詢是否已經加入過
    //
    
    $check = \App\categories_auth::where('user_id',$uid)->where('categories_id',$category)->first();
    if(isset($check)){
        return Response()->json(['success' => false,'message' =>'該用戶已授權']);
    }

    //加入授權
    //

    $add = [
        'categories_id' => $category,
        'user_id' => $uid,
        'permissions' => json_encode(array(  
                 'posts'       => true,  
                 'record'      => false,  
                ))
    ];

    $ins = \App\categories_auth::create($add);
    if(isset($ins->id)){
        return Response()->json(['success' => true,'message' => '新增成功']);
    }
    else{
        return Response()->json(['success' => false,'message' => '新增失敗']);
    }

}

public function CategoriesAuthDoDel(){
    $cate_id = Input::get('id');

    $data = \App\categories_auth::find($cate_id);
        if(isset($data)){
            $data->delete();
            return Response()->json(['success' => true,'message' => '刪除成功']);
        }
        return Response()->json(['success' => false,'message' => '刪除失敗']);
}


}


