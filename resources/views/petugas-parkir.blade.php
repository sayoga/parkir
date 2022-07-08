<html>
	<head>
		<script
	  	src="https://code.jquery.com/jquery-2.2.4.min.js"
		integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
		crossorigin="anonymous"></script>

		<link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
		<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	</head>
	<body>
		<div class="card">
			<div class="card-body" style="text-align: center; font-weight: 700;">
				HALAMAN PETUGAS PARKIR
			</div>
		  	<div class="card-body">
		  		<table>
		  			<tbody>
			  			<tr>
			  				<td style="width:200px;">Nomor Kendaraan: </td>
			  				<td><input type="text" id="nopol" class="form-control" onkeydown="kendaraanMasuk(this)"></td>
			  				<td><label id="kodeshow"></label></td>
			  			</tr>
			  		</tbody>
		  		</table>
		  	</div>

		  	<div class="card-body">
		  		<table>
		  			<tbody>
			  			<tr>
			  				<td style="width:200px;">Kode Parkir Kendaraan: </td>
			  				<td><input type="text" id="kode" class="form-control" onkeydown="kendaraanKeluar(this)"></td>
			  				<td><label id="alert"></label></td>
			  			</tr>
			  		</tbody>
		  		</table>
		  	</div>

		  	<div class="card-body">
		  		<table id="data" class="table">
		  			<thead>
		  				<tr>
		  					<th>Kode</th>
		  					<th>Nomor Polisi</th>
		  					<th>Masuk</th>
		  					<th>Keluar</th>
		  					<th>Ongkos</th>
		  				</tr>
		  			</thead>
		  			<tbody id="tbodyData">			  			
			  		</tbody>
		  		</table>
		  	</div>
		</div>

		<script>
			$( document ).ready(function() {
				$("#data").dataTable( {order: [[2, 'desc']]});
				kendaraanLoad();
			});
			
			function kendaraanMasuk (){
				if(event.key === 'Enter') {
					$.ajax({
			            type: "POST",
			            url: "/api/kendaraan_masuk",
			            data: {nopol:$('#nopol').val()},
			            dataType: "json",
			            success: function (response) {
			            	alert(response.message);
			            	kendaraanLoad ();
			            }
			        });
				}
			}

			function kendaraanKeluar (e){
				if(event.key === 'Enter') {
					$.ajax({
			            type: "POST",
			            url: "/api/kendaraan_keluar",
			            data: {id:$('#kode').val()},
			            dataType: "json",
			            success: function (response) {
			            	alert(response.message);
			            	kendaraanLoad ();
			            }
			        });
				}
			}

			function kendaraanLoad (){
				$("#tbodyData").html("");
		        $("#data").DataTable().destroy();
				$.ajax({
		            type: "POST",
		            url: "/api/kendaraan_data",
		            // data: {id:$('#kode').val()},
		            dataType: "json",
		            success: function (response) {
		            	var html = '';
		            	for(var i=0; i<response.data.length; i++){
		            		waktu_keluar = ''; ongkos = '';
		            		if (response.data[i]['keluar'] != null){
		            			waktu_keluar = response.data[i]['keluar'];
		            		}
		            		if (response.data[i]['ongkos'] != null){
		            			ongkos = response.data[i]['ongkos'];
		            		}
		            		html += `
		            			<tr>
		            				<td>${response.data[i]['id']}</td>
		            				<td>${response.data[i]['nopol']}</td>
		            				<td>${response.data[i]['masuk']}</td>
		            				<td>${waktu_keluar}</td>
		            				<td>${ongkos}</td>
		            			</tr>
		            		`;
		            	}
		            	console.log(html);
		            	$("#tbodyData").html(html);
		            	$("#data").dataTable( {order: [[2, 'desc']]});
		            }
		        });
			}
		</script>
	</body>
</html>