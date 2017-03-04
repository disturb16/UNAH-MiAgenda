package com.example.disturb16.unahmyagenda;

/**
 * Created by Disturb16 on 18/02/2016.
 */
public class NewsModel {

    String titulo;
    String photoID;
    String noticiaID;

    NewsModel(String _noticiaID, String _titulo, String _photoID){
        titulo = _titulo;
        photoID = _photoID;
        noticiaID = _noticiaID;
    }
}
