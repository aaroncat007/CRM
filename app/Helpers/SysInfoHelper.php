<?php

if ( ! function_exists('webInfo'))  
{  
   /**  
    * Return the System Info for each page  
    *  
    * @return string  
    */  
   function webInfo()  
   {  
   	$cacheName = 'webInfo';

   	//Cache::forget($cacheName);

   	if(Cache::has($cacheName))
   	{
   		return Cache::get($cacheName);
   	}
   	else
   	{
   		$infos = App\SysInfo::all();
   		$data = collect();

   		foreach ($infos as $info) {
   			$data->put($info->Name,$info->value);
   		}

   		Cache::forever($cacheName,$data);
   		return $data;  
   	}

   }  
}  


if( ! function_exists('getUserimg'))
{

    function getUserimg($uid) 
    { 

        $str = mb_substr(getUserName($uid), 0,1);

        $filePath = 'images/icon/'.$uid.'.png';

        $savePath = public_path($filePath);

        if(!File::exists($savePath)){
            
            $img = Image::canvas(125,125,'#D8DBE2');

            $img->text($str,60,60,function($font){
                $font->file(public_path().'/fonts/sp-setofont.ttf');
                $font->size(108);
                $font->color('#0000ff');
                $font->align('center');
                $font->valign('middle');
            });

           $img->save($savePath);

        }

        // output
        return $filePath;
    } 
}

?>