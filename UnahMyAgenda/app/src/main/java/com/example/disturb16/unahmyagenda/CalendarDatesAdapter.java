package com.example.disturb16.unahmyagenda;
import android.content.Context;
import android.support.v7.widget.CardView;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.RelativeLayout;
import android.widget.TextView;

import java.util.List;



/**
 * Created by Disturb16 on 02/04/2016.
 */
public class CalendarDatesAdapter extends RecyclerView.Adapter<CalendarDatesAdapter.fechaHolder>{


    List<CalendarDateModel> fechas;
    Context context;


    CalendarDatesAdapter(List<CalendarDateModel> fechas, Context context){
        this.fechas = fechas;
        this.context = context;
    }

    @Override
    public fechaHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View v = LayoutInflater.from(parent.getContext()).inflate(R.layout.fecha_detail, parent, false);
        fechaHolder pvh = new fechaHolder(v);
        return pvh;

    }

    @Override
    public void onBindViewHolder(final fechaHolder holder, int position) {
        final int pos = position;

        holder.fecha.setText(fechas.get(position).fecha);
        holder.tituloFecha.setText(fechas.get(position).titulo);
        holder.tipoFecha.setText(fechas.get(position).tipoFecha);
        holder.descripcion.setText(fechas.get(position).descripcion);


    }

    @Override
    public int getItemCount() {
        return fechas.size();
    }

    @Override
    public void onAttachedToRecyclerView(RecyclerView recyclerView) {
        super.onAttachedToRecyclerView(recyclerView);
    }

    public  class fechaHolder extends RecyclerView.ViewHolder{
        RelativeLayout root ;
        CardView cv;
        TextView tituloFecha, tipoFecha, descripcion;
        TextView fecha;

        fechaHolder(View itemView) {
            super(itemView);
            root =  (RelativeLayout)itemView.findViewById(R.id.root);
            cv = (CardView)itemView.findViewById(R.id.scoresContainer);
            fecha = (TextView) itemView.findViewById(R.id.fecha);
            tipoFecha = (TextView) itemView.findViewById(R.id.tipoFecha);
            descripcion = (TextView) itemView.findViewById(R.id.descripcion);
            tituloFecha = (TextView)itemView.findViewById(R.id.tituloFecha);
        }
    }
}

