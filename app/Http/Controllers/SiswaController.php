<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Spatie\ArrayToXml\ArrayToXml;
use Symfony\Component\Yaml\Yaml;
use App\Models\Siswa;
use Log;

class SiswaController extends Controller
{
    public function jsonShow(Request $req){
        $siswa = Siswa::where('nim',$req->get('nim'))->first();
        
        if(!$siswa) {
            return response()->json([
                "status" => "failed", 
                "msg" => "siswa not found"
            ],404);
        };

        $matkul = json_decode($siswa->matkul);

        $responseData = array(
            "nama" => $siswa->nama,
            "nim" => $siswa->nim,
            "smt" => $siswa->smt,
            "matkul" => $matkul
        );
        
        return response()->json($responseData);
    }

    public function jsonCreate(Request $req){
        $this->validate($req,[
            "nim" => 'required|string',
            "nama" => 'required|string',
            "smt" => 'required|integer',
            "matkul" => 'string'
        ]);

        $siswa = new Siswa(array(
            "nim" => $req->get('nim'),
            "nama" => $req->get('nama'),
            "smt" => $req->get('smt'),
            "matkul" => $req->get('matkul')
        ));
        $siswa->save();

        return response()->json(array(
            "status" => "completed",
            "msg" => "siswa added"
        ));

    }

    public function jsonEdit(Request $req, $nim){
        $siswa = Siswa::where('nim',$nim)->first();
        
        
        if(!$siswa) {
            return response()->json(array(
                "status" => "failed", 
                "msg" => "siswa not found"
            ));
        };

        switch (true) {
            case $req->has('nama'):
                $siswa->nama = $req->get('nama');
                break;

            case $req->has('nim'):
                $siswa->nim = $req->get('nim');
                break;

            case $req->has('smt'):
                $siswa->smt = $req->get('smt');
                break;

            case $req->has('matkul'):
                $siswa->matkul = $req->get('matkul');
                break;

            default:
                return response()->json(["status" => "failed", "msg" => "parameter is missing"],400);
                break;
        }
        $siswa->save();

        return response()->json(array(
            "status" => "completed",
            "msg" => "siswa updated"
        ));
    }

    public function xmlInfo(Request $req){
        $siswa = Siswa::where('nim',$req->get('nim'))->first();
        
        if(!$siswa) {
            return response()->xml([
                "status" => "failed", 
                "msg" => "siswa not found"
            ],404);
        };

        $matkul = json_decode($siswa->matkul,true);

        $responseData = array(
            "nama" => $siswa->nama,
            "nim" => $siswa->nim,
            "smt" => $siswa->smt,
            "matkul" => $matkul
        );
        
        return response()->xml($responseData);
    }

    public function yamlInfo(Request $req){
        $siswa = Siswa::where('nim',$req->get('nim'))->first();
        
        if(!$siswa) {
            return Yaml::dump([
                "status" => "failed", 
                "msg" => "siswa not found"
            ],404);
        };

        $matkul = json_decode($siswa->matkul, true);

        $responseData = array(
            "nama" => $siswa->nama,
            "nim" => $siswa->nim,
            "smt" => $siswa->smt,
            "matkul" => $matkul
        );
        
        return Yaml::dump($responseData);
    }
}
