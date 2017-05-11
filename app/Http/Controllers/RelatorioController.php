<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Seracademico\Services\RelatorioService;

class RelatorioController extends Controller
{
    /**
     * @var array
     */
    private $loadFields = [
        'CGM'
    ];

    /**
     * @var
     */
    private $service;

    /**
     * @param RelatorioService $service
     */
    public function __construct(RelatorioService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        #Carregando os dados para o cadastro
        $loadFields = $this->service->load($this->loadFields);
        $especialistas = $this->getEspecialistas();

        #Retorno para view
        return view('reports.viewReportByAgenda', compact('loadFields', 'especialistas'));
    }

    /**
     * @param $idEspecialista
     * @return mixed
     */
    public function gridReportByAgenda($idEspecialista)
    {
        try {
            #Criando a consulta
            $rows = \DB::table('agendamento')
                ->join('fila', 'fila.id', '=', 'agendamento.fila_id')
                ->join('cgm', 'cgm.id', '=', 'fila.cgm_id')
                ->select([
                    'agendamento.id',
                    'cgm.nome'
                ])
                ->where('agendamento.id', '=', $idEspecialista);

            #Editando a grid
            return Datatables::of($rows)->addColumn('action', function ($row) {
                //return '<a href="edit/'.$row->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Editar</a>';
            })->make(true);

        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

    /**
     * @return array|string
     */
    public function getEspecialistas()
    {
        //Variavel global p/ uso
        $arrayEspecialistas = [];

        try {
            $especialistas = \DB::table('especialista')
                ->join('cgm', 'cgm.id', '=', 'especialista.cgm')
                ->select([
                    'especialista.id',
                    'cgm.nome'
                ])
                ->get();

            //Montando array com resultado da pesquisa
            foreach ($especialistas as $especialista) {
                $arrayEspecialistas[$especialista->id] = $especialista->nome;
            }

            //Retorno
            return $arrayEspecialistas;

        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
}
