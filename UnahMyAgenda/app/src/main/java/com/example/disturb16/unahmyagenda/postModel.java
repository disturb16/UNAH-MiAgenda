package com.example.disturb16.unahmyagenda;

/**
 * Created by Disturb16 on 24/02/2016.
 */
public class postModel {

    String titulo, commentsCount;
    String fecha;
    String postID;

    postModel(String titulo, String fecha, String commentsCount, String ID){
        this.titulo = titulo;
        this.fecha = fecha;
        this.commentsCount = commentsCount;
        postID = ID;

    }

}
