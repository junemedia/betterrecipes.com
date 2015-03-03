<?php

class Paginator{
	var $items_per_page;
	var $items_total;
	var $current_page;
	var $num_pages;
	var $mid_range;
	var $low;
	var $high;
	var $limit;
	var $return;
	var $default_ipp = 25;
	var $querystring;
	var $site_path;
	var $cpage;

	public function __construct($ipp = 25, $total, $page = 1)
	{
		$this->current_page = 1;
		$this->mid_range = 5;
		$this->items_per_page = $ipp;
		$this->items_total = $total;
		$this->cpage = $page;
	}

	function paginate()
	{
		if(!is_numeric($this->items_per_page) || $this->items_per_page <= 0) $this->items_per_page = $this->default_ipp;
		$this->num_pages = (ceil($this->items_total/$this->items_per_page));
		$this->current_page = $this->cpage; // must be numeric > 0
		if($this->current_page < 1 || !is_numeric($this->current_page)) $this->current_page = 1;
		if($this->current_page > $this->num_pages) $this->current_page = $this->num_pages;
		$prev_page = $this->current_page-1;
		$next_page = $this->current_page+1;

		if($this->num_pages > 1)
		{
			//$this->return = ($this->current_page != 1 && $this->items_total >= 10) ? "<a href=\"$this->site_path?page=$prev_page$this->querystring\">previous</a> ":" ";
			$this->return = ($this->current_page != 1 && $this->items_total >= 10) ? '<a href="'.$this->site_path.'?page='.$prev_page.$this->querystring.'">&laquo;</a> ':' ';

			$this->start_range = $this->current_page - floor($this->mid_range/2);
			$this->end_range = $this->current_page + floor($this->mid_range/2);

			if($this->start_range <= 0)
			{
				$this->end_range += abs($this->start_range)+1;
				$this->start_range = 1;
			}
			if($this->end_range > $this->num_pages)
			{
				$this->start_range -= $this->end_range-$this->num_pages;
				$this->end_range = $this->num_pages;
			}
			$this->range = range($this->start_range,$this->end_range);

			for($i=1;$i<=$this->num_pages;$i++)
			{
				if($this->range[0] > 2 && $i == $this->range[0]) $this->return .= '<span> . . . </span>';
				// loop through all pages. if first, last, or in range, display
				if($i==1 || $i==$this->num_pages ||in_array($i,$this->range))
				{
					//$this->return .= ($i == $this->current_page) ? " <span>".$i."</span> " :"<a href=\"$this->site_path?page=$i$this->querystring\">$i</a> ";
					$this->return .= ($i == $this->current_page) ? ' <span>'.$i.'</span> ' : '<a href="'.$this->site_path.'?page='.$i.$this->querystring.'">'.$i.'</a> ';
				}
				if($this->range[$this->mid_range-1] < $this->num_pages-1 && $i == $this->range[$this->mid_range-1]) $this->return .= " . . . ";
			}
			//$this->return .= (($this->current_page != $this->num_pages && $this->items_total >= 10)) ? "<a href=\"$this->site_path?page=$next_page$this->querystring\">next</a>":" ";
			$this->return .= (($this->current_page != $this->num_pages && $this->items_total >= 10)) ? '<a href="'.$this->site_path.'?page='.$next_page.$this->querystring.'">&raquo;</a>' : ' ';
		}
		/*elseif ($this->num_pages > 1 &&  $this->num_pages <= 5)
		{
			
			for($i=1;$i<=$this->num_pages;$i++)
			{
				//$this->return .= ($i == $this->current_page) ? " <span>".$i."</span> " :"<a href=\"$this->site_path?page=$i$this->querystring\">$i</a> ";
				$this->return .= ($i == $this->current_page) ? ' <span>'.$i.'</span> ' : '<a href="'.$this->site_path.'?page='.$i.$this->querystring.'">'.$i.'</a> ';
			}*/
		 else {
			$this->return = '';
		}
	}

	function display_items_per_page()
	{
		$items = '';
		$ipp_array = array(10,25,50,100,'All');
		foreach($ipp_array as $ipp_opt)	$items .= ($ipp_opt == $this->items_per_page) ? "<option selected value=\"$ipp_opt\">$ipp_opt</option>\n":"<option value=\"$ipp_opt\">$ipp_opt</option>\n";
		return "<span class=\"paginate\">Items per page:</span><select class=\"paginate\" onchange=\"window.location='$_SERVER[PHP_SELF]?page=1&ipp='+this[this.selectedIndex].value+'$this->querystring';return false\">$items</select>\n";
	}

	function display_jump_menu()
	{
		for($i=1;$i<=$this->num_pages;$i++)
		{
			$option .= ($i==$this->current_page) ? "<option value=\"$i\" selected>$i</option>\n":"<option value=\"$i\">$i</option>\n";
		}
		return "<span class=\"paginate\">Page:</span><select class=\"paginate\" onchange=\"window.location='$_SERVER[PHP_SELF]?page='+this[this.selectedIndex].value+'&ipp=$this->items_per_page$this->querystring';return false\">$option</select>\n";
	}

	function display_pages()
	{
		return $this->return;
	}
}