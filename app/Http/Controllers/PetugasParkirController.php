<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use \stdClass;

class PetugasParkirController extends Controller
{

    public function kendaraan_masuk(Request $request) {
    	
    	$nopol = str_replace(' ', '', strtoupper($request->nopol));
    	$id = $nopol.str_replace(' ', '', str_replace(':', '', date("Y:m:d H:i:s")));
    	$res = new stdClass();

    	$chk_nopol = DB::select("SELECT keluar, (TIMESTAMPDIFF(hour, masuk, now())) as jam FROM parkirdb.kendaraan WHERE nopol = ? ORDER BY masuk DESC;",
            		[$nopol]
        		);

    	if (empty($chk_nopol)){
    		DB::table("parkirdb.kendaraan")
            ->insert([
                'id' =>  $id,
                'nopol' =>  $nopol,
                'masuk' => date("Y-m-d H:i:s", strtotime('+7 hours'))
            ]);

            $res->message =  "Kendaraan masuk dengan nomor kode ".$id;
            return json_encode($res);
    	}
    	else{
    		if ($chk_nopol[0]->keluar == null){
    			$res->message = "Kendaraan dengan nomor polisi ".strtoupper($request->nopol)." belum keluar";
            	return $res;
    		}
    	}
    	
	}

	public function kendaraan_keluar(Request $request) {    	
		$res = new stdClass();

    	$chk_kode = DB::select("SELECT id, keluar, (TIMESTAMPDIFF(hour, masuk, now())) as jam FROM parkirdb.kendaraan WHERE id = ? ORDER BY masuk DESC;",
            		[$request->id]
        		);

    	if (empty($chk_kode)){
    		$res->message = "Data tidak ditemukan";
            return $res;
    	}
    	else{
    		if ($chk_kode[0]->keluar == null){
    			$jam = $chk_kode[0]->jam;
    			if ($jam == 0){$jam = 1;}
    			DB::table("parkirdb.kendaraan")
    			->where('id', $request->id)
	            ->update([
	                'keluar' => date("Y-m-d H:i:s", strtotime('+7 hours')),
	                'ongkos' => $jam*3000
	            ]);

	            $res->message = "Kendaraan keluar dengan ongkos IDR ".$jam*3000;
            	return $res;
    		}
    	}
    	
	}

	public function kendaraan_data(Request $request) {
    	
    	$st_date = $request->st_date;
    	$ed_date = $request->ed_date;

    	$res = new stdClass();
    	$data = [];
    	if ($st_date == null || $ed_date == null){
    		$data = DB::select("SELECT * FROM parkirdb.kendaraan ORDER BY masuk DESC;",
            		[]
        		);
    	}
    	else{
    		$data = DB::select("SELECT * FROM parkirdb.kendaraan WHERE masuk BETWEEN ? AND ? ORDER BY masuk DESC;",
            		[$st_date." 00:00:00", $ed_date." 23:59:59"]
        		);
    	}

    	$res->data = $data;
        return $res;
    	
	}
}
