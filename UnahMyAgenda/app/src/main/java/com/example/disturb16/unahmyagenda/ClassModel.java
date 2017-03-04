package com.example.disturb16.unahmyagenda;

/**
 * Created by Disturb16 on 02/04/2016.
 */
public class ClassModel {
    String seccion;
    String nombreMateria;
    String horaInicio;

    ClassModel(String _seccion, String _nombreMateria, int hora){
        seccion = _seccion;
        nombreMateria = _nombreMateria;

        switch (hora){
            case 13:
                horaInicio = "1 PM";
                break;
            case 14:
                horaInicio = "2 PM";
                break;
            case 15:
                horaInicio = "3 PM";
                break;
            case 16:
                horaInicio = "4 PM";
                break;
            case 17:
                horaInicio = "5 PM";
                break;
            case 18:
                horaInicio = "6 PM";
                break;
            case 19:
                horaInicio = "7 PM";
                break;
            case 20:
                horaInicio = "8 PM";
                break;
            case 21:
                horaInicio = "9 PM";
                break;
            case 22:
                horaInicio = "10 PM";
                break;
            case 23:
                horaInicio = "11 PM";
                break;
            case 24:
                horaInicio = "12 PM";
                break;
            default:
                horaInicio = hora + " AM";
        }

    }

}
