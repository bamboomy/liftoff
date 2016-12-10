
<?

$sql = "SELECT reviewCandidate.id, appUrl, sentence, reviewCandidate.ownerName, maxDownloads, title, src, genre, user.tbrlp FROM reviewCandidate ";
$sql.= "LEFT JOIN user ON reviewCandidate.ownerId=user.id ";
$sql.= "where reviewCandidate.status='verified' or reviewCandidate.status='review_pending' order by reviewCandidate.timeStamp asc";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
	
	$counter = 0;
	
    while($row = $result->fetch_assoc()) {
		
		if(isset($launchId)){
			//exclude to be launched app
		}
		
		$appList[$counter++] = array(
			"id" => $row["id"],
			"appUrl" => $row["appUrl"],
			"sentence" => $row["sentence"],
			"ownerName" => $row["ownerName"],
			"maxDownloads" => $row["maxDownloads"],
			"title" => $row["title"],
			"src" => $row["src"],
			"genre" => $row["genre"],
			"tbrlp" => $row["tbrlp"],
		);
    }

	$sortArrayCounter = 0;
	
	foreach($appList as $app){

		$sortArray[$sortArrayCounter++] = intval($app["maxDownloads"]); //for multisort
	}

	array_multisort($sortArray, $appList);

	$sortArrayCounter = 0;
	
	foreach($appList as $app){

		$sortArray[$sortArrayCounter++] = intval($app["tbrlp"]); //for multisort
	}

	array_multisort($sortArray, SORT_DESC, $appList);

}

?>