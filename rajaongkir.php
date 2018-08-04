<!DOCTYPE html>
<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css">
	</head>
	<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<hr>
				<div class="text-center">
					<h4>APLIKASI HITUNG ONGKOS KIRIM - RAJA ONGKIR </h4>
					<a href="https://rajaongkir.com" target="_blank">Rajanya ongkos kirim terpadu</a>
				</div>
				<hr>
			</div>
			<div class="col-md-3">
				<?php
					//Get Data Kabupaten
					$curl = curl_init();	
					curl_setopt_array($curl, array(
					  CURLOPT_URL => "https://api.rajaongkir.com/starter/city", 
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_ENCODING => "",
					  CURLOPT_MAXREDIRS => 10,
					  CURLOPT_TIMEOUT => 30,
					  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					  CURLOPT_CUSTOMREQUEST => "GET",
					  CURLOPT_HTTPHEADER => array(
					    "key: Your API Key"
					  ),
					));

					$response = curl_exec($curl);
					$err = curl_error($curl);

					curl_close($curl);

					echo "<div class='form-group'>";
					echo "<label>Kota Asal</label><br>";
					echo "<select name='asal' id='asal' class='custom-select' required>";
					echo "<option>Pilih Kota Asal</option>";
						$data = json_decode($response, true);
						for ($i=0; $i < count($data['rajaongkir']['results']); $i++) { 
						    echo "<option value='".$data['rajaongkir']['results'][$i]['city_id']."'>".$data['rajaongkir']['results'][$i]['city_name']."</option>";
						}
					echo "</select>";
					echo "</div>";
					//Get Data Kabupaten


					//-----------------------------------------------------------------------------

					//Get Data Provinsi
					$curl = curl_init();

					curl_setopt_array($curl, array(
					  CURLOPT_URL => "https://api.rajaongkir.com/starter/province", 
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_ENCODING => "",
					  CURLOPT_MAXREDIRS => 10,
					  CURLOPT_TIMEOUT => 30,
					  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					  CURLOPT_CUSTOMREQUEST => "GET",
					  CURLOPT_HTTPHEADER => array(
					    "key: Your API Key"
					  ),
					));

					$response = curl_exec($curl);
					$err = curl_error($curl);

					echo "<div class='form-group'>";
					echo "Provinsi Tujuan<br>";
					echo "<select name='provinsi' id='provinsi' class='custom-select' required>";
					echo "<option>Pilih Provinsi Tujuan</option>";
					$data = json_decode($response, true);
					for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {
						echo "<option value='".$data['rajaongkir']['results'][$i]['province_id']."'>".$data['rajaongkir']['results'][$i]['province']."</option>";
					}
					echo "</select>";
					echo "</div>";
					//Get Data Provinsi
				?>

				<label>Kabupaten Tujuan</label><br>
				<div class="form-group">
					<select id="kabupaten" name="kabupaten" class="custom-select" required></select>
				</div>
				<div class="form-group">
					<label>Kurir</label><br>
					<select id="kurir" name="kurir" class="custom-select" required>
						<option value="jne">JNE</option>
						<option value="tiki">TIKI</option>
						<option value="pos">POS INDONESIA</option>
					</select>
				</div>
				<div class="form-group">
					<label>Berat (gram)</label><br>
					<input id="berat" type="text" name="berat" value="500"  class="form-control" />
				</div>

				<div class="form-group">
					<input id="cek" type="submit" value="Hitung Ongkir"/ class="btn btn-success form-control">
				</div>
			</div>
			<div class="col-md-9">
				<hr>
				<table class="table table-bordered">
					<thead>
						<tr class="text-center">
							<th>Kurir</th>
							<th>Service</th>
							<th>Deskripsi Service</th>
							<th>Lama Kirim (hari)</th>
							<th>Total Biaya (Rp)</th>
						</tr>
					</thead>
					<tbody id="ongkir">
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
	</body>
</html>


<script type="text/javascript">

	$(document).ready(function(){
		$('#provinsi').change(function(){

			//Mengambil value dari option select provinsi kemudian parameternya dikirim menggunakan ajax 
			var prov = $('#provinsi').val();

      		$.ajax({
            	type : 'GET',
           		url : 'http://localhost/rajaongkir/cek_kabupaten.php',
            	data :  'prov_id=' + prov,
					success: function (data) {

					//jika data berhasil didapatkan, tampilkan ke dalam option select kabupaten
					$("#kabupaten").html(data);
				}
          	});
		});

		$("#cek").click(function(){
			//Mengambil value dari option select provinsi asal, kabupaten, kurir, berat kemudian parameternya dikirim menggunakan ajax 
			var asal = $('#asal').val();
			var kab = $('#kabupaten').val();
			var kurir = $('#kurir').val();
			var berat = $('#berat').val();

      		$.ajax({
            	type : 'POST',
           		url : 'http://localhost/rajaongkir/cek_ongkir.php',
            	data :  {'kab_id' : kab, 'kurir' : kurir, 'asal' : asal, 'berat' : berat},
					success: function (data) {

					//jika data berhasil didapatkan, tampilkan ke dalam element div ongkir
					$("#ongkir").html(data);
				}
          	});
		});
	});
</script>