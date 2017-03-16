package com.example.disturb16.unahmyagenda;

import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.Spinner;
import android.widget.Toast;

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


public class SolicitudSeccion extends ActionBarActivity implements View.OnClickListener {

    Spinner seccionSpinner, horasSpinner;
    List<String> materiasArray, horas;
    List<ClassToRequest> materias;
    Button btnSendTicket;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_request_seccion);
        //Spinner hora elements
        horas = new ArrayList<String>();
        for (int i = 7; i <= 12; i++){
            horas.add(Integer.toString(i) +" AM");
        }
        for (int i = 1; i <= 8; i++){
            horas.add(Integer.toString(i) +" PM");
        }

        seccionSpinner = (Spinner)findViewById(R.id.seccionSpinner);
        horasSpinner = (Spinner)findViewById(R.id.horaSpinner);

        new getClases().execute("http://unahmiagenda.000webhostapp.com/getAsignaturaSolicitar.php");

        btnSendTicket = (Button) findViewById(R.id.btnSendTicket);
        btnSendTicket.setOnClickListener(this);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_request_seccion, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement


        return super.onOptionsItemSelected(item);
    }

    @Override
    public void onClick(View v) {
        switch (v.getId()){
            case R.id.btnSendTicket:

                SharedPreferences userData = getSharedPreferences("user", 0);
                String userID = userData.getString("userID", "");

                int position = seccionSpinner.getSelectedItemPosition();
                String materiaID = materias.get(position).materiaID;
                String horaToRequest = horasSpinner.getSelectedItem().toString();
                String url = "http://unahmiagenda.000webhostapp.com/enviarSolicitudSeccion.php";

                new enviarSolicitudSeccion().execute(url,userID,materiaID,horaToRequest);

                break;
        }
    }

    private class enviarSolicitudSeccion extends AsyncTask<String, String, String>{

        @Override
        protected String doInBackground(String... params) {
            HttpURLConnection con = null;
            BufferedReader reader = null;
            BufferedOutputStream os= null;


            try {

                URL url = new URL(params[0]);

                con = (HttpURLConnection) url.openConnection();
                JSONObject jsonObject = new JSONObject();
                jsonObject.put("userID", params[1]);
                jsonObject.put("materiaID", params[2]);
                jsonObject.put("hora", params[3]);
                String message = jsonObject.toString();

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
                //pasar respuesta a Json object
                String JSONResponse =  buffer.toString();
                JSONObject parentObject = new JSONObject(JSONResponse);
                String success = parentObject.getString("success");
                return success;


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
        }//doInB ackground

        @Override
        protected void onPostExecute(String s) {
            super.onPostExecute(s);
            if (s.equals("1")) {
                Toast.makeText(SolicitudSeccion.this,"Solicitud Enviada", Toast.LENGTH_SHORT).show();
                finish();
            }else {
                Toast.makeText(SolicitudSeccion.this, "Error al enviar solicitud", Toast.LENGTH_SHORT).show();
                finish();
            }
        }
    }

    private class getClases extends AsyncTask<String, String, String>{



        @Override
        protected String doInBackground(String... params) {
            HttpURLConnection con = null;
            BufferedReader reader = null;
            BufferedOutputStream os = null;

            try {

                URL url = new URL(params[0]);

                con = (HttpURLConnection) url.openConnection();
                con.setDoOutput(true);
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
                //pasar respuesta a Json object
                String JSONResponse =  buffer.toString();
                JSONObject parentObject = new JSONObject(JSONResponse);
                materias = new ArrayList<>();
                String nombreMateria = "";
                JSONArray MainnArray = parentObject.getJSONArray("Asignaturas");

                for (int i= 1; i < MainnArray.length();i++){
                    JSONObject clase = MainnArray.getJSONObject(i);
                    nombreMateria = clase.getString("descripcion");
                    materias.add(new ClassToRequest(clase.getString("asignaturaID"),clase.getString("descripcion")
                    ));

                }

                return nombreMateria;


            } catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (JSONException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }
            finally {
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
        protected void onPostExecute(String s) {
            super.onPostExecute(s);
            // Spinner Drop down elements
            materiasArray = new ArrayList<String>();
            for (int i=0; i < materias.size(); i++) {
                materiasArray.add( materias.get(i).nombreMateria.toString());
            }
            ArrayAdapter<String> seccionAdapter = new ArrayAdapter<String>(getApplicationContext(),R.layout.spinner_style_item1,materiasArray);
            seccionSpinner.setAdapter(seccionAdapter);

            ArrayAdapter<String> horaAdapter = new ArrayAdapter<String>(getApplicationContext(),R.layout.spinner_style_item1, horas);
            horasSpinner.setAdapter(horaAdapter);

        }
    }


}
