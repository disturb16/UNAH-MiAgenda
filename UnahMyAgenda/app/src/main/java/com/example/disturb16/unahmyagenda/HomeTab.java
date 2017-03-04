package com.example.disturb16.unahmyagenda;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.Menu;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedOutputStream;
import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.ArrayList;
import java.util.List;


public class HomeTab extends AppCompatActivity implements AdapterView.OnItemClickListener, View.OnClickListener{

    RecyclerView notisHolder;

    private List<NewsModel> noticias;
    ListView Menu;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_welcome);
        SharedPreferences userData = getSharedPreferences("user",0);

        if (userData.getString("Name","default") == "default"){
            startActivity(new Intent(this, Login.class));
            finish();
        }
        notisHolder = (RecyclerView)findViewById(R.id.notis_list);
        LinearLayoutManager layoutManager = new LinearLayoutManager(HomeTab.this,
                LinearLayoutManager.HORIZONTAL /*para indicar que sea horizontal*/, false);
        notisHolder.setLayoutManager(layoutManager);

    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_welcome, menu);
        return true;
    }

    @Override
    public void onItemClick(AdapterView<?> parent, View view, int position, long id) {

    }

    @Override
    public void onClick(View v) {

    }


    public class getNotis extends AsyncTask<String,String, String> {

        @Override
        protected String doInBackground(String... params) {
            HttpURLConnection con = null;
            BufferedReader reader = null;
            BufferedOutputStream os= null;

            try {
                URL url = new URL(params[0]);
                con = (HttpURLConnection) url.openConnection();
                //make some HTTP header nicety
                con.setRequestProperty("Content-Type", "application/json;charset=utf-8");
                con.setRequestProperty("X-Requested-With", "XMLHttpRequest");
                //open
                con.connect();

                //Obtener response
                InputStream stream = con.getInputStream();
                //BufferReader para leer el string
                reader = new BufferedReader(new InputStreamReader(stream));

                StringBuffer buffer = new StringBuffer();
                String line = "";
                while ((line = reader.readLine()) != null) {
                    buffer.append(line);
                }
                noticias = new ArrayList<>();
                //pasar respuesta a Json object
                String JSONResponse =  buffer.toString();
                JSONObject root = new JSONObject(JSONResponse);
                //pasar el objecto de Json a un array
                JSONArray NotisArray = root.getJSONArray("Noticias");

                //Recorrer Arreglo JSON
                for (int i=1; i <= NotisArray.length(); i++){
                    JSONObject noticia = NotisArray.getJSONObject(i);
                 //   noticias.add(new NewsModel(noticia.getString("titulo"), R.drawable.tecnolo));

                }
                return "";
            } catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            } catch (JSONException e) {
                e.printStackTrace();
            } finally {
                if (con != null)
                    con.disconnect();
                if (os != null)
                    try {
                        os.close();
                    } catch (IOException e) {
                        e.printStackTrace();
                    }
                try {
                    if (reader != null)
                        reader.close();
                } catch (IOException e) {
                    e.printStackTrace();
                }
            }
            return null;
        }

        @Override
        protected void onPostExecute(String result) {
            super.onPostExecute(result);


        }

    }

}

