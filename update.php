<?php
	require_once __DIR__ ."/config.php";
	require_once __DIR__ ."/Model/Crypto.php";

	$db = new mysqli($DBConfig["host"],$DBConfig["user"],$DBConfig["pass"],$DBConfig["database"]);
	if($db->connect_error) {
		echo $db->connect_error;
		exit();
	}else {
		$db->set_charset("utf8");
	}

	$out = [];
	$out["message"] = "success";
	$out["data"] = "";
//Seed
	$query = <<<EOF
SELECT
`cryptos`.`crypto_name` AS "name",
`cryptos`.`filename` AS "filename",
`seeds`.`seed_address` AS "Seed"
FROM `cryptos` ,`dirs`, `seeds`
WHERE `cryptos`.`crypto_name` = "$CryptoName"
EOF;

	$data = [];
	if($rs = $db->query($query)) {
		while($row = $rs->fetch_assoc()) {
			array_push($data, $row);
		}
	}else {
		$out["message"] = "db query error.";
	}
//OS
	$query = <<<EOF
SELECT `dirs`.`os_name` AS "OS",
`dirs`.`dir` AS "Dir"
FROM `dirs`,`cryptos`
WHERE `cryptos`.`crypto_name` = "$CryptoName"
EOF;

	$os = [];
	if($rs = $db->query($query)) {
		while($row = $rs->fetch_assoc()) {
			array_push($os, $row);
		}
	}

	$seed = [];
	foreach ($data as $c) {
		array_push($seed, $c['Seed']);
	}

	$c = new Crypto(
		$data[0]["name"],
		$data[0]["filename"],
		$os,
		$seed
	);
	$out["data"] = $c;
	//var_dump($c);
	$json = json_encode($out["data"]);
	file_put_contents($filePutDir .$CryptoName .".json", $json);
	echo $json;
	//var_dump($out,json_encode($out["data"]));
	$db->close();
?>
