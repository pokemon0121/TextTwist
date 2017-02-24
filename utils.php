<?php
    function generate_rack($n){
        $tileBag = "AAAAAAAAABBCCDDDDEEEEEEEEEEEEFFGGGHHIIIIIIIIIJKLLLLMMNNNNNNOOOOOOOOPPQRRRRRRSSSSTTTTTTUUUUVVWWXYYZ";
        $rack_letters = substr(str_shuffle($tileBag), 0, $n);
        $temp = str_split($rack_letters);
        sort($temp);
        return implode($temp);
    };
    
    function generate_subracks($root_rack) {
        $racks = [];
        for($i = 0; $i < pow(2, strlen($root_rack)); $i++){
	        $ans = "";
	        for($j = 0; $j < strlen($root_rack); $j++){
		        //if the jth digit of i is 1 then include letter
		        if (($i >> $j) % 2) {
		            $ans .= $root_rack[$j];
		        }
	        }
	        if (strlen($ans) > 1){
  	            $racks[] = $ans;	
	        }
        }
        $racks = array_unique($racks);
        sort($racks);
        return $racks;
    }
    
    function finished($array) {
        foreach ($_SESSION['record'] as $r) {
            if ($r == 0) {
                return false;
            }
        }
        return true;
    }
    
    function remained($record) {
        $i = 0;
        foreach ($record as $r) {
            if ($r == 0) {
                $i++;
            }
        }
        return $i;
    }
?>