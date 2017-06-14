<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use UNAHEmpleos\Http\Requests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Http\Controllers\Controller;
use App\Models\SeccionesMdl;
use App\Models\UsuariosMdl;
use App\Http\Controllers\MiagndCore;
use DB;

class SeccionesCtrl extends Controller
{

    public function getSecciones(){

        $secciones = DB::SELECT("SELECT s.seccionID
									   ,s.seccion
								       ,s.asignaturaID
								       ,s.horaInicio
								       ,s.horaFin
								       ,s.edificio
								       ,s.salonClase
									   ,u.nombres		as nombreCatedratico
								  FROM secciones s
								 INNER JOIN usuarios u
									on s.usuarioID = u.usuarioID
								 ORDER BY s.seccion");

        $catedraticos = DB::SELECT("SELECT usuarioID
												   ,nombres
											  FROM usuarios 
											 WHERE tipoUsuarioID = 3
											   AND tipoEstadoID = 1");     
        $asignaturas = DB::SELECT("SELECT asignaturaID
												  ,descripcion
											 FROM asignaturas
											WHERE tipoEstadoID = 1");
        
        $periodos = DB::SELECT("SELECT periodoAcademicoID
											,descripcion
									   FROM periodoAcademico
									  WHERE tipoEstadoID = 1");

        $data = array(
            "secciones" => $secciones,
            "catedraticos" => $catedraticos,
            "asignaturas" => $asignaturas,
            "periodos" => $periodos
        );

        return view('dataViews.seccionesVw')->with("data", $data);
    }

	public function registrar(Request $request){

		$seccion = $request->input("seccion");
		$asignatura = $request->input("asignatura");
		$horaI = $request->input("horaInicio");
		$horaF = $request->input("horaFin");
		$edificio = $request->input("edificio");
		$aula = $request->input("aula");
		$periodo = $request->input("periodo");
		$catedratico = $request->input("catedratico");

		$seccionExiste = SeccionesMdl::where("asignaturaID", $asignatura)
										->where('usuarioID', $catedratico)
										->where("tipoEstadoID", 1)
										->get();

		if ( MiagndCore::modelHasRows($seccionExiste) ){
			mysqli_close($conn);
			echo "<script>alert('La seccion seleccionada ya está asignada a este catedratico')</script>";
			echo "<script>window.history.back();</script>";
			return;
		}
		
		try{
			$newSeccion = new SeccionesMdl;

			$newSeccion->seccion = $seccion;
			$newSeccion->usuarioID = $catedratico;
			$newSeccion->asignaturaID = $asignatura;
			$newSeccion->periodoAcademicoID = $periodo;
			$newSeccion->horaInicio = $horaI;
			$newSeccion->horaFin = $horaF;
			$newSeccion->edificio = $edificio;
			$newSeccion->salonClase = $aula;

			$newSeccion->save();
			echo "<script>alert('Seccion añadida')</script>";
			echo "<script>window.history.back();</script>";
		}catch(Exception $exc){
			echo $exc->getMessage();
		}
	}

	public function getSeccionesCalificar($usuarioId){

		$usuario = usuariosMdl::find($usuarioId);

		$secciones = DB::SELECT("SELECT 
									sec.seccionID
									,sec.seccion
									,asig.descripcion as asignatura
									,sec.periodoAcademicoID
							   FROM secciones sec
									inner join asignaturas asig
											on asig.asignaturaID = sec.asignaturaID
										   and asig.tipoEstadoID = 1
							  WHERE sec.usuarioID = '$usuarioId'
								and sec.tipoEstadoID = 1 
								-- and  sec.periodoAcademicoID = 1
								");

        $data = array(
			"secciones" => $secciones,
			"dataUsuario" => $usuario
		);								
		return view('catedraticos.calificarSeccionesVw')->with('data', $data);
	}
}
