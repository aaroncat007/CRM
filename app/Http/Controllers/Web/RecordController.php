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

        if(Sentinel::check()){
            if($user = Sentinel::getUser())
            {

                $cateInfo = \App\categories::find($id);

                if(!isset($cateInfo)){
                    return redirect()->route('web.index');
                }

                $cateParents = \App\categories::where('id',$cateInfo->parent_categories)->select('title')->first();

                $data = \App\Record::where('categories_id',$id)
                                    ->where('user_id',$user->id)
                                    ->select('id','title','content','updated_at')
                                    ->get();

                foreach ($data as $d) {
                    $d->content = mb_substr(strip_tags($d->content),0,100);
                }

                return view('RecordIndex',['cateInfo' => $cateInfo,'cateParents' => $cateParents,'data' => $data]);
            }
        }


        return redirect()->route('web.index');
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

        if(Sentinel::check()){
            if($user = Sentinel::getUser())
            {

                $data = \App\Record::where('id',$id)
                                    ->where('user_id',$user->id)
                                    ->first();

                return view('RecordPartial',['data' => $data]);
            }
        }

        return view('RecordPartial');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        if(!isset($id)){
            return redirect()->route('web.index');
        }

        $cateInfo = \App\categories::find($id);

        if(!isset($cateInfo)){
            return redirect()->route('web.index');
        }

        $cateParents = \App\categories::where('id',$cateInfo->parent_categories)->select('title')->first();

        return view('RecordCreate',['cateInfo' => $cateInfo , 'cateParents' => $cateParents]);

    }


    public function CreateDoAdd()
    {

        if(Sentinel::check()){
            if($user = Sentinel::getUser())
            {

                $cate_id  = Input::get('cate_id');
                $title   = Input::get('title');
                $content    = Input::get('content');


                $cateInfo = \App\categories::find($cate_id);

                if(!isset($cateInfo)){
                    return back()->withInput();
                }

                $data = [
                    'categories_id'=>  $cate_id,
                    'user_id'     =>  $user->id,
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
        }

        return back()->withInput();


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
        if(Sentinel::check()){
            if($user = Sentinel::getUser())
            {
                $data = \App\Record::where('id',$id)->where('user_id',$user->id)->first();

                $cateInfo = $data->categories;

                if(!isset($cateInfo)){
                    return back();
                }

                $cateParents = \App\categories::where('id',$data->categories->parent_categories)->select('title')->first();

                return view('RecordEdit',['data' => $data,'cateInfo' => $cateInfo , 'cateParents' => $cateParents]);
            }
        }
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

        if(Sentinel::check()){
            if($user = Sentinel::getUser())
            {
                $data = \App\Record::where('id',$id)->where('user_id',$user->id)->first();

                if(!isset($data)){
                    return back()->withInput();
                }

                $data->title = $title;
                $data->content = $content;

                $data->save();

                return redirect()->route('record.index',$data->categories_id);
            }
        }
        return back();
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
        if(Sentinel::check()){
            if($user = Sentinel::getUser())
            {
                $data = \App\Record::where('id',$id)->first();
                if(!isset($data)){
                    return Response()->json(['success' => false,'message' =>'查無此紀錄']);
                }

                if($data->user_id != $user->id){
                    return Response()->json(['success' => false,'message' =>'您沒有權限']);
                }

                $data->delete();
                return Response()->json(['success' => true,'message' =>'成功移除']);
            }
        }

        return Response()->json(['success' => false,'message' =>'您沒有權限']);
    }
}
