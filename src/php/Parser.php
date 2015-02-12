<?php

class Parser
{
	public static $vid_ext = array("mkv","MKV","mp4","MP4","avi","AVI");
	public static $shows = array();
	
	
	public static function analyze(SplFileInfo $file){
		
		$extension = $file->getExtension();
		if(!in_array($extension,Parser::$vid_ext))
		{
			return false;
		}
				
		if (preg_match("'^(.+)\.[sS]([0-9]+)[eE]([0-9]+).*$'i",$basename=$file->getBasename(),$n))
		{
			$name = preg_replace("'\.'"," ",$n[1]);
			$season = intval($n[2],10);
			$episode = intval($n[3],10);
			$type="";
			if(strpos($basename,"720")){
				$type="720p";
			}else if(strpos($basename,"1080")){
				$type="1080p";
			}
			return new Episode($name,$season,$episode,$file->getPathname(),$file->getMTime(), $extension, $type, $file->getFileName());
		}
		if (preg_match("'^(.+)\.([0-9][0-9][0-9])\..*$'i",$basename=$file->getBasename(),$n)){
			$name = preg_replace("'\.'"," ",$n[1]);
			$season = intval($n[2][0],10);
			$episode = intval($n[2][1].$n[2][2],10);
			$type="";
			if(strpos($basename,"720")){
				$type="720p";
			}else if(strpos($basename,"1080")){
				$type="1080p";
			}
			return new Episode($name,$season,$episode,$file->getPathname(),$file->getMTime(), $extension, $type, $file->getFileName());


		}
		
		return false;
		
	}
	
	public static function getShows($dir,$rec = false){
		$ignored=array(".","..");
		$files_array=scandir($dir);

		$files = array();
		foreach (scandir($dir) as $file) {
			if (in_array($file,$ignored)) continue;
			if(!is_file($dir.'/'.$file)){
				if($rec){
					Parser::getShows($dir.'/'.$file,true);
				}else{
					continue;
				}
			}
			$files[$file] = filemtime($dir . '/' . $file);
		}
		arsort($files);
		$files = array_keys($files);

		foreach($files as $file){

			$f = new SplFileInfo($dir."/".$file);
			if(! $ep = Parser::analyze($f) ){
				continue;
			}
			if(Parser::$shows[$ep->get_smart_name()] == ""){
				Parser::$shows[$ep->get_smart_name()] = new Show($ep);
			}else{
				Parser::$shows[$ep->get_smart_name()]->add_ep($ep);
			}
			
		}		
	}
	
	public static function getShow($key){
		return Parser::$shows[$key];
	}
}

?>
