<?php
	$asal = $_POST['asal'];
	$id_kabupaten = $_POST['kab_id'];
	$kurir = $_POST['kurir'];
	$berat = $_POST['berat'];

	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => "http://api.rajaongkir.com/starter/cost",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => "origin=".$asal."&destination=".$id_kabupaten."&weight=".$berat."&courier=".$kurir."",
	  CURLOPT_HTTPHEADER => array(
	    "content-type: application/x-www-form-urlencoded",
	    "key: Your API Key"
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
	  var_dump($response);
	}

	//Get Data Ongkir
	$data = json_decode($response, true);
	echo "<tr style='font-variant-caps: all-small-caps;text-align: center;'>";
		for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {
			echo "<td>".$data['rajaongkir']['results'][$i]['code']."</td>";
			echo "<td>".$data['rajaongkir']['results'][$i]['name']."</td>";
			echo "<td>".$data['rajaongkir']['results'][$i]['costs'][$i]['description']."</td>";
			echo "<td>".$data['rajaongkir']['results'][$i]['costs'][$i]['cost'][$i]['etd']."</td>";
			echo "<td>".$data['rajaongkir']['results'][$i]['costs'][$i]['cost'][$i]['value']."</td>";
		}
	echo "</tr>";

?>