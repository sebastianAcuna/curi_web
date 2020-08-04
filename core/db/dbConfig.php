<?php

   /* BASE DE DATOS CURIWEB    */
   include_once($_SERVER['DOCUMENT_ROOT']."/a_funcion_sistemas/sql_conec_bds.php");
   $ArrayFunGlobConec=FunGlobSisConectaBDsServ("bd_fm_curimapu","sis_301_bd_curimapu",__FILE__,"SI","SI","","","");
   define('HOST_NAME',$ArrayFunGlobConec["ServConecc"]);
   define('DATABASE_NAME','curimapu_tabletas');
   define('USER','bd_fm_curimapu');
   define('PASSWORD','sis_301_bd_curimapu');
   define('CHARSET','utf8');
   

   /* COMPARAR BD EN PESTANA TABLAS */
   define('HOST_NAME_DOS','190.13.170.29');
   define('DATABASE_NAME_DOS','curimapu_tabletas');
   define('USER_DOS','bd_fm_curimapu');
   define('PASSWORD_DOS', 'sis_301_bd_curimapu');
   define('CHARSET_DOS','utf8');



 /*  BASE DE DATOS DE DESCARGA DE INFO */
   $ArrayFunGlobConecD=FunGlobSisConectaBDsServ("bd_curimapu_sz","sis_301_bd_cur_sz",__FILE__,"SI","SI","","","");
  //  define('HOST_NAME_INTERCAMBIO_DESCARGA',$ArrayFunGlobConecD["ServConecc"]);
   define('HOST_NAME_INTERCAMBIO_DESCARGA',$ArrayFunGlobConecD["ServConecc"]);
   define('DATABASE_NAME_INTERCAMBIO_DESCARGA','pruebas_intercambio');
   define('USER_INTERCAMBIO_DESCARGA','bd_curimapu_sz');
   define('PASSWORD_INTERCAMBIO_DESCARGA', 'sis_301_bd_cur_sz');
   define('CHARSET_INTERCAMBIO_DESCARGA','utf8');

    /*  BASE DE DATOS DE SUBIDA DE INFO */
   $ArrayFunGlobConecS=FunGlobSisConectaBDsServ("bd_curimapu_zs","sis_301_bd_cur_zs",__FILE__,"SI","SI","","","");
   define('HOST_NAME_INTERCAMBIO_SUBIDA',$ArrayFunGlobConecS["ServConecc"]);
   define('DATABASE_NAME_INTERCAMBIO_SUBIDA','curimapu_zionit_sap');
   define('USER_INTERCAMBIO_SUBIDA','bd_curimapu_zs');
   define('PASSWORD_INTERCAMBIO_SUBIDA', 'sis_301_bd_cur_zs');
   define('CHARSET_INTERCAMBIO_SUBIDA','utf8');
