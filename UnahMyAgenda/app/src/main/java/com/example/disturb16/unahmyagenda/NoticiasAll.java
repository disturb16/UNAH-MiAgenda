package com.example.disturb16.unahmyagenda;

import android.os.AsyncTask;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.RelativeLayout;

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


public class NoticiasAll extends ActionBarActivity {

    private List<NewsModel> noticias;
    LinearLayoutManager layoutManager;
    RelativeLayout loading;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_noticias_all);

        loading = (RelativeLayout)findViewById(R.id.loading);
        layoutManager = new LinearLayoutManager(this, LinearLayoutManager.VERTICAL, false);

        new getNotis().execute("http://www.unahmiagenda.site88.net/SelectNews.php");
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_noticias_all, menu);
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

    public class getNotis extends AsyncTask<String, String, String> {

        @Override
        protected String doInBackground(String... params) {
            HttpURLConnection con = null;
            BufferedReader reader = null;
            BufferedOutputStream os = null;

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
                String JSONResponse = buffer.toString();
                JSONObject parentObject = new JSONObject(JSONResponse);
                //pasar el objecto de Json a un array
                JSONArray noticias_array = parentObject.getJSONArray("Noticias");

                for (int i = 1; i < noticias_array.length(); i++) {
                    JSONObject JsonNew = noticias_array.getJSONObject(i);
                    noticias.add(new NewsModel(JsonNew.getString("noticiaID"), JsonNew.getString("titulo"), JsonNew.getString("portada")));

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
            if (result != null) {
                RecyclerView notisHolder = (RecyclerView)findViewById(R.id.rv_notis);
                notisHolder.setLayoutManager(layoutManager);
                noticiasAdapter adapterNotis = new noticiasAdapter(noticias, NoticiasAll.this, "allNews");
                notisHolder.setAdapter(adapterNotis);
                if (loading.getVisibility() == View.VISIBLE)
                    loading.setVisibility(View.GONE);
            } else{}
        }

    }

}
