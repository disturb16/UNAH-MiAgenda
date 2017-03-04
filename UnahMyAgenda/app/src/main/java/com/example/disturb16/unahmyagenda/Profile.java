package com.example.disturb16.unahmyagenda;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Bitmap;
import android.net.Uri;
import android.os.AsyncTask;
import android.provider.MediaStore;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.support.v7.widget.CardView;
import android.util.Base64;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.squareup.picasso.Picasso;
import com.squareup.picasso.Request;
import com.squareup.picasso.RequestHandler;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedOutputStream;
import java.io.BufferedReader;
import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.HashMap;


public class Profile extends ActionBarActivity implements View.OnClickListener {

    String userID;
    ImageButton addBtn;
    String name, pictureUrl;
    String edad, userName;
    protected Uri imagePath;
    Bitmap imageBitmap;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_perfil);

        SharedPreferences userData = getSharedPreferences("user",0);
        userID = userData.getString("userID","default");
        addBtn = (ImageButton)findViewById(R.id.addBtn);
        addBtn.setOnClickListener(this);

        new getUserData(this).execute("http://www.unahmiagenda.site88.net/gtusr.php",userID);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_perfil, menu);
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
            case R.id.addBtn:
                Intent intent = new Intent();
                intent.setType("image/*");
                intent.setAction(Intent.ACTION_GET_CONTENT);
                startActivityForResult(Intent.createChooser(intent, "Selecciona una imágen"), 1 );
                break;
        }
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {

        if (requestCode == 1) {
            if(resultCode == Activity.RESULT_OK){
                imagePath = data.getData();
                try {
                    imageBitmap = MediaStore.Images.Media.getBitmap(getContentResolver(), imagePath);
                    ImageView perfil_photo = (ImageView) findViewById(R.id.perfil_foto);
                    new uploadImage(imageBitmap).execute(userID);
                } catch (IOException e) {
                    e.printStackTrace();
                }
            }
            if (resultCode == Activity.RESULT_CANCELED) {
                //Write your code if there's no result
            }
        }
    }//onActivityResult


    public class getUserData extends AsyncTask<String,String, String > {
        Context context;


        getUserData(Context _context){
            context = _context;
        }


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
                String message = jsonObject.toString();
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
                name = parentObject.getString("name");
                pictureUrl = "http://unahmiagenda.site88.net/" + parentObject.getString("picture");
                edad = "";
                userName = parentObject.getString("userName");
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
                } catch (IOException e) {
                    e.printStackTrace();
                }
            }
            return null;
        }

        @Override
        protected void onPostExecute(String result) {
            super.onPostExecute(result);
            ImageView perfilFoto = (ImageView)findViewById(R.id.perfil_foto);
            TextView _name = (TextView) findViewById(R.id.name);
            TextView _edad = (TextView) findViewById(R.id.edad);
            TextView _userName = (TextView) findViewById(R.id.userName);
            _name.setText(name);
            _edad.setText(edad);
            _userName.setText(userName);
            Picasso.with(context)
                    .load(pictureUrl)
                    .transform(new CircleTransform())
                    .into(perfilFoto);
        }

    }//getUserInfo

    public class uploadImage extends AsyncTask< String, String, String>{

        Bitmap _image;

        uploadImage(Bitmap image){
            _image = image;
        }

        @Override
        protected String doInBackground(String... params) {
            HttpURLConnection con = null;
            BufferedOutputStream os= null;


            try {

                URL url = new URL("http://gmerse.com/androidTest/uploadPrflImage.php");
                con = (HttpURLConnection) url.openConnection();

                ByteArrayOutputStream byteArrayOutputStream = new ByteArrayOutputStream();
                _image.compress(Bitmap.CompressFormat.JPEG, 100, byteArrayOutputStream);
                byte[] byte_arr = byteArrayOutputStream.toByteArray();
                String _imageEncoded = Base64.encodeToString(byte_arr, Base64.DEFAULT);
                JSONObject jsonObject = new JSONObject();
                jsonObject.put("userID", params[0]);
                jsonObject.put("imageEncoded", _imageEncoded);
                String message = jsonObject.toString();

                con.setDoOutput(true);
                con.setRequestProperty("Content-Type", "application/json;charset=utf-8");
                con.setRequestProperty("X-Requested-With", "XMLHttpRequest");
                //open
                con.connect();

                os = new BufferedOutputStream(con.getOutputStream());
                os.write(message.getBytes());
                //clean up
                os.flush();

                return "";


            }  catch (IOException e) {
                e.printStackTrace();
            } catch (JSONException e) {
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
            }

            return null;
        }

        @Override
        protected void onPostExecute(String result) {
            super.onPostExecute(result);

        }
    }//uploadImage
}
