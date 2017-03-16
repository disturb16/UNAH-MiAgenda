package com.example.disturb16.unahmyagenda;

import android.content.Intent;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.RadioButton;


public class CategoriaTicket extends ActionBarActivity implements View.OnClickListener {

    Button btnContinue;
    RadioButton newSeccion;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_create_ticket);

        btnContinue = (Button)findViewById(R.id.btnTicketNext);
        btnContinue.setOnClickListener(this);

        //RadioButtons
        newSeccion = (RadioButton)findViewById(R.id.newSeccion);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_create_ticket, menu);
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
        switch(v.getId()){
            case R.id.btnTicketNext:
                if (newSeccion.isChecked()){
                    startActivity(new Intent(this,SolicitudSeccion.class));
                }

                break;
        }
    }
}
