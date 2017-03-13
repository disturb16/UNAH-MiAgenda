package com.example.disturb16.unahmyagenda;

/**
 * Created by Disturb16 on 24/02/2016.
 */
public class DetallePublicacionModelo {

    String titulo, commentsCount;
    String fecha;
    String postID;

    DetallePublicacionModelo(String titulo, String fecha, String commentsCount, String ID){
        this.titulo = titulo;
        this.fecha = fecha;
        this.commentsCount = commentsCount;
        postID = ID;

    }

}
