package com.example.disturb16.unahmyagenda;

import android.support.v7.widget.CardView;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;


/**
 * Created by Disturb16 on 21/02/2016.
 */


public class NextClassAdapter extends RecyclerView.Adapter<NextClassAdapter.classViewHolder>{

    @Override
    public classViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {

        View v = LayoutInflater.from(parent.getContext()).inflate(R.layout.next_class_info, parent, false);
        classViewHolder cvh = new classViewHolder(v);
        return cvh;
    }


    @Override
    public void onBindViewHolder(classViewHolder holder, int position) {
        holder.tituloClase.setText("Proxima clase");
        holder.clase.setText("Lenguaje de Programacion II");
        holder.hora.setText("16:00");
    }

    @Override
    public int getItemCount() {
        return 0;
    }

    @Override
    public void onAttachedToRecyclerView(RecyclerView recyclerView) {
        super.onAttachedToRecyclerView(recyclerView);
    }

    public  class classViewHolder extends RecyclerView.ViewHolder{
        CardView cv;
        TextView tituloClase, clase, hora;

        classViewHolder(View itemView) {
            super(itemView);
            cv = (CardView)itemView.findViewById(R.id.scoresContainer);
            tituloClase = (TextView)itemView.findViewById(R.id.tituloClase);
            clase = (TextView)itemView.findViewById(R.id.clase);
            hora = (TextView)itemView.findViewById(R.id.hora);
        }

    }
}