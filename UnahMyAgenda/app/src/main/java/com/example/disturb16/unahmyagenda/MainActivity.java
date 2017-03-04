package com.example.disturb16.unahmyagenda;


import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.res.Resources;
import android.graphics.Color;

import android.os.AsyncTask;
import android.support.annotation.Nullable;
import android.support.v4.app.FragmentTabHost;
import android.support.v4.widget.DrawerLayout;
import android.os.Bundle;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TabHost;
import android.widget.TextView;

import com.squareup.picasso.Picasso;

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

public class MainActivity extends AppCompatActivity implements TabHost.OnTabChangeListener, View.OnClickListener {

    private FragmentTabHost mTabHost;
    private ActionBarDrawerToggle actionBarDrawerToggle;
    private DrawerLayout drawerLayout;
    private LinearLayout navList, perfil, clases, tickets, configuracion, logOut;
    private TextView profileIcon, clasesIcon, ticketIcon, helpIcon, logOutIcon;

    Resources res;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        //Validar user
        SharedPreferences userData = getSharedPreferences("user", 0);

        if (userData.getString("Name","default") == "default"){
            startActivity(new Intent(this, Login.class));
            finish();
        }



        res = getResources();

        //load user Data
        String userID = userData.getString("userID","default");

        //loadIcons
        profileIcon = (TextView)findViewById(R.id.userProfileIcon);
        profileIcon.setTypeface(FontManager.getTypeface( getApplicationContext(),FontManager.FONTAWESOME));
        clasesIcon = (TextView)findViewById(R.id.clasesIcon);
        clasesIcon.setTypeface(FontManager.getTypeface( getApplicationContext(),FontManager.FONTAWESOME));
        ticketIcon = (TextView)findViewById(R.id.ticketIcon);
        ticketIcon.setTypeface(FontManager.getTypeface( getApplicationContext(),FontManager.FONTAWESOME));
        helpIcon = (TextView)findViewById(R.id.helpIcon);
        helpIcon.setTypeface(FontManager.getTypeface( getApplicationContext(),FontManager.FONTAWESOME));
        logOutIcon = (TextView)findViewById(R.id.logOutIcon);
        logOutIcon.setTypeface(FontManager.getTypeface( getApplicationContext(),FontManager.FONTAWESOME));

        //Menu de opciones
        navList = (LinearLayout) findViewById(R.id.mainMenu);

        perfil = (LinearLayout)findViewById(R.id.perfil);
        clases = (LinearLayout)findViewById(R.id.clases);
        tickets = (LinearLayout)findViewById(R.id.tickets);
        configuracion = (LinearLayout)findViewById(R.id.help);
        logOut = (LinearLayout)findViewById(R.id.logOut);
        perfil.setOnClickListener(this);
        clases.setOnClickListener(this);
        tickets.setOnClickListener(this);
        configuracion.setOnClickListener(this);
        logOut.setOnClickListener(this);

        drawerLayout = (DrawerLayout)findViewById(R.id.drawerLayout);
        actionBarDrawerToggle = new ActionBarDrawerToggle(this,drawerLayout,R.string.openDrawer,R.string.closeDrawer);
        drawerLayout.setDrawerListener(actionBarDrawerToggle);
        android.support.v7.app.ActionBar actionBar = getSupportActionBar();
        actionBar.setDisplayShowHomeEnabled(true);
        actionBar.setDisplayHomeAsUpEnabled(true);

        //tab layout
        mTabHost = (FragmentTabHost) findViewById(android.R.id.tabhost);
        mTabHost.setup(this, getSupportFragmentManager(), android.R.id.tabcontent);
        mTabHost.addTab(mTabHost.newTabSpec("tab1")
                .setIndicator("", res.getDrawable(R.drawable.icon_home)), TabControl.class, null);
        mTabHost.addTab(mTabHost.newTabSpec("tab2").setIndicator("", res.getDrawable(R.drawable.events_icon)), TabControl.class, null);
        mTabHost.addTab(mTabHost.newTabSpec("tab3").setIndicator("",res.getDrawable(R.drawable.calendario_periodo_icon)), TabControl.class, null);

        for(int i=0; i< mTabHost.getTabWidget().getChildCount();i++)
        {
            mTabHost.getTabWidget().getChildAt(i).setBackgroundColor(Color.parseColor("#1f3c4d"));
        }
        mTabHost.getTabWidget().setCurrentTab(0);
        mTabHost.getTabWidget().getChildAt(0).setBackgroundColor(Color.parseColor("#2a536b"));

        mTabHost.setOnTabChangedListener(this);

    }

    @Override
    protected void onPostCreate(@Nullable Bundle savedInstanceState) {
        super.onPostCreate(savedInstanceState);
        actionBarDrawerToggle.syncState();
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {

            case android.R.id.home:
               if ( drawerLayout.isDrawerOpen(navList) ){
                    drawerLayout.closeDrawer(navList);
                }else
                    drawerLayout.openDrawer(navList);
               break;
            default:
        }
        return super.onOptionsItemSelected(item);
    } //options Selected (drawLayout close and open)

    @Override
    public void onTabChanged(String tabId) {
        for(int i=0;i < mTabHost.getTabWidget().getChildCount();i++)
        {
            mTabHost.getTabWidget().getChildAt(i).setBackgroundColor(Color.parseColor("#1f3c4d"));
        }

        mTabHost.getTabWidget().getChildAt(mTabHost.getCurrentTab()).setBackgroundColor(Color.parseColor("#2a536b"));
    }//tabChange

    @Override
    public void onClick(View v) {
        switch ( v.getId() ){
            case R.id.perfil:
                startActivity(new Intent(this, Profile.class));
                drawerLayout.closeDrawer(navList);
                break;

            case R.id.clases:
                startActivity(new Intent(this, Classes.class));
                drawerLayout.closeDrawer(navList);
                break;

            case R.id.tickets:
                startActivity(new Intent(this, CreateTicket.class));
                drawerLayout.closeDrawer(navList);
                break;

            case R.id.help:
                startActivity(new Intent(this, HelpDocumentation.class));
                break;

            case R.id.logOut:
                SharedPreferences userData = getSharedPreferences("user",0);
                SharedPreferences.Editor editUser = userData.edit();
                editUser.clear();
                editUser.apply();
                finish();
                break;
        }
    }//onClick

    public class getUserData extends AsyncTask<String,String, String > {
        Context context;
        String name, pictureUrl;
        String edad;

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
                name = parentObject.getString("name");
                pictureUrl = parentObject.getString("picture");
                edad = parentObject.getString("edad");

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
            ImageView perfilFoto = (ImageView)findViewById(R.id.main_menu_photo);
            Picasso.with(context)
                    .load(pictureUrl)
                    .resize(200,130)
                    .into(perfilFoto);
        }

    }//getUserInfo
}
