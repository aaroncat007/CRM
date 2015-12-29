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


?>