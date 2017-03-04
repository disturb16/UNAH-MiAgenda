package com.example.disturb16.unahmyagenda;

/**
 * Created by Disturb16 on 02/04/2016.
 */
public class CalendarDateModel {
    String fechaID, titulo,
            tipoFecha, fecha, descripcion;

    CalendarDateModel(String _fechaID, String _titulo, String _tipoFecha, String _fecha, String _descripcion){
        fechaID = _fechaID;
        titulo = _titulo;
        tipoFecha = _tipoFecha;
        fecha = _fecha;
        descripcion = _descripcion;
    }

}
