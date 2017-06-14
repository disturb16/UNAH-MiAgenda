<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MiagndCore extends Controller
{

  /**
    * Returns true if the object is not null nor empty
    */
    public static function validValue( $object ){

      if ( $object == null || $object == "")
        return false;
        
      else
        return true;

    }

    /**
    * Returns true if the model is valid and has rows
    */
    public static function modelHasRows( $model ){

      if ( MiagndCore::validValue($model) ){

        if ($model->count() > 0)
          return true;

        else
          return false;

      }else
        return false;

    }
}
