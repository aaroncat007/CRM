<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;

use DB;
use App\Http\Requests;
use Sentinel;  
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class RecordController extends Controller
{

    private $user;

    private $categories;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        if(!isset($id)){
            return redirect()->route('web.index');
        }

        if($this->AuthAccess($id)){

            $cateInfo = \App\categories::find($id);

            if(!isset($cateInfo)){
                return redirect()->route('web.index');
            }

            $cateParents = \App\categories::where('id',$cateInfo->parent_categories)->select('title')->first();

            $data = \App\record::where('categories_id',$id)
                                ->where('user_id',$this->user->id)
                                ->select('id','title','content','updated_at')
                                ->orderBy('created_at', 'desc')
                                ->get();

            foreach ($data as $d) {
                $d->content = mb_substr(strip_tags(html_entity_decode($d->content)),0,100);
            }

            return view('record.RecordIndex',['cateInfo' => $cateInfo,'cateParents' => $cateParents,'data' => $data]);
            
        }

        return redirect()->route('web.index')->withErrors('您沒有權限存取此類別');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!isset($id)){
            return view('RecordPartial');
        }

        if($this->AuthAccess($id)){

            $data = \App\record::where('id',$id)
                                ->where('user_id',$this->user->id)
                                ->first();

            return view('record.RecordPartial',['data' => $data]);
        }

        return view('record.RecordPartial')->withErrors('您沒有權限存取此類別');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        if(!isset($id)){
            return redirect()->back()->withErrors('查無此類別');
        }

        if(!$this->AuthAccess($id)){
            return redirect()->back()->withErrors('您沒有權限存取此類別');
        }

        $cateInfo = \App\categories::find($id);

        if(!isset($cateInfo)){
            return redirect()->route('web.index');
        }

        $cateParents = \App\categories::where('id',$cateInfo->parent_categories)->select('title')->first();

        return view('record.RecordCreate',['cateInfo' => $cateInfo , 'cateParents' => $cateParents]);

    }


    public function CreateDoAdd()
    {

        $cate_id  = Input::get('cate_id');
        $title   = Input::get('title');
        $content    = Input::get('content');


        if($this->AuthAccess($cate_id)){

            $cateInfo = \App\categories::find($cate_id);

            if(!isset($cateInfo)){
                return back()->withInput()->withErrors('查無此資料');
            }

            $data = [
                'categories_id'=>  $cate_id,
                'user_id'     =>  $this->user->id,
                'title'  =>  $title,
                'content' => htmlentities($content)
            ];

            $ins = \App\record::create($data);

            if(isset($ins)){
                return redirect()->route('record.index',$cate_id);
            }else{
                return back()->withInput();
            }
            
        }

        return back()->withInput()->withErrors('您沒有權限存取此類別');

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!isset($id)){
            return back();
        }

        $data = \App\record::where('id',$id)->first();

        if(!isset($data)){
            return back()->withInput()->withErrors('查無此資料');
        }

        if($this->AuthAccess($data->categories_id)){
            
            if($data->user_id != $this->user->id)
            {
                return back()->withInput()->withErrors('您不是作者，沒有權限修改');
            }

            $cateInfo = $data->categories;

            if(!isset($cateInfo)){
                return back()->withInput()->withErrors('發生錯誤，請重試');
            }

            $cateParents = \App\categories::where('id',$data->categories->parent_categories)->select('title')->first();

            return view('record.RecordEdit',['data' => $data,'cateInfo' => $cateInfo , 'cateParents' => $cateParents]);
        }

        return back()->withInput()->withErrors('您沒有權限存取此類別');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function Doedit()
    {

        $id  = Input::get('id');
        $title   = Input::get('title');
        $content    = Input::get('content');

        $data = \App\record::where('id',$id)->first();

        if(!isset($data)){
            return back()->withInput()->withErrors('查無此資料');
        }

        if($this->AuthAccess($data->categories_id)){

            if($data->user_id != $this->user->id)
            {
                return back()->withInput()->withErrors('您不是作者，沒有權限修改');
            }

            $data->title = $title;
            $data->content = $content;

            $data->save();

            return redirect()->route('record.index',$data->categories_id);
            
        }
        return back()->withInput()->withErrors('您沒有權限存取此類別');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DoDel()
    {
        $id = Input::get('id');

        $data = \App\record::where('id',$id)->first();
        if(!isset($data)){
            return Response()->json(['success' => false,'message' =>'查無此紀錄']);
        }

        if($this->AuthAccess($data->categories_id)){

            if($data->user_id != $user->id){
                return Response()->json(['success' => false,'message' =>'您沒有權限']);
            }

            $data->delete();
            return Response()->json(['success' => true,'message' =>'成功移除']);
            
        }

        return Response()->json(['success' => false,'message' =>'您沒有權限']);
    }



    private function AuthAccess($cate_id){
        $this->categories = \App\categories::find($cate_id);
        if(Sentinel::check()){
            if($this->user = Sentinel::getUser())
            {
                //管理員身份
                if(Sentinel::inRole('SuperAdmin') || Sentinel::inRole('Admin'))
                {
                    return true;
                }
                else//其他身份
                {        
                    //查詢分類的主類別
                    $data = \App\categories_auth::where('categories_id',$this->categories->parent_categories)
                                                ->where('user_id',$this->user->id)
                                                ->first();

                    if(!isset($data)){
                        return false;
                    }

                    $AuthList = json_decode($data->permissions);
                    if($AuthList->record == true){
                        return true;
                    }
                }
            }
        }
        return false;
    }
}
