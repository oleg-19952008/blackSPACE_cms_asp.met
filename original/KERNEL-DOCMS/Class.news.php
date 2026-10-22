<?php
class news
{
	/**
	  * /do_img/global/events/
	  * /do_img/global/events/icons/
	  */
	private $con;
	private $data;
	private $cnt;

    public function __construct() {
		$this->con = $GLOBALS['DB'];
    }

	public function init(){
		$qry = $this->con->prepare("SELECT * FROM news ORDER BY nID DESC LIMIT 7");
		if ($qry->execute()){
			if ($qry->rowCount() != 0){
				$this->cnt = $qry->rowCount();
				$arr = $qry->fetchAll(PDO::FETCH_ASSOC);
				$this->data = array_combine(range(1, count($arr)), array_values($arr));
				return TRUE;
			}else
				return FALSE;
		}else
			return FALSE;
	}
	
	public function get($type){
		$ret = "";
		for($i=1;$i<=$this->cnt;$i++){
			if($type == "icons"){
				$spc = ($i != 1) ? "style=\"margin-left: 6px;\"" : "";
				$ret .= "<img id=\"newsIcon_" . $this->data[$i]['newsID'] . "\" class=\"breakingNewsIcon\" src=\"./do_img/global/events/icons/" . $this->data[$i]['icon'] . "\" width=\"21\" height=\"21\" " . $spc . ">";
			}elseif($type == "news"){
				$spc = ($i != 1) ? "style=\"display: none;\"" : "";
				$ret .= "<div id=\"newsText_" . $this->data[$i]['newsID'] . "\" class=\"newsTextContainer\" " . $spc . "><h3>" . $this->data[$i]['headline'] . "</h3>" . $this->data[$i]['text'] . "</div>";
			}elseif($type == "images"){
				$spc = ($i != 1) ? "style=\"display: none;\"" : "style=\"display: block;\"";
				$ret .= "<img id=\"newsImage_" . $this->data[$i]['newsID'] . "\" src=\"./do_img/global/events/" . $this->data[$i]['image'] . "\" class=\"newsImage oldNews\" " . $spc . ">";
			}elseif($type == "jsarray"){
				$ret .= "newsItemIds.push('" . $this->data[$i]['newsID'] . "');";
			}elseif($type == "jsarray2"){
				$ret .= "uploadedNewsIds.push('" . $this->data[1]['newsID'] . "');";
				break;
			}
		}
		return $ret;
	}
}
?>