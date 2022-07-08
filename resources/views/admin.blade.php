<html>
	<head>
		<script
	  	src="https://code.jquery.com/jquery-2.2.4.min.js"
		integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
		crossorigin="anonymous"></script>

		<link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
		<link href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" rel="stylesheet">
		<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
		<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
		<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
		<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	</head>
	<body>
		<div class="card">
			<div class="card-body" style="text-align: center; font-weight: 700;">
				HALAMAN ADMIN
			</div>
		  	<div class="card-body">
		  		<table>
		  			<tbody>
			  			<tr>
			  				<td style="width:200px;">Tanggal: </td>
			  				<td><input type="date" id="st" class="form-control"></td>
			  				<td>&nbsp; s/d &nbsp;</td>
			  				<td><input type="date" id="ed" class="form-control"></td>
			  				<td><button class="btn btn-primary" onclick="kendaraanLoad()">Cari</button></td>
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
				$("#data").dataTable( {
					order: [[2, 'desc']],
					dom: 'Bfrtip',
					buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
				});
			});

			function kendaraanLoad (){
				$("#tbodyData").html("");
		        $("#data").DataTable().destroy();
				$.ajax({
		            type: "POST",
		            url: "/api/kendaraan_data",
		            data: {st_date:$('#st').val(), ed_date:$('#ed').val()},
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

		            	$("#tbodyData").html(html);
		            	$("#data").dataTable( {
							order: [[2, 'desc']],
							dom: 'Bfrtip',
							buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
						});
		            }
		        });
			}
		</script>
	</body>
</html>