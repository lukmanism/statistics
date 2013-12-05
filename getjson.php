<?php
error_reporting(0);
header('Content-type: application/json');
// $conn = mysqli_connect("localhost","demo","demo.kbs","demo");
$conn = mysqli_connect("localhost","demokbs","demokbs","demokbs");

if (mysqli_connect_errno($conn)) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

@$d = ($_GET['d'])? cleanURI($_GET['d']) : '';
@$s = ($_GET['s'])? cleanURI($_GET['s']) : '';


$query = "WHERE ";
$query .= ($d)? " district IN('$d') ORDER BY FIND_IN_SET(district,'".$_GET['d']."');":  " state IN('$s') ORDER BY FIND_IN_SET(state,'".$_GET['s']."');";


$query 	= "SELECT * FROM belia ". $query;
$result = mysqli_query($conn, $query);
$json = '';

	if($s){ // state set
		while($rowState = mysqli_fetch_array($result)) {
			$set[$rowState['state']][] = array(
				$penduduk[] = explode(',',$rowState['penduduk']),
				$belia[] = explode(',',$rowState['belia'])
			);
		}
		foreach ($set as $state => $stateval) {
			foreach ($stateval as $key => $value) {
				$valpenduduk[] = $value[0];
				$valbelia[] = $value[1];
			}
			$penduduk = implode(array_sum_identical_keys($valpenduduk), ',');
			$belia = implode(array_sum_identical_keys($valbelia), ',');
			$json .= '{"id": "", "district": "", "state": "'.$state.'", "penduduk": ['.$penduduk.'], "belia": ['.$belia.']},';
		}

	} else { // district set
		while($row = mysqli_fetch_array($result)) {
			$json .= '{"id":'.$row['id'].', "district": "'.$row['district'].'", "state": "'.$row['state'].'", "penduduk": ['.$row['penduduk'].'], "belia": ['.$row['belia'].']},';
		}
	}
	echo "[".rtrim($json, ",")."]";


mysqli_close($conn);

function cleanURI($y){
	$y = explode(',', $y);
	return $y = implode($y, "','");	
}

function array_sum_identical_keys($penduduk) {
    $arrays = $penduduk;
    $keys = array_keys(array_reduce($arrays, function ($keys, $arr) { return $keys + $arr; }, array()));
    $sums = array();

    foreach ($keys as $key) {
        $sums[$key] = array_reduce($arrays, function ($sum, $arr) use ($key) { return $sum + @$arr[$key]; });
    }
    return $sums;
}
?> 