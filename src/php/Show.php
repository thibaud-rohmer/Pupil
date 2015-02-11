<?php

class Show
{
	private $name;
	private $episodes;
	public $date;
	
	public function __construct($episode)
	{
		$this->name = $episode->get_name();
		$this->date = $episode->get_date();
		$this->episodes = array($episode);
	}
	
	public function get_key(){
		return strtolower(str_replace(" ","",$this->name));	
	}

	public function get_name()
	{
		return $this->name;
	}
	
	public function get_episodes()
	{
		return $this->episodes;
	}
	
	public function small_print(){
		
		if(isset($_GET['s']) && $_GET['s'] == $this->get_key()){
			$selected='listing-item-selected';
		}else{
			$selected='';
		}
		$url=urlencode($this->get_key());
		$numeps = sizeof($this->episodes);
		$date = strftime('%a, %e/%m',$this->date);

		echo "<div class='listing-item $selected pure-g'>\n";
		echo "<div class='pure-u'>\n";
		echo "</div>\n";
		echo "<div class='pure-u-1-1'>\n";
		echo "<h5 class='listing-name'>\n";
		echo "<a href=\"?s=$url\">$this->name</a>\n";
		echo "</h5>\n";
		echo "<h4 class='listing-subject'>\n";
		echo "$numeps episodes\n";
		echo "</h4>";
		echo "<p class='listing-desc'>\n";
		echo "Last episode: $date\n";
		echo "</p>\n";
		echo "</div>\n";
		echo "</div>\n";	
	}

	public function add_ep(Episode $ep)
	{
		$this->episodes[] = $ep;
		if($ep->get_date() > $this->date){
			$this->date = $ep->get_date();
		}
	}
	
	public function cmp($a, $b){
		return $a->date > $b->date;
	}
	
	public function __toString()
	{
		$eps = sizeof($this->episodes);

		usort($this->episodes, function($a, $b){
			return $a->date < $b->date;
		});


		
		$r= "<div class='listing-content-header'>
			<div class='pure-u-1-2'>
			<h1 class='listing-content-title'>$this->name</h1>
			<p class='listing-content-subtitle'>$eps Episodes, update: 12 Janvier 2015</p>
			</div>
			</div>";

		$r.= "<div class='listing-content-body'>";
	
		$r .= "<table class='pure-table pure-table-striped' style='width:100%'>
			<thead>
				<tr>
					<th>Type</th>
					<th>Date</th>
					<th>Season</th>
					<th>Episode</th>
					<th>Full Name</th>
				</tr>
			</thead>
			";
		foreach($this->episodes as $e){
			$r .= (string)$e;
		}
		
		$r.="</div>
		
		</div>";
		
		return $r;
	}

}

?>
