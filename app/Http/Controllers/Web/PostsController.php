<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;

use App\Http\Requests;
use Sentinel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class PostsController extends Controller
{
    private $user ;
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

            $data = \App\posts::where('categories_id',$id)->get();

            return view('posts.PostsIndex',['cateInfo' => $cateInfo,'cateParents' => $cateParents,'data' => $data]);
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
            return back();
        }

        $data = \App\Posts::where('id',$id)->first();

        $cateInfo = $data->categories;

        if(!isset($cateInfo)){
            return back();
        }

        if(!$this->AuthAccess($cateInfo->id)){
            return redirect()->route('web.index');
        }

        $reply = $data->posts_reply;

        $cateParents = \App\categories::where('id',$data->categories->parent_categories)->select('title')->first();

        return view('posts.PostsShow',['userID' => $this->user->id,'data' => $data,'reply' => $reply,'cateInfo' => $cateInfo , 'cateParents' => $cateParents]);
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

        if(!$this->AuthAccess($id)){
            return redirect()->route('web.index');
        }

        $cateInfo = \App\categories::find($id);

        if(!isset($cateInfo)){
            return redirect()->route('web.index');
        }

        $cateParents = \App\categories::where('id',$cateInfo->parent_categories)->select('title')->first();

        return view('posts.PostsCreate',['cateInfo' => $cateInfo , 'cateParents' => $cateParents]);

    }

    public function CreateDoAdd()
    {

        $cate_id  = Input::get('cate_id');
        $title   = Input::get('title');
        $content    = Input::get('content');

        if(!$this->AuthAccess($cate_id)){
            return back()->withInput()->withErrors('您沒有權限查詢此類別');
        }

        $cateInfo = \App\categories::find($cate_id);

        if(!isset($cateInfo)){
            return back()->withInput();
        }

        $data = [
            'categories_id'=>  $cate_id,
            'user_id'     =>  $this->user->id,
            'subject'  =>  $title,
            'content' => htmlentities($content)
        ];

        $ins = \App\posts::create($data);

        if(isset($ins)){
            return redirect()->route('posts.show',$ins->id);
        }else{
            return back()->withInput();
        }

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

        if(!$this->AuthAccess($id)){
            return back()->withInput()->withErrors('您沒有權限查詢此類別');
        }

        $data = \App\Posts::where('id',$id)->where('user_id',$this->user->id)->first();

        $cateInfo = $data->categories;

        if(!isset($cateInfo)){
            return back();
        }

        $cateParents = \App\categories::where('id',$data->categories->parent_categories)->select('title')->first();

        return view('posts.PostsEdit',['data' => $data,'cateInfo' => $cateInfo , 'cateParents' => $cateParents]);
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

        if(!$this->AuthAccess($id)){
            return back()->withInput()->withErrors('您沒有權限查詢此類別');
        }

        $data = \App\Posts::where('id',$id)->where('user_id',$this->user->id)->first();

        if(!isset($data)){
            return back()->withInput();
        }

        $data->subject = $title;
        $data->content = $content;

        $data->save();

        return redirect()->route('posts.show',$data->id);
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

        if(!$this->AuthAccess($id)){
            return Response()->json(['success' => false,'message' =>'您沒有權限']);
        }

        $data = \App\Posts::where('id',$id)->first();
        if(!isset($data)){
            return Response()->json(['success' => false,'message' =>'查無此紀錄']);
        }

        if($data->user_id != $this->user->id){
            return Response()->json(['success' => false,'message' =>'您沒有權限']);
        }

        $data->delete();
        return Response()->json(['success' => true,'message' =>'成功移除','goto' => route('posts.index').'/'.$data->categories_id]);
    }




///
///
///
///
/// 回覆功能
///
///
///
///
///



    public function ReplyAdd($id)
    {
        if(!isset($id)){
            return back();
        }

        $post = \App\posts::find($id);
        if(!isset($post)){
            return back();
        }

        if(!$this->AuthAccess($post->categories_id)){
            return back()->withErrors('您沒有權限查詢此類別');
        }

        $cateInfo = $post->categories;

        if(!isset($cateInfo)){
            return back();
        }

        $cateParents = \App\categories::where('id',$cateInfo->parent_categories)->select('title')->first();

        return view('posts.PostsReplyCreate',['post' => $post,'cateInfo' => $cateInfo , 'cateParents' => $cateParents]);
    }


    public function ReplyDoAdd()
    {

        $post_id  = Input::get('post_id');
        $content    = Input::get('content');

        $post = \App\posts::find($post_id);
        if(!isset($post)){
            return back()->withInput();
        }

        if(!$this->AuthAccess($post->categories_id)){
            return back()->withInput()->withErrors('您沒有權限查詢此類別');
        }

        $data = [
            'posts_id'=>  $post->id,
            'user_id'     =>  $this->user->id,
            'content' => htmlentities($content)
        ];

        $ins = \App\posts_reply::create($data);

        if(isset($ins)){
            return redirect()->route('posts.show',$post->id);
        }else{
            return back()->withInput();
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ReplyEdit($id)
    {
        if(!isset($id)){
            return back();
        }

        $data = \App\posts_reply::find($id);
        if(!isset($data)){
            return back();
        }

        $post = $data->posts;

        if(!$this->AuthAccess($post->categories_id)){
            return back()->withInput()->withErrors('您沒有權限查詢此類別');
        }

        if($data->user_id != $this->user->id){
            return back()->withInput()->withErrors('您不是作者,沒有權限編輯');
        }

        $cateInfo = $post->categories;

        if(!isset($cateInfo)){
            return back();
        }

        $cateParents = \App\categories::where('id',$cateInfo->parent_categories)->select('title')->first();

        return view('posts.PostsReplyEdit',['data' => $data,'post' => $post,'cateInfo' => $cateInfo , 'cateParents' => $cateParents]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ReplyDoedit()
    {

        $id  = Input::get('id');
        $content    = Input::get('content');

        $posts_reply = \App\posts_reply::find($id);

        if(!isset($posts_reply)){
            return back()->withInput()->withErrors('查無此資料');
        }

        $post = $posts_reply->posts;

        if(!$this->AuthAccess($post->categories_id)){
            return back()->withInput()->withErrors('您沒有權限查詢此類別');
        }

        if($posts_reply->user_id != $this->user->id)
        {
            return back()->withInput()->withErrors('您不是作者,沒有權限編輯');
        }

        $posts_reply->content = $content;

        $posts_reply->save();

        return redirect()->route('posts.show',$post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ReplyDel()
    {
        $id = Input::get('id');

        $posts_reply = \App\posts_reply::find($id);
        if(!isset($posts_reply)){
            return Response()->json(['success' => false,'message' =>'查無此紀錄']);
        }

        if(!$this->AuthAccess($posts_reply->posts->categories_id)){
            return Response()->json(['success' => false,'message' =>'您沒有權限']);
        }

        if($posts_reply->user_id != $this->user->id){
            return Response()->json(['success' => false,'message' =>'您沒有權限']);
        }

        $posts_reply->delete();
        return Response()->json(['success' => true,'message' =>'成功移除']);
    }




    private function AuthAccess($cate_id){
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
                    $data = \App\categories_auth::where('categories_id',$cate_id)
                                                ->where('user_id',$this->user->id)
                                                ->first();

                    if(!isset($data)){
                        return false;
                    }

                    $AuthList = json_decode($data->permissions);
                    if($AuthList->get('posts') == true){
                        return true;
                    }
                }
            }
        }
        return false;
    }
}
