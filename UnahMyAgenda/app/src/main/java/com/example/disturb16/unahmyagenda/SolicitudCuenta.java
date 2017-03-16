package com.example.disturb16.unahmyagenda;

import android.app.DatePickerDialog;
import android.app.Dialog;
import android.os.AsyncTask;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.RelativeLayout;
import android.widget.Toast;

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


public class SolicitudCuenta extends ActionBarActivity implements View.OnClickListener {

    Button cancel, register;
    EditText cuenta, name, pwd, pwd2, dateOfBirth, edEmai;
    RelativeLayout loading;
    int _year = 1990, _month = 1, _day = 1;
    static final int datePickerID = 160;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register);
        loading = (RelativeLayout)findViewById(R.id.loading);

        cuenta = (EditText)findViewById(R.id.edCtaRegister);
        name = (EditText)findViewById(R.id.edNameRegister);
        pwd = (EditText)findViewById(R.id.edPwdRegister);
        pwd2 = (EditText)findViewById(R.id.edPwdRegister2);
        dateOfBirth = (EditText)findViewById(R.id.edAgeRegister);
        edEmai = (EditText)findViewById(R.id.edEmailRegister);

        cancel = (Button)findViewById(R.id.btnCancelRegister);
        register = (Button)findViewById(R.id.btnRegister);
        dateOfBirth.setOnClickListener(this);
        register.setOnClickListener(this);
        cancel.setOnClickListener(this);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_register, menu);
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
    protected Dialog onCreateDialog(int id) {
        // TODO Auto-generated method stub
        if (id == 160) {
            return new DatePickerDialog(this,
                    myDateListener, _year, _month, _day);
        }
        return null;
    }


    private DatePickerDialog.OnDateSetListener myDateListener = new DatePickerDialog.OnDateSetListener() {
        @Override
        public void onDateSet(DatePicker arg0, int year, int month, int day) {
            _year = year;
            _month  = month + 1;
            _day = day;
            dateOfBirth.setText(_day + "/" +_month+ "/" +_year);
        }
    };

    @Override
    public void onClick(View v) {
        switch(v.getId()) {
            case R.id.btnCancelRegister:
                finish();
                break;

            case R.id.edAgeRegister:
                showDialog(datePickerID);
                break;

            case R.id.btnRegister:
                String url = "http://unahmiagenda.000webhostapp.com/enviarSolicitudCuenta.php";
                String cta = cuenta.getText().toString();
                String nombre = name.getText().toString();
                String edad = dateOfBirth.getText().toString();
                String pass1 = pwd.getText().toString();
                String pass2 = pwd2.getText().toString();
                String email = edEmai.getText().toString();

                if ( !cta.isEmpty() && !nombre.isEmpty() && !edad.isEmpty() && !pass1.isEmpty() && !email.isEmpty() ){
                    if (pass1.equals(pass2)){
                        loading.setVisibility(View.VISIBLE);
                        new enviarSolicitudCuenta().execute(url,cta,nombre,pass1,edad,email);
                    }else
                        Toast.makeText(SolicitudCuenta.this, "Las contraseñas no coinciden", Toast.LENGTH_LONG).show();
                }else
                    Toast.makeText(SolicitudCuenta.this, "Debes completar todos los campos", Toast.LENGTH_LONG).show();
                break;
        }
    }


    //Asycktask para Registrar
    class enviarSolicitudCuenta extends AsyncTask<String, String, String>{

        @Override
        protected String doInBackground(String... params) {
            HttpURLConnection con = null;
            BufferedReader reader = null;
            BufferedOutputStream os= null;

            try {

                URL url = new URL(params[0]);
                JSONObject jsonObject = new JSONObject();
                jsonObject.put("cuenta",params[1]);
                jsonObject.put("nombre", params[2]);
                jsonObject.put("pwd", params[3]);
                jsonObject.put("age", params[4]);
                jsonObject.put("email", params[5]);
                jsonObject.put("_bDay", _day);
                jsonObject.put("_bMonth", _month);
                jsonObject.put("_bYear", _year);
                String message = jsonObject.toString();

                con = (HttpURLConnection) url.openConnection();
                con.setRequestMethod("POST");
                con.setDoInput(true);
                con.setDoOutput(true);
                con.setFixedLengthStreamingMode(message.getBytes().length);
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
                try {
                    if (reader != null)
                        reader.close();
                        if (os != null)
                            os.close();
                } catch (IOException e) {
                    e.printStackTrace();
                }
            }
            return null;
        }

        @Override
        protected void onPostExecute(String s) {
            super.onPostExecute(s);
            loading.setVisibility(View.GONE);
            if (s.equals("1")) {
                Toast.makeText(SolicitudCuenta.this,"Solicitud Enviada", Toast.LENGTH_SHORT).show();
                finish();
            }
            if (s.equals("2")){
                Toast.makeText(SolicitudCuenta.this,"El número de cuenta ya existe", Toast.LENGTH_SHORT).show();
            }
            if (s.equals("3")){
                Toast.makeText(SolicitudCuenta.this,"Existe una solicitud pendiente con este número de cuenta", Toast.LENGTH_SHORT).show();
            }
            else {
                Toast.makeText(SolicitudCuenta.this, "Error al enviar solicitud", Toast.LENGTH_SHORT).show();
            }
        }
    }
}
