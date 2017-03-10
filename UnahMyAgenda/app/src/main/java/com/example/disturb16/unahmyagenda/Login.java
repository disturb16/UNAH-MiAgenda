package com.example.disturb16.unahmyagenda;


import android.app.ProgressDialog;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
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


public class Login extends ActionBarActivity implements View.OnClickListener{

    private EditText user, pwd;
    private Button btnLogIn;
    String usr;
    TextView msj, register;
    boolean _logged;
    String name, userID, userType, errCod;
    ProgressDialog progress;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        user = (EditText) findViewById(R.id.edUser);
        pwd = (EditText) findViewById(R.id.edPwd);
        btnLogIn = (Button) findViewById(R.id.button);
        msj = (TextView) findViewById(R.id.textView2);
        register = (TextView)findViewById(R.id.registerLink);

        register.setOnClickListener(this);
        btnLogIn.setOnClickListener(this);

    }


    @Override
    public void onClick(View v) {
        switch (v.getId()) {
            case R.id.button:
                progress = ProgressDialog.show(this, "Cargando",
                        "Iniciando sesion", true);
                String url = "http://unahmiagenda.000webhostapp.com/getUserData.php";
                usr = user.getText().toString();
                String pass = pwd.getText().toString();
                if(usr.length() == 11 ){
                        new JSONTask().execute(url, usr, pass);
                }else{
                    progress.dismiss();
                    Toast.makeText(getApplicationContext(),"El numero de cuenta no es valido", Toast.LENGTH_SHORT).show();
                }

                break;

            case R.id.registerLink:
                startActivity(new Intent(this,Register.class));
                break;
        }
    }



    public class JSONTask extends AsyncTask<String,String, String> {


        @Override
        protected String doInBackground(String... params) {
            HttpURLConnection con = null;
            BufferedReader reader = null;
            BufferedOutputStream os= null;
            _logged = false;

            try {

                URL url = new URL(params[0]);
                JSONObject jsonObject = new JSONObject();
                jsonObject.put("user",params[1]);
                jsonObject.put("pass", params[2]);
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
                //pasar el objecto de Json a un array
                name = parentObject.getString("nombre");
                userID = parentObject.getString("usuarioID");
                userType = parentObject.getString("tipoUsuarioID");
                errCod = parentObject.getString("errCod");

                //validar login
                if (errCod.equals("1"))
                    _logged = true;

                return name;


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
                        if (os != null)
                            os.close();
                } catch (IOException e) {
                    e.printStackTrace();
                }
            }
            return null;
        }

        @Override
        protected void onPostExecute(String result) {
            super.onPostExecute(result);
            try {
                SharedPreferences userData = getSharedPreferences("user", 0);
                SharedPreferences.Editor editUser = userData.edit();
                editUser.putString("Name", name);
                editUser.putString("userID", userID);
                editUser.putString("userType", userType);
                editUser.apply();
            }finally {
                if (_logged) {
                    progress.dismiss();
                    startActivity(new Intent(Login.this, MainActivity.class));
                    finish();
                }
                else {
                    SharedPreferences userData = getSharedPreferences("user",0);
                    SharedPreferences.Editor editUser = userData.edit();
                    editUser.clear();
                    editUser.apply();
                    progress.dismiss();
                    Toast.makeText( getApplicationContext(), "el número de cuenta o contraseña es incorrecto", Toast.LENGTH_SHORT).show();
                }
            }
        }
    }


    }


