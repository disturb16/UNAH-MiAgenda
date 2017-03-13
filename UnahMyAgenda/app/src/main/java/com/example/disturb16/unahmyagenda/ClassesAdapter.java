package com.example.disturb16.unahmyagenda;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.support.v7.widget.CardView;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.google.firebase.messaging.FirebaseMessaging;

import java.util.List;



/**
 * Created by Disturb16 on 18/02/2016.
 */
public class ClassesAdapter extends RecyclerView.Adapter<ClassesAdapter.materiaHolder>{


    List<ClassModel> materias;
    Context context;


    ClassesAdapter(List<ClassModel> materias, Context context){
        this.materias = materias;
        this.context = context;
    }

    @Override
    public materiaHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View v = LayoutInflater.from(parent.getContext()).inflate(R.layout.forma03_layout, parent, false);
        materiaHolder pvh = new materiaHolder(v);
        return pvh;

    }

    @Override
    public void onBindViewHolder(final materiaHolder holder, int position) {
        final int pos = position;

        holder.hora.setText(materias.get(position).horaInicio);
        holder.tituloClaseMateria.setText(materias.get(position).nombreMateria);


        SharedPreferences seccionesForTopics = context.getSharedPreferences("seccionesForTopics", 0);
        if ( seccionesForTopics.getString(materias.get(position).seccion, "default") == "default" ){
            SharedPreferences.Editor seccionesEdit =  seccionesForTopics.edit();
            seccionesEdit.putString(materias.get(position).seccion, materias.get(position).seccion);
            FirebaseMessaging.getInstance().subscribeToTopic(materias.get(position).seccion);
            seccionesEdit.commit();
        }


    }

    @Override
    public int getItemCount() {
        return materias.size();
    }

    @Override
    public void onAttachedToRecyclerView(RecyclerView recyclerView) {
        super.onAttachedToRecyclerView(recyclerView);
    }

    public  class materiaHolder extends RecyclerView.ViewHolder{
        LinearLayout classLink ;
        CardView cv;
        TextView tituloClaseMateria;
        TextView hora;

        materiaHolder(View itemView) {
            super(itemView);
            classLink =  (LinearLayout) itemView.findViewById(R.id.classLink);
            cv = (CardView)itemView.findViewById(R.id.scoresContainer);
            hora = (TextView) itemView.findViewById(R.id.hora);
            tituloClaseMateria = (TextView)itemView.findViewById(R.id.tituloClaseMateria);



            classLink.setOnClickListener(new View.OnClickListener() {

                @Override
                public void onClick(View v) {
                    Intent intent = new Intent(context, DetalleClase.class);
                    intent.putExtra("tituloClase", materias.get(getPosition()).nombreMateria);
                    intent.putExtra("seccion", materias.get(getPosition()).seccion);
                    context.startActivity(intent);
                }
            });
        }
    }
}
