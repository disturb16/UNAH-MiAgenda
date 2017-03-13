package com.example.disturb16.unahmyagenda;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.TextView;

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


public class Asignaturas extends ActionBarActivity {

    RecyclerView ClasesHolder;
    private List<ClassModel> listaclases;
    ProgressDialog dialog;
    String user;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        SharedPreferences userData = getSharedPreferences("user",0);
        user = userData.getString("userID","default");

        setContentView(R.layout.activity_materias);
        dialog = ProgressDialog.show(this, "Cargando Materias",
                "Por favor espere", true);

        ClasesHolder = (RecyclerView)findViewById(R.id.classes_list);

        LinearLayoutManager layoutManager = new LinearLayoutManager(Asignaturas.this,
                LinearLayoutManager.VERTICAL, false);

        ClasesHolder.setLayoutManager(layoutManager);

        new checkConnection(this).execute("http://www.unahmiagenda.000webhostapp.com/");
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_materias, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()){
        }
        return super.onOptionsItemSelected(item);
    }


    public class getForma extends AsyncTask<String,String, String >{

        @Override
        protected String doInBackground(String... params) {
            HttpURLConnection con = null;
            BufferedReader reader = null;
            BufferedOutputStream os = null;

            try {

                URL url = new URL(params[0]);
                JSONObject jsonObject = new JSONObject();
                jsonObject.put("usuarioID",params[1]);
                String message = jsonObject.toString();

                con = (HttpURLConnection) url.openConnection();
                con.setDoOutput(true);
                //make some HTTP header nicety
                con.setRequestProperty("Content-Type", "application/json;charset=utf-8");
                con.setRequestProperty("X-Requested-With", "XMLHttpRequest");
                //open
                con.connect();

                os = new BufferedOutputStream(con.getOutputStream());
                os.write(message.getBytes());
                //clean up
                os.flush();

                //Obtener response
                InputStream stream = con.getInputStream();
                //BufferReader para leer el string
                reader = new BufferedReader(new InputStreamReader(stream));

                StringBuffer buffer = new StringBuffer();
                String line = "";
                while ((line = reader.readLine()) != null) {
                    buffer.append(line);
                }
                listaclases = new ArrayList<>();
                //pasar respuesta a Json object
                String JSONResponse =  buffer.toString();
                JSONObject parentObject = new JSONObject(JSONResponse);
                //pasar el objecto de Json a un array
                JSONArray noticias_array = parentObject.getJSONArray("Forma03");

                for (int i = 1; i < noticias_array.length();i++){
                    JSONObject JsonNew = noticias_array.getJSONObject(i);
                    listaclases.add( new ClassModel(JsonNew.getString("seccion"), JsonNew.getString("titulo"), JsonNew.getInt("horaInicio"))  );
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
            ClassesAdapter adapter = new ClassesAdapter(listaclases, Asignaturas.this);
            ClasesHolder.setAdapter(adapter);
            dialog.dismiss();
        }

    }
    public class checkConnection extends AsyncTask<String, String, String> {

        Context context;

        checkConnection (Context context){
            this.context = context;
        }

        @Override
        protected String doInBackground(String... params) {
            HttpURLConnection con = null;

            try {

                URL url = new URL(params[0]);

                con = (HttpURLConnection) url.openConnection();
                //make some HTTP header nicety
                con.setRequestProperty("Content-Type", "application/json;charset=utf-8");
                con.setRequestProperty("X-Requested-With", "XMLHttpRequest");
                //open
                con.connect();

                return "";
            } catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }
            finally{
                if (con != null)
                    con.disconnect();
            }
            return null;
        }

        @Override
        protected void onPostExecute(String s) {
            super.onPostExecute(s);
            if (s != null)
                new getForma().execute("http://unahmiagenda.000webhostapp.com/getForma003.php", user);
            else {
                TextView errorMesj = (TextView) findViewById(R.id.errorMsj);
                errorMesj.setVisibility(View.VISIBLE);
                dialog.dismiss();
            }
        }
    }

}