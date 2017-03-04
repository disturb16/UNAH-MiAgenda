package com.example.disturb16.unahmyagenda;

import android.content.Context;
import android.content.Intent;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.RelativeLayout;
import android.widget.TextView;

import com.squareup.picasso.Picasso;

import java.util.List;

/**
 * Created by Disturb16 on 18/02/2016.
 */
public class NewsAdapter extends RecyclerView.Adapter<NewsAdapter.NotiViewHolder>{


    List<NewsModel> noticias;
    Context context;
    String tab;

    NewsAdapter(List<NewsModel> noticia, Context context, String tab){
        this.noticias = noticia;
        this.context = context;
        this.tab = tab;
    }

    @Override
    public NotiViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        if (tab == "tab1"){
            View v = LayoutInflater.from(parent.getContext()).inflate(R.layout.noticia, parent, false);
            final NotiViewHolder holder = new NotiViewHolder(v);

            return holder;
        }
        if (tab == "tab2" || tab == "allNews"){
            View v = LayoutInflater.from(parent.getContext()).inflate(R.layout.noticia_feeds, parent, false);
            NotiViewHolder holder = new NotiViewHolder(v);
            return holder;
        }
        else
            return null;
    }

    @Override
    public void onBindViewHolder(final NotiViewHolder holder, int position) {
        if (tab == "tab1") {
            holder.titulo.setText(noticias.get(position).titulo);
            Picasso.with(context)
                    .load(noticias.get(position).photoID)
                    .resize(320,170)
                    .centerCrop()
                    .into(holder.notiPhoto);
            holder._position = position;


        }
        if (tab == "tab2" || tab == "allNews"){
            holder.titulo.setText(noticias.get(position).titulo);
            Picasso.with(context)
                    .load(noticias.get(position).photoID)
                    .resize(350, 170)
                    .centerCrop()
                    .into(holder.notiPhoto);
        }
    }

    @Override
    public int getItemCount() {
        return noticias.size();
    }

    @Override
    public void onAttachedToRecyclerView(RecyclerView recyclerView) {
        super.onAttachedToRecyclerView(recyclerView);
    }

    public class NotiViewHolder extends RecyclerView.ViewHolder{
        public int _position;
        RelativeLayout root;
        TextView titulo;
        ImageView notiPhoto;

        public NotiViewHolder(View itemView) {
            super(itemView);
            root = (RelativeLayout)itemView.findViewById(R.id.root);
            titulo = (TextView)itemView.findViewById(R.id.titulo);
            notiPhoto = (ImageView)itemView.findViewById(R.id.noti_photo);

            root.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    if(tab == "tab1" || tab == "allNews"){
                        Intent intent = new Intent(context, NewDetail.class);
                        intent.putExtra("noticiaID", noticias.get(getPosition()).noticiaID);
                        intent.putExtra("titulo", noticias.get(getPosition()).titulo);
                        context.startActivity(intent);
                    }
                    if(tab == "tab2"){
                        Intent intent = new Intent(context, EventDetail.class);
                        intent.putExtra("eventoID", noticias.get(getPosition()).noticiaID);
                        intent.putExtra("titulo", noticias.get(getPosition()).titulo);
                        context.startActivity(intent);
                    }
                }
            });
        }


    }
}
