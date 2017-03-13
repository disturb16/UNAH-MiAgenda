package com.example.disturb16.unahmyagenda;

import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.RelativeLayout;
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

public class TabControl extends Fragment {

    private List<NewsModel> noticias;
    private List<CalendarDateModel> fechas;
    private View v;
    String tab;
    RelativeLayout loading;
    boolean isconnected;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
    }


    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        tab = this.getTag();
        isconnected = false;
            if (tab == "tab1") {
                if (v == null) {
                    v = inflater.inflate(R.layout.activity_welcome, container, false);
                    //loading circle
                    loading = (RelativeLayout) v.findViewById(R.id.loading);
                    loading.setVisibility(View.VISIBLE);
                    addNotiAdapter(v);
                    new getNextClass(v).execute("http://unahmiagenda.000webhostapp.com/getSiguienteClase.php");
                }
                return v;
                }

                if (tab == "tab2") {
                    if (v == null) {
                        v = inflater.inflate(R.layout.activity_news_feed, container, false);
                        //loading circle
                        loading = (RelativeLayout) v.findViewById(R.id.loading);
                        loading.setVisibility(View.VISIBLE);
                        getEventAdapter(v);
                    }
                    return v;
                }

                if (tab == "tab3") {
                    if (v == null) {
                        v = inflater.inflate(R.layout.calendario_fechas, container, false);
                        //loading circle
                        loading = (RelativeLayout) v.findViewById(R.id.loading);
                        loading.setVisibility(View.VISIBLE);
                        getFechasAdapter(v);
                    }
                        return v;

                }else
                    return null;
    }


    public void addNotiAdapter(View v) {
        new getNoticias(v).execute("http://unahmiagenda.000webhostapp.com/getNoticias.php");
    }

    private void getEventAdapter(View v) {
        new getEventos(v).execute("http://unahmiagenda.000webhostapp.com/getEventos.php");
    }

    private void getFechasAdapter(View v) {
        new getCronogramaAcademico(v).execute("http://unahmiagenda.000webhostapp.com/getCronogramaAcademico.php");
    }




    public class getNoticias extends AsyncTask<String, String, String> {
        View v;

        public getNoticias(View v) {
            this.v = v;
        }

        @Override
        protected String doInBackground(String... params) {
            HttpURLConnection con = null;
            BufferedReader reader = null;
            BufferedOutputStream os = null;

            try {

                URL url = new URL(params[0]);

                con = (HttpURLConnection) url.openConnection();
                //make some HTTP header nicety
                con.setRequestProperty("Content-Type", "application/json");
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
                    Log.d("titulo", JsonNew.getString("titulo"));

                }
                return "s";


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
            final LinearLayoutManager layoutManager = new LinearLayoutManager(v.getContext());
            if (result != null) {
                RecyclerView notisHolder = (RecyclerView) v.findViewById(R.id.notis_list);
                layoutManager.setOrientation(LinearLayoutManager.HORIZONTAL);
                notisHolder.setLayoutManager(layoutManager);
                noticiasAdapter adapterNotis = new noticiasAdapter(noticias, getActivity(), tab);
                notisHolder.setAdapter(adapterNotis);

                Button btnMore = (Button) v.findViewById(R.id.moreNews);
                btnMore.setOnClickListener(new View.OnClickListener() {

                    @Override
                    public void onClick(View v) {
                        switch (v.getId()){
                            case R.id.moreNews:
                                startActivity(new Intent(getActivity(), NoticiasAll.class));
                                break;
                        }
                    }
                });
                if (loading.getVisibility() == View.VISIBLE)
                    loading.setVisibility(View.GONE);
            } else{}
        }

    }

    public class getEventos extends AsyncTask<String, String, String> {
        View v;

        public getEventos(View v) {
            this.v = v;
        }

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
                JSONArray noticias_array = parentObject.getJSONArray("Eventos");

                for (int i = 1; i < noticias_array.length(); i++) {
                    JSONObject JsonNew = noticias_array.getJSONObject(i);
                    noticias.add(new NewsModel(JsonNew.getString("eventoID"), JsonNew.getString("titulo"), JsonNew.getString("portada")));
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
            final LinearLayoutManager layoutManager = new LinearLayoutManager(v.getContext());
            if (result != null){
                RecyclerView notisHolder = (RecyclerView) v.findViewById(R.id.notis_list);
                layoutManager.setOrientation(LinearLayoutManager.VERTICAL);
                notisHolder.setLayoutManager(layoutManager);
                noticiasAdapter adapterNotis = new noticiasAdapter(noticias, getActivity(), tab);
                notisHolder.setAdapter(adapterNotis);
                if (loading.getVisibility() == View.VISIBLE)
                    loading.setVisibility(View.GONE);
            }else
                Toast.makeText(getActivity(), "Check Connection", Toast.LENGTH_LONG).show();

        }

    }

    public class getCronogramaAcademico extends AsyncTask<String, String, String> {
        View v;

        public getCronogramaAcademico(View v) {
            this.v = v;
        }

        @Override
        protected String doInBackground(String... params) {
            HttpURLConnection con = null;
            BufferedReader reader = null;

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
                fechas = new ArrayList<>();
                //pasar respuesta a Json object
                String JSONResponse = buffer.toString();
                JSONObject parentObject = new JSONObject(JSONResponse);
                //pasar el objecto de Json a un array
                JSONArray cronogramaArray = parentObject.getJSONArray("Fechas");

                for (int i = 1; i < cronogramaArray.length(); i++) {
                    JSONObject JsonNew = cronogramaArray.getJSONObject(i);
                    fechas.add(new CalendarDateModel(JsonNew.getString("fechaID"),
                            JsonNew.getString("titulo"),
                            JsonNew.getString("tipoFechaCalendario"),
                            JsonNew.getString("fecha"),
                            JsonNew.getString("descripcion")));
                }
                return "s";


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
                } catch (IOException e) {
                    e.printStackTrace();
                }
            }
            return null;
        }

        @Override
        protected void onPostExecute(String s) {
            super.onPostExecute(s);
            final LinearLayoutManager layoutManager = new LinearLayoutManager(v.getContext());
            if (s != null){
                RecyclerView fechasHolder = (RecyclerView) v.findViewById(R.id.fechas_list);
                layoutManager.setOrientation(LinearLayoutManager.VERTICAL);
                fechasHolder.setLayoutManager(layoutManager);
                CronogramaAcademicoAdapter adapterFechas = new CronogramaAcademicoAdapter(fechas, getActivity());
                fechasHolder.setAdapter(adapterFechas);
                if (loading.getVisibility() == View.VISIBLE)
                    loading.setVisibility(View.GONE);
            }else
                Toast.makeText(getActivity(), "Check Connection", Toast.LENGTH_LONG).show();
        }
    }

    public class getNextClass extends AsyncTask<String, String, String> implements View.OnClickListener {
        View v;
        String tituloClase, hora, seccion;

        public getNextClass(View v) {
            this.v = v;
        }

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
                //pasar respuesta a Json object
                String JSONResponse = buffer.toString();
                JSONObject parentObject = new JSONObject(JSONResponse);
                tituloClase = parentObject.getString("titulo");
                hora = parentObject.getString("hora");
                seccion = parentObject.getString("seccion");

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
                        /*if (os != null)
                            os.close();*/
                } catch (IOException e) {
                    e.printStackTrace();
                }
            }
            return null;
        }

        @Override
        protected void onPostExecute(String result) {
            super.onPostExecute(result);
            TextView horac, clase;
            RelativeLayout nextClass = (RelativeLayout) v.findViewById(R.id.nextClassView);
            horac = (TextView) v.findViewById(R.id.hora);
            clase = (TextView) v.findViewById(R.id.clase);
            horac.setText(hora + ":00");
            clase.setText(tituloClase);

            nextClass.setOnClickListener(this);
            if (loading.getVisibility() == View.VISIBLE)
                loading.setVisibility(View.GONE);
        }

        @Override
        public void onClick(View v) {
            if ((v.getId() == R.id.nextClassView) || (v.getId() == R.id.clase)) {
                Intent intent = new Intent(getActivity(), ClassDetail.class);
                intent.putExtra("tituloClase", tituloClase);
                intent.putExtra("seccion", seccion);
                startActivity(intent);
            }
        }
    }
}