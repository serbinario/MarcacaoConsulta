<?php

namespace Seracademico\Validators;


trait TraitReplaceRulesValidator
{
    /**
     * @param $action
     * @param $param
     * @param $id
     * @return bool
     */
    public function replaceRules($action, $param, $id)
    {

        #Verificando se os parametros foram passados
        if (!isset($id) && !isset($param) && !isset($action)) {
            return false;
        }
        #recuperando as rules
        $rules = $this->getRules($action);

        #fazendo o replace nas rules
        foreach ($rules as &$rule) {
            $rule = str_replace($param, $id, $rule);
        }
        //dd($rules);
        #setando as rules
        $this->setRules($rules);

        #retorno
        return true;
    }
}