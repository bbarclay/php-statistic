<?php
class spearman{
	function __construct(){
	
	}

	function rank($array){
		$temp=$array;
		rsort($temp);
		$rank=array();
		$frequency=array_count_values($temp);

		foreach($array as $v){
			$key=array_search($v, $temp);
			$key++;
			if($frequency[$v]>1){
				$rank[]=array_sum(range($key,$key+$frequency[$v]-1))/$frequency[$v];
			}
			else{
				$rank[]=$key;
			}
		}
		return $rank;
	}

	function calc($array1,$array2){
		$d_square=array_map(
			function ($x, $y) { return pow(($y-$x),2); },
			$this->rank($array1),
			$this->rank($array2)
		);

		$n=count($array1);
		$result=1-(6*(array_sum($d_square))/($n*(pow($n,2)-1)));

		return $result;
	}
	
	function Median($Array) {
		sort($Array);
	  return $this->Quartile_50($Array);
	}
	 
	function Quartile_25($Array) {
		sort($Array);
	  return $this->Quartile($Array, 0.25);
	}
	 
	function Quartile_50($Array) {
	  sort($Array);
	  return $this->Quartile($Array, 0.5);
	}
	 
	function Quartile_75($Array) {
	  sort($Array);
	  return $this->Quartile($Array, 0.75);
	}

	function IQR($Array) {
		sort($Array);
		$q1 = $this->Quartile($Array, 0.25);
		$q3 = $this->Quartile($Array, 0.75);
		$iqr = ($q3 - $q1) ;
	   return $iqr;
	}

	function LOB($Array) {
		sort($Array);
		$iqr = $this->IQR($Array);
		$q1 = $this->Quartile($Array, 0.25);
		$lob = $q1 - (1.5*$iqr);
		return $lob;
	}

	function UOB($Array) {
		sort($Array);
		$iqr = $this->IQR($Array);
		$q3 = $this->Quartile($Array, 0.75);
		$uob = $q3 + (1.5*$iqr);
		return $uob;
	}

	function Outlier($Array) {
		sort($Array);
		$lob = $this->LOB($Array);
		$uob = $this->UOB($Array);
		$outliers = [];
		foreach ($Array as $item) {
			if($item < $lob || $item > $uob){
				array_push($outliers, $item);
			}
		}
		return $outliers;
	}

	function Quartile($Array, $Quartile) {
	  $quantElement = count($Array);
	  $position = floor($quantElement * $Quartile);
	  
	  if(($quantElement%2)==0){
		if(isset($Array[$position+1]) and $position!=0) {
		return ($Array[$position-1] + $Array[$position])/2;
	  } else {
		return $Array[$position];
	  }
	  } else {
		return $Array[$position];
	  }
	}
	 
	function Average($Array) {
	  return array_sum($Array) / count($Array);
	}
	 
	function StdDev($Array) {
	  if( count($Array) < 2 ) {
		return;
	  }
	 
	  $avg = $this->Average($Array);
	 
	  $sum = 0;
	  foreach($Array as $value) {
		$sum += pow($value - $avg, 2);
	  }
	 
	  return sqrt((1 / (count($Array) - 1)) * $sum);
	}
}

$array1 =[56,75,45,71,61,64,58,80,76,61]; //input example
$array2 =[66,70,40,60,65,56,59,77,67,63]; //input example
$array3 =[20, 20, 21, 21, 21, 21, 22, 22, 22, 23, 24, 25, 26, 150, 200]; //input example

$spearmancalc = new spearman();

echo "Spearman: ";
echo $spearmancalc->calc($array1,$array2);
echo "<br/> Quartile 1: ";
echo $spearmancalc->Quartile_25($array3);
echo "<br/> Medium: ";
echo $spearmancalc->Median($array3);
echo "<br/> Quartile 3: ";
echo $spearmancalc->Quartile_75($array3);
echo "<br/> Interquartile range (IQR): ";
echo $spearmancalc->IQR($array3);
echo "<br/> Lower outlier bounds (LOB): ";
echo $spearmancalc->LOB($array3);
echo "<br/> Upper outlier bounds (UOB): ";
echo $spearmancalc->UOB($array3);
echo "<br/> Outliers: ";
print_r($spearmancalc->Outlier($array3));
echo "<br/> Average: ";
print_r($spearmancalc->Average($array3));
echo "<br/> Standard deviation: ";
print_r($spearmancalc->StdDev($array3));