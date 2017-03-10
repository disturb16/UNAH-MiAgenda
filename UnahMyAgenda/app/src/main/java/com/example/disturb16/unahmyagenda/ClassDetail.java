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
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.ScrollView;
import android.widget.TextView;
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


public class ClassDetail extends ActionBarActivity implements View.OnClickListener {

    RecyclerView postsHolder;
    private List<postModel> posts;
    TextView teacherName, aula, edificio, codClase, scoreClose, score1, score2, score3, scoreTotal;
    ScrollView svPostData, mainScrollView;
    ProgressDialog dialog;
    LinearLayout btnPostContainer, scoresLayout;
    Button btnPost, btnClose, btnPostData;
    RelativeLayout mainInfocontainer,postData;
    EditText edTitulo, edContent;
    String seccion, catedraticoID, userID;
    ImageButton scoreBtn;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_class_detail);
        //Setting up Title Tesxt
        setTitle(getIntent().getExtras().getString("tituloClase"));


        mainInfocontainer = (RelativeLayout)findViewById(R.id.mainInfocontainer);
        teacherName = (TextView) findViewById(R.id.teacherName);
        aula = (TextView) findViewById(R.id.aula);
        edificio = (TextView) findViewById(R.id.edificio);
        codClase = (TextView) findViewById(R.id.codClase);
        scoreClose = (TextView) findViewById(R.id.scoreClose);
        postsHolder = (RecyclerView)findViewById(R.id.class_posts);
        btnPostContainer = (LinearLayout)findViewById(R.id.btnPostContainer);
        svPostData = (ScrollView)findViewById(R.id.svPostData);
        scoresLayout = (LinearLayout)findViewById(R.id.scoresLayout);
        scoreBtn = (ImageButton)findViewById(R.id.scoreBtn);
        scoreBtn.setOnClickListener(this);
        scoreClose.setOnClickListener(this);
        scoresLayout.setOnClickListener(this);

        edTitulo = (EditText)findViewById(R.id.edTitulo);
        edContent = (EditText)findViewById(R.id.edContent);
        btnPost = (Button)findViewById(R.id.btnPostClass);
        btnClose = (Button)findViewById(R.id.btnClose);
        btnPostData = (Button)findViewById(R.id.btnPostData);

        SharedPreferences userData = getSharedPreferences("user", 0);
        if (userData.getString("userType", "").equals("3")) {
            btnPostContainer.setVisibility(View.VISIBLE);
            btnPost.setOnClickListener(this);
            btnClose.setOnClickListener(this);
            btnPostData.setOnClickListener(this);
            catedraticoID = userData.getString("userID","");
        }
        else{
            userID = userData.getString("userID","");
            btnPostContainer.setVisibility(View.GONE);
        }



        dialog = ProgressDialog.show(this, "Cargando contenido",
                "Por favor espere", true);
        seccion = getIntent().getExtras().getString("seccion");
        new getDetailsClass(this).execute("http://www.unahmiagenda.site88.net/getDetailsClass.php", seccion);
        new getScore().execute("http://www.unahmiagenda.site88.net/getClassScore.php", seccion, userID);

    }


    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_class_detail, menu);
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
            case R.id.btnPostClass:
                svPostData.setVisibility(View.VISIBLE);
                break;

            case R.id.btnPostData:
                String url = "http://www.unahmiagenda.site88.net/postClassNew.php";
                String titulo = edTitulo.getText().toString();
                String content = edContent.getText().toString();
                if(!titulo.isEmpty() && !content.isEmpty()){
                    new postClassNew().execute(url,seccion, catedraticoID, titulo, content, getIntent().getExtras().getString("tituloClase"));
                }else{
                    Toast.makeText(ClassDetail.this, "Debes llenar todos los campos",Toast.LENGTH_SHORT).show();
                }

                break;

            case R.id.btnClose:
                svPostData.setVisibility(View.GONE);
                break;

            case R.id.scoreBtn:
                    scoresLayout.setVisibility(View.VISIBLE);
                break;
            case R.id.scoreClose:
                scoresLayout.setVisibility(View.GONE);
                break;

            case R.id.scoresLayout:
                scoresLayout.setVisibility(View.GONE);
                break;
        }
    }


    public class getDetailsClass extends AsyncTask<String,String,String>{

        String nombreCatedratico, noaula, noedificio, codMateria;
        Context context;

        getDetailsClass(Context context){
            this.context = context;
        }


        @Override
        protected String doInBackground(String... params) {
            HttpURLConnection con = null;
            BufferedReader reader = null;
            BufferedOutputStream os = null;

            try {

                URL url = new URL(params[0]);
                JSONObject jsonObject = new JSONObject();
                jsonObject.put("seccion",params[1]);
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
                //pasar respuesta a Json object
                String JSONResponse =  buffer.toString();
                JSONObject parentObject = new JSONObject(JSONResponse);
                //pasar el objecto de Json a un array
                JSONArray classdetailsArray = parentObject.getJSONArray("classDetails");
                JSONObject classdetails = classdetailsArray.getJSONObject(0);

                nombreCatedratico = classdetails.getString("catedratico");
                noaula = classdetails.getString("aula");
                noedificio = classdetails.getString("edificio");
                codMateria = classdetails.getString("codigoMateria");

                posts = new ArrayList<>();
                JSONArray postsArray = parentObject.getJSONArray("Posts");
                for (int i= 1; i<postsArray.length();i++){
                    JSONObject post = postsArray.getJSONObject(i);
                    posts.add(new postModel(post.getString("postTitle"),
                            post.getString("fecha"),
                            post.getString("commentCount"),
                            post.getString("postID")));
                }

                return "";


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
            teacherName.setText(nombreCatedratico);
            aula.setText(noaula);
            edificio.setText(noedificio);
            codClase.setText(codMateria);

            LinearLayoutManager layoutManager = new LinearLayoutManager(ClassDetail.this,
                    LinearLayoutManager.VERTICAL, false);
            postsHolder.setLayoutManager(layoutManager);
            publicacionClaseAdapter postsAdapter = new publicacionClaseAdapter(posts, context);
            postsHolder.setAdapter(postsAdapter);
            dialog.dismiss();
        }
    }

    class postClassNew extends AsyncTask<String,String,String>{

        @Override
        protected String doInBackground(String... params) {
            HttpURLConnection con = null;
            BufferedReader reader = null;
            BufferedOutputStream os = null;

            try {

                URL url = new URL(params[0]);
                JSONObject jsonObject = new JSONObject();
                jsonObject.put("seccion",params[1]);
                jsonObject.put("catedraticoID",params[2]);
                jsonObject.put("titulo",params[3]);
                jsonObject.put("content",params[4]);
                jsonObject.put("tituloClase",params[5]);
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
                //pasar respuesta a Json object
                String JSONResponse =  buffer.toString();
                JSONObject parentObject = new JSONObject(JSONResponse);

                String success = parentObject.getString("success");

                return success;


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
            if (s.equals("1")) {
                svPostData.setVisibility(View.GONE);
                findViewById(R.id.hr).setVisibility(View.VISIBLE);
                mainInfocontainer.setVisibility(View.VISIBLE);
                postsHolder.setVisibility(View.VISIBLE);
                Toast.makeText(ClassDetail.this, "Publicacion exitosa", Toast.LENGTH_LONG).show();
            }
            else
                Toast.makeText(ClassDetail.this, "Error al publicar",Toast.LENGTH_LONG).show();
        }
    }

    class getScore extends AsyncTask<String, String, String>{

        int [] score = new int[4];

        @Override
        protected String doInBackground(String... params) {
            HttpURLConnection con = null;
            BufferedReader reader = null;
            BufferedOutputStream os = null;
            for(int i = 0; i < 4; i++)
                score[i] = 0;

            try {

                URL url = new URL(params[0]);
                JSONObject jsonObject = new JSONObject();
                jsonObject.put("seccion",params[1]);
                jsonObject.put("userID",params[2]);
                String message = jsonObject.toString();

                con = (HttpURLConnection) url.openConnection();
                con.setDoOutput(true);
                //http headers
                con.setRequestProperty("Content-Type", "application/json;charset=utf-8");
                con.setRequestProperty("X-Requested-With", "XMLHttpRequest");
                //open
                con.connect();
                os = new BufferedOutputStream(con.getOutputStream());
                os.write(message.getBytes());
                //clean up
                os.flush();
                InputStream stream = con.getInputStream();
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
                JSONArray ScoresArray = parentObject.getJSONArray("Scores");

                for (int i = 1; i < ScoresArray.length();i++) {
                    JSONObject scoreData = ScoresArray.getJSONObject(i);
                    if (scoreData.getString("fechaParcial").equals("1"))
                        score[1] = scoreData.getInt("score");
                    if (scoreData.getString("fechaParcial").equals("2"))
                        score[2] = scoreData.getInt("score");
                    if (scoreData.getString("fechaParcial").equals("3"))
                        score[3] = scoreData.getInt("score");
                }

                return "";

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
                score1 = (TextView)findViewById(R.id.score1);
                score2 = (TextView)findViewById(R.id.score2);
                score3 = (TextView)findViewById(R.id.score3);
                scoreTotal = (TextView)findViewById(R.id.totalScore);

                double total = (score[1] + score[2] + score[3]) / 3;

                score1.setText(""+ score[1] + "%");
                score2.setText(""+ score[2] + "%");
                score3.setText(""+ score[3] + "%");
                scoreTotal.setText(""+total+"%");
        }
    }
}
