<?php
error_reporting(0);
header('Content-type: application/json');
// $conn = mysqli_connect("localhost","demo","demo.kbs","demo");
$conn = mysqli_connect("localhost","demokbs","demokbs","demokbs");

if (mysqli_connect_errno($conn)) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

@$d = ($_GET['d'])? strtolower(cleanURI($_GET['d'])) : '';
@$s = ($_GET['s'])? strtolower(cleanURI($_GET['s'])) : '';
@$Dt = ($_GET['Dt'])? strtolower(cleanURI($_GET['Dt'])) : '';


$getlatlng = "SELECT lat, lng FROM belia WHERE ";
$getlatlng .= ($d)? " district IN('$d') ":  " state IN('$s') AND district = ''";
$getlatlng .= "LIMIT 1;";

$qresult = mysqli_query($conn, $getlatlng);
$getlatlng = mysqli_fetch_array($qresult);

$qrange = "SELECT district, state, ACOS( SIN( RADIANS( lat ) ) * SIN( RADIANS(".$getlatlng['lat'].") ) + COS( RADIANS( lat ) ) * COS( RADIANS(".$getlatlng['lat'].") ) * COS( RADIANS( lng ) - RADIANS(".$getlatlng['lng'].") ) ) *6380 AS distance
	FROM belia
	WHERE ACOS( SIN( RADIANS( lat ) ) * SIN( RADIANS(".$getlatlng['lat'].") ) + COS( RADIANS( lat ) ) * COS( RADIANS(".$getlatlng['lat'].") ) * COS( RADIANS( lng ) - RADIANS(".$getlatlng['lng'].") ) ) *6380 < 1000 ";
$qrange .= ($d)? ' AND district != "" ': ' AND district = "" ';
$qrange .= "ORDER BY distance LIMIT 0, 3;";

// echo $qrange;

$qrresult = mysqli_query($conn, $qrange);

	while($qrange = mysqli_fetch_array($qrresult)) {
		$getloc[] = ($d)? strtolower($qrange[0]): strtolower($qrange[1]);
	}

	if(($s) && !in_array($s, $getloc)){
		array_unshift($getloc, $s);
		array_pop($getloc);
	} 

	$getloc1 = implode("','", $getloc);
	$getloc2 = implode(",", $getloc);

$query = "SELECT * FROM belia a ";
$query .= " WHERE ";
$query .= ($d)? " a.district IN('".$getloc1."') ":  " a.state IN('".$getloc1."') ";
// $query .= ($Dt)? " AND b.data_cat IN('$Dt') ":  "";
$query .= ($d)? " ORDER BY FIND_IN_SET(a.district,'".$getloc2."') ": " ORDER BY FIND_IN_SET(a.state,'".$getloc2."') ";

$query .= ";";

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
			$json .= '{"id":'.$row['id'].', "district": "'.$row['district'].'", "state": "'.$row['state'].'", "penduduk": ['.$row['penduduk'].'], "belia": ['.$row['belia'].']';

			$json .= ($row['data'])?', "datas": {"name": "'.strtolower($row['name']).'", "data": ['.$row['data'].']}': '';
			$json .= '},';
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