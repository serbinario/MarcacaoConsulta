<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use DB;

class UtilController extends Controller
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function search(Request $request)
    {
        try {
            #recuperando os dados da requisição
            $table = $request->get('table');
            $filed = $request->get('field_search');
            $value = $request->get('value_search');

            #Validando os parametros
            if($table == null || $filed == null || $value == null) {
                throw new \Exception('Parametros inválidos');
            }

            #executando a consulta e retornando os dados
            return DB::table($table)->select('id', 'nome')->orderBy('nome', 'asc')->where($filed, $value)->get();
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function searchOperacoes(Request $request)
    {
        try {
            #recuperando os dados da requisição
            $table = $request->get('table');
            $filed = $request->get('field_search');
            $value = $request->get('value_search');
            $tipo  = $request->get('tipo_search');

            #Validando os parametros
            if($table == null || $filed == null || $value == null) {
                throw new \Exception('Parametros inválidos');
            }

            #executando a consulta e retornando os dados
            $grupos =  DB::table($table)
                ->join('tipo_operacoes', 'tipo_operacoes.id', '=', $table.'.tipo_operacao_id')
                ->select([
                    $table.'.nome',
                    $table.'.id'
            ])->orderBy($table.'.nome', 'asc')->where($filed, $value)->get();

            if($tipo == '1') {

                foreach ($grupos as $grupo) {
                    $gruposArray[] = [
                        'text' => $grupo->nome,
                        'children' => DB::table('operacoes')
                            ->join('grupo_operacoes', 'grupo_operacoes.id', '=', 'operacoes.grupo_operaco_id')
                            ->select([
                                'operacoes.nome as text',
                                'operacoes.id'
                            ])->orderBy('operacoes.nome', 'asc')->where('grupo_operacoes.id', $grupo->id)->get()
                    ];
                }

            } else {
                foreach ($grupos as $grupo) {
                    $gruposArray[] = [
                        'text' => $grupo->nome,
                        'children' => DB::table('especialidade')
                            ->join('operacoes', 'operacoes.id', '=', 'especialidade.operacao_id')
                            ->join('grupo_operacoes', 'grupo_operacoes.id', '=', 'operacoes.grupo_operaco_id')
                            ->select([
                                'operacoes.nome as text',
                                'especialidade.id'
                            ])->orderBy('operacoes.nome', 'asc')->where('grupo_operacoes.id', $grupo->id)->get()
                    ];
                }
            }

            return $gruposArray;
           // dd($gruposArray);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function queryByselect2(Request $request)
    {
        try {
            #variável de retorno
            $result = array();

            #recuperando os dados da requisição
            $searchValue = $request->get('search');
            $tableName   = $request->get('tableName');
            $fieldName   = $request->get('fieldName');
            $pageValue   = $request->get('page');
            $fieldWhere  = $request->get('fieldWhere');
            $valueWhere  = $request->get('valueWhere');
            $joinTable   = $request->get('joinTable');
            $joinName    = $request->get('joinName');

//            #Validando os parametros
//            if($searchValue == null || $tableName == null || $fieldName == null || $pageValue == null) {
//                throw new \Exception('Parametros inválidos');
//            }

            #preparando a consulta
            $qb = DB::table($tableName);
            if($joinTable && $joinName) {
                $qb->join($joinTable, $joinTable.".id", '=', $tableName.".".$joinName);
                $qb->select($tableName.".id", $joinTable.".nome");
                $qb->orderBy($joinTable.'.nome', 'asc');
                $qb->where($joinTable.".".$fieldName,'like', "%$searchValue%");
            } else {
                $qb->select('id', 'nome');
                $qb->orderBy('nome', 'asc');
                $qb->where($fieldName,'like', "%$searchValue%");
            }
            $qb->skip($pageValue);
            $qb->take(10);

            #Validando os campos de where
            if($fieldWhere != null && $valueWhere != null) {
                $qb->where($fieldWhere, "$valueWhere");
            }

            #executando a consulta e recuperando os dados
            $resultItems = $qb->get();

            #criando o array de retorno
            foreach($resultItems as $item) {
                $result[] = [
                    "id" => $item->id,
                    "text" => $item->nome
                ];
            }

            #retorno
            return $result;
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function queryByselect2Agenda(Request $request)
    {
        try {
            #variável de retorno
            $result = array();

            #recuperando os dados da requisição
            $searchValue = $request->get('search');
            $tableName   = $request->get('tableName');
            $fieldName   = $request->get('fieldName');
            $pageValue   = $request->get('page');
            $fieldWhere  = $request->get('fieldWhere');
            $valueWhere  = $request->get('valueWhere');

//            #Validando os parametros
//            if($searchValue == null || $tableName == null || $fieldName == null || $pageValue == null) {
//                throw new \Exception('Parametros inválidos');
//            }

            #preparando a consulta
            $qb = DB::table($tableName)->select('id', 'nome');
            $qb->skip($pageValue);
            $qb->take(10);
            $qb->orderBy('nome', 'asc');
            $qb->where($fieldName,'like', "%$searchValue%");
            $qb->orWhere('numero_sus','like', "%$searchValue%");

            #Validando os campos de where
            if($fieldWhere != null && $valueWhere != null) {
                $qb->where($fieldWhere, "$valueWhere");
            }

            #executando a consulta e recuperando os dados
            $resultItems = $qb->get();

            #criando o array de retorno
            foreach($resultItems as $item) {
                $result[] = [
                    "id" => $item->id,
                    "text" => $item->nome
                ];
            }

            #retorno
            return $result;
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json([
                'error' => $e->getMessage()
            ]);
        }
    }
}
