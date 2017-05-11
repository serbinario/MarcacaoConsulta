<?php

namespace Seracademico\Uteis;

use Carbon\Carbon;

class SerbinarioDateFormat
{
    /**
     * @param $dateText
     * @return string
     */
    public static function toBrazil($dateText, $time = false)
    {
        #Verificando se o tipo do dado � v�lido
        if(is_string($dateText) && $dateText != '0000-00-00' && $dateText != '00:00:00') {
            #Verificando se � s� o para retorna a hora
            if($time) {
                #Transformando em data
                $date = Carbon::createFromFormat('H:i:s', $dateText);

                #retorno da hora em string
                return $date->format('H:i:s');
            }

            #Transformando em data
            $date = Carbon::createFromFormat('Y-m-d', $dateText);

            #retorno da data em portugues (string)
            return $date->format('d/m/Y');
        }

        #retorno caso o valor passado n�o seja v�lido
        return "";
    }

    /**
     * @param $dateText
     * @param bool $type
     * @return null|string
     */
    public static function toUsa($dateText, $time = false)
    {
        #Verificando se o tipo do dado � v�lido
        if(is_string($dateText) && $dateText != "") {
            #Verificando se � s� o para retorna a hora
            if($time) {
                #Transformando em data
                $date = Carbon::createFromFormat('H:i:s', $dateText);

                #retorno da hora em string
                return $date->format('H:i:s');
            }

            #Transformando em data
            $date = Carbon::createFromFormat('d/m/Y', $dateText);

            #retorno da data em ingl�s (string)
            return $date->format('Y-m-d');
        }

        #retorno caso o valor passado n�o seja v�lido
        return null;
    }
}