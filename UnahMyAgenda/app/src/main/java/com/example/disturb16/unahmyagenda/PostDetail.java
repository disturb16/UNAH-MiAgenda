package com.example.disturb16.unahmyagenda;

import android.app.ProgressDialog;
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


public class PostDetail extends ActionBarActivity implements View.OnClickListener {

    private String postContent;
    private List<CommentsClass> comments;
    RecyclerView commentsHolder;
    private Button comentar;
    EditText comentario;
    ProgressDialog progress;
    String userID, postID;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_post_detail);

        setTitle(getIntent().getExtras().getString("titulo"));
        comentario = (EditText)findViewById(R.id.edComment);
        comentar = (Button)findViewById(R.id.btnComment);
        comentar.setOnClickListener(this);
        SharedPreferences userData = getSharedPreferences("user", 0);
        userID = userData.getString("userID", "");
        postID = getIntent().getExtras().getString("postID");

        new getPostContent().execute("http://www.unahmiagenda.site88.net/getPostContent.php", postID);

    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_post_detail, menu);
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
            case R.id.btnComment:

                String comment = comentario.getText().toString();
                progress = ProgressDialog.show(this, "Cargando",
                        "Por favor espera..", true);

                new postComment().execute("http://www.unahmiagenda.site88.net/postComment.php",
                        postID, userID, comment);
                break;

        }
    }


    public class getPostContent extends AsyncTask<String,String,String>{

        HttpURLConnection con = null;
        BufferedReader reader = null;
        BufferedOutputStream os = null;


        @Override
        protected String doInBackground(String... params) {

            try {
                URL url = new URL(params[0]);
                JSONObject jsonObject = new JSONObject();
                jsonObject.put("postID",params[1]);
                String outputData = jsonObject.toString();

                con = (HttpURLConnection) url.openConnection();
                con.setDoOutput(true);

                con.setRequestProperty("Content-Type", "application/json;charset=utf-8");
                con.setRequestProperty("X-Requested-With", "XMLHttpRequest");
                //open
                con.connect();
                os = new BufferedOutputStream(con.getOutputStream());
                os.write(outputData.getBytes());
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
                JSONArray classdetailsArray = parentObject.getJSONArray("PostContent");
                JSONObject classdetails = classdetailsArray.getJSONObject(0);
                postContent = classdetails.getString("content");

                comments = new ArrayList<>();
                JSONArray postsArray = parentObject.getJSONArray("PostComments");
                for (int i= 1; i<postsArray.length();i++){
                    JSONObject comment = postsArray.getJSONObject(i);
                    comments.add(new CommentsClass(comment.getString("nombreUsuario"),
                                             comment.getString("comentario"),
                                             comment.getString("picture")));
                }
                return "";

            } catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (JSONException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }

            return null;
        }

        @Override
        protected void onPostExecute(String s) {
            super.onPostExecute(s);

            TextView post = (TextView)findViewById(R.id.postContent);

            post.setText(postContent);
            commentsHolder = (RecyclerView)findViewById(R.id.comment_list);
            LinearLayoutManager layoutManager = new LinearLayoutManager(PostDetail.this,
                    LinearLayoutManager.VERTICAL, false);
            commentsHolder.setLayoutManager(layoutManager);

            CommentsClassAdapter commentsAdapter = new CommentsClassAdapter(comments, getApplicationContext());
            commentsHolder.setAdapter(commentsAdapter);

        }
    }

    public class postComment extends AsyncTask<String,String,String>{

        HttpURLConnection con = null;
        BufferedReader reader = null;
        BufferedOutputStream os = null;
        String postResult;


        @Override
        protected String doInBackground(String... params) {

            try {
                URL url = new URL(params[0]);
                JSONObject jsonObject = new JSONObject();
                jsonObject.put("postID",params[1]);
                jsonObject.put("userID",params[2]);
                jsonObject.put("comment",params[3]);
                String outputData = jsonObject.toString();

                con = (HttpURLConnection) url.openConnection();
                con.setDoOutput(true);

                con.setRequestProperty("Content-Type", "application/json;charset=utf-8");
                con.setRequestProperty("X-Requested-With", "XMLHttpRequest");
                //open
                con.connect();
                os = new BufferedOutputStream(con.getOutputStream());
                os.write(outputData.getBytes());
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
                postResult = buffer.toString();

                return postResult;



            } catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (JSONException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }

            return null;
        }

        @Override
        protected void onPostExecute(String s) {
            super.onPostExecute(s);
                comentario.setText(s);
                progress.dismiss();
                finish();
                startActivity(getIntent());
        }
    }





}
