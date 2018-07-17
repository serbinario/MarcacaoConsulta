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

            //dd($table);

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
                ->join('age_tipo_operacoes', 'age_tipo_operacoes.id', '=', $table.'.tipo_operacao_id')
                ->select([
                    $table.'.nome',
                    $table.'.id'
            ])->orderBy($table.'.nome', 'asc')->where($filed, $value)->get();

            if($tipo == '1') {

                foreach ($grupos as $grupo) {
                    $gruposArray[] = [
                        'text' => $grupo->nome,
                        'children' => DB::table('age_operacoes')
                            ->join('age_grupo_operacoes', 'age_grupo_operacoes.id', '=', 'age_operacoes.grupo_operaco_id')
                            ->select([
                                'age_operacoes.nome as text',
                                'age_operacoes.id'
                            ])->orderBy('age_operacoes.nome', 'asc')->where('age_grupo_operacoes.id', $grupo->id)->get()
                    ];
                }

            } else {
                foreach ($grupos as $grupo) {
                    $gruposArray[] = [
                        'text' => $grupo->nome,
                        'children' => DB::table('age_especialidade')
                            ->join('age_operacoes', 'age_operacoes.id', '=', 'age_especialidade.operacao_id')
                            ->join('age_grupo_operacoes', 'age_grupo_operacoes.id', '=', 'age_operacoes.grupo_operaco_id')
                            ->select([
                                'age_operacoes.nome as text',
                                'age_especialidade.id',
                                'age_operacoes.id as operacao'
                            ])->orderBy('age_operacoes.nome', 'asc')->where('age_grupo_operacoes.id', $grupo->id)->get()
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

    /**
     * @param Request $request
     * @return mixed
     */
    public function queryByselect2FilaDeEspera(Request $request)
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
            $qb = DB::table($tableName)->select('id', 'nome', 'numero_sus');
            $qb->skip($pageValue);
            $qb->take(10);
            $qb->orderBy('nome', 'asc');
            $qb->where($fieldName,'like', "%$searchValue%");
            $qb->orWhere('numero_sus','like', "%$searchValue%");
            $qb->orWhere('numero_nis','like', "%$searchValue%");
            $qb->orWhere('cpf_cnpj','like', "%$searchValue%");

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
                    "text" => $item->nome . " SUS: " . $item->numero_sus
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
