<?php

if (! function_exists('valida_rut')) {
    function valida_rut($rut_param){

        //validaciones varias
        //....
        $contar = strlen($rut_param);

        if ($contar == 8){
            $parte1 = substr($rut_param, 0,1); //12
            $parte2 = substr($rut_param, 1,3); //345
            $parte3 = substr($rut_param, 4,3); //456
            $parte4 = substr($rut_param, 7);   //todo despues del caracter 8

        return $parte1.".".$parte2.".".$parte3."-".$parte4;
        }elseif($contar >= 9){
            $parte1 = substr($rut_param, 0,2); //12
            $parte2 = substr($rut_param, 2,3); //345
            $parte3 = substr($rut_param, 5,3); //456
            $parte4 = substr($rut_param, 8);   //todo despues del caracter 8
        return $parte1.".".$parte2.".".$parte3."-".$parte4;

        }else{
            return $rut_param;
        }


    }
}
