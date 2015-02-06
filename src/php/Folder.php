<?php

class Folder
{
	private $path;
	private $name;
	private $contents = array();
	
	public function __construct($dir){
		$ignored=array(".","..");
		
		foreach (scandir($dir) as $file) {
			if (in_array($file, $ignored)) continue;
			$files[$file] = filemtime($dir . '/' . $file);
		}
		arsort($files);
		$files = array_keys($files);

		foreach($files as $file){
			$truc = $dir.'/'.$file;
			if(is_file($truc)){
				$this->contents[] = $truc;
			}else{
				$this->contents[] = new Folder($dir.'/'.$file);
			}
		}
		
		$this->name = basename($dir);
		$this->path = $dir;
	}
	
	public function __toString(){
		
		$r= "<div class='folder'>
			<div class='folder_name'>
			$this->name
			</div>
			<div class='folder_files'>";
		
		foreach($this->contents as $e){
			if(is_string($e)){
				$r .= "<div class='pure-g item'>";
				$r .= "<div class='pure-u-1-3'></div><div class='pure-u-2-3'><a href=\"$e\">".htmlentities(basename($e))."</a></div>";
				$r .= "</div>";
			}else{
				$r .= (string)$e;
			}
		}
		
		$r.="</div>
			</div>
		";
		
		return $r;
	}
}
?>