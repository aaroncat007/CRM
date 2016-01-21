 <?php

    /**  
    * Return User Name  
    *  
    * @return string  
    */  
 if( ! function_exists('getUserName'))
 {
 	function getUserName()
 	{
 		if(Sentinel::check())
 		{
 			if($user = Sentinel::getUser())
 			{
 				return $user->first_name . $user->last_name ;
 			}
 		}

 		return '';
 	}
 }


   /**  
    * Return breadcrumbs for each resource methods  
    *  
    * @return string  
    */  
if ( ! function_exists('breadcrumbs'))  
{  
   function breadcrumbs()  
   {  
     $route = Route::currentRouteName();  
     // get after last dot  
     $index = substr($route, 0, strrpos($route, '.') + 1) . 'index';  
     $breadcrumbs = '<ol class="breadcrumb">';  
     $breadcrumbs .= '<li><i class="fa fa-home"></i> <a href="'.route('web.index').'">首頁</a></li>';  

     // if not admin root  
     if(strpos($route, 'root') === false)
     {  
      if(Route::has($index)){
         $breadcrumbs .= strpos($route, 'index') !== false ? '<li class="active">' : '<li>';  
         $parent_text  = strpos($route, 'index') !== false ? trans($route) : trans($index);  
         $breadcrumbs .= strpos($route, 'index') !== false ? $parent_text : '<a href="'.route($index).'">'.$parent_text.'</a>';  
         $breadcrumbs .= '</li>';  
       }
       if(strpos($route, 'index') === false)  
       {  
         $breadcrumbs .= '<li class="active">'.trans($route).'</li>';  
       }  
     }  


     $breadcrumbs .= '</ol>';  
     return $breadcrumbs;  
   }  
 }  


if(! function_exists('getFourmList')){
  function getForumList(){
    if(Sentinel::check())
    {
      if($user = Sentinel::getUser())
      {
        $sidebar = '<ul class="nav side-menu">';
        //檢查權限
        if(Sentinel::inRole('SuperAdmin') || Sentinel::inRole('Admin')){
          $AuthList = \App\categories::whereNull('parent_categories')->get();
            
            foreach ($AuthList as $main) {
              $SubList = \App\categories::where('parent_categories',$main->id)->get();
                //主類別
                $sidebar .= '<li><a><i class="fa fa-bug"></i> '.$main->title.'</a>';
                $sidebar .= '</li>';
              
              foreach ($SubList as $data) {
                  //子類別
                $sidebar .= '<li><a>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-right"></i> '.$data->title.' <span class="fa fa-chevron-down"></span></a>';
                $sidebar .= '<ul class="nav child_menu" style="display: none">';
                $sidebar .= '<li><a href="'.route('record.index',$data->id).'">紀錄</a></li>';
                $sidebar .= '<li><a href="'.route('posts.index',$data->id).'">討論區</a></li>';
                $sidebar .= '</ul>';
                $sidebar .= '</li>';
              }
            }
            
        }
        else{
            $AuthList = \App\categories_auth::where('user_id',$user->id)->get();
            foreach ($AuthList as $main) {
              $Auth = json_decode($main->permissions);
              $SubList = \App\categories::where('parent_categories',$main->categories_id)->get();

                //主類別
                $sidebar .= '<li><a><i class="fa fa-bug"></i> '.$main->categories->title.'</a>';
                $sidebar .= '</li>';
                foreach ($SubList as $data) {
                
                  //子類別
                  $sidebar .= '<li><a>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-right"></i> '.$data->title.' <span class="fa fa-chevron-down"></span></a>';
                  $sidebar .= '<ul class="nav child_menu" style="display: none">';
                  if($Auth->record == true){
                    $sidebar .= '<li><a href="'.route('record.index',$data->id).'">紀錄</a></li>';
                  }

                  if($Auth->posts == true){
                    $sidebar .= '<li><a href="'.route('posts.index',$data->id).'">討論區</a></li>';
                  }   
                  $sidebar .= '</ul>';
                  $sidebar .= '</li>';
                
              }
            }
          }
          $sidebar .= '</ul>';
            return $sidebar;
      }
    }
  }
}

//  if ( ! function_exists('header_title'))  
//  {  
//    /**  
//     * Return the header title for each page  
//     *  
//     * @return string  
//     */  
//    function header_title()  
//    {  
//      $route = Route::currentRouteName();  
//      $title = '<h1 class="page-title">';  
//      $title .= trans(Route::getCurrentRoute()->getName());  
//      if( strpos($route, 'index') !== false )  
//      {  
//        $new = substr($route, 0, strrpos($route, '.') + 1) . 'create';  
//        if(Route::has($new))  
//        {  
//          $title .= '<small>';  
//          $title .= '<a href="'.route($new).'" title="'.trans($new).'">';  
//          $title .= '<i class="fa fa-plus"></i>';  
//          $title .= '</a>';  
//          $title .= '</small>';  
//        }  
//      }  
//      $title .= '</h1>';  
//      return $title;  
//    }  
//  }  
 ?>