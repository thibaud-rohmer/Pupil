<?php

class Episode
{
	private $name;
	private $fullname;
	private $season;
	private $number;
	private $url;
	public $date;
	private $nicedate;
	private $attributes = array();
	
	public function __construct($name, $season, $number, $url, $date, $ext, $type, $fullname){
		if(!is_int($season) || !is_int($number)){
			return false;
		}
		$this->name = $name;
		$this->season = $season;
		$this->number = $number;
		$this->url = $url;
		$this->date = $date;
		setlocale(LC_TIME, "fr_FR");
		$this->nicedate = strftime('%a, %e/%m',$date);
		$this->fullname = $fullname;
		
		if($ext=="mp4" || $ext=="MP4"){
			$this->attributes[] = "mp4";
		}
			
		if($ext=="mkv" || $ext=="MKV"){
			$this->attributes[] = "mkv";
		}

		if($type != ""){
			$this->attributes[] = $type;
		}
	}
	
	public function get_info(){
		return array($this->name,$this->season,$this->number,$this->url);
	}
	
	public function get_name(){
		return $this->name;
	}
	
	public function get_smart_name(){
		return strtolower(str_replace(" ","",$this->name));
	}
	
	public function get_date(){
		return $this->date;
	}
	
	public function __toString(){
		$r="";

		$r .= " <tr>\n";
		
		$r .= "<td>";
		foreach	($this->attributes as $a){
			$r.="<div class='button type_$a'>$a</div>";
		}
		$r .= "</td>";
	
		$r .= "	<td>$this->nicedate</td>
			<td>$this->season</td>
			<td>$this->number</td>
			<td><a href=\"$this->url\">$this->fullname</a></td>
			";

		$r .= "</tr>";

		return $r;

		$r= "<div class='item pure-g'>
			<div class='pure-u-1-3'>";
			
		foreach	($this->attributes as $a){
			$r.="<div class='button type_$a'>$a</div>";
		}
		$r.= "</div>
			<div class='pure-u-2-3'>
			<a href=\"$this->url\">Season $this->season Episode $this->number</a>
			</div>
		</div>";
		return $r;
	}
	
}

?>
