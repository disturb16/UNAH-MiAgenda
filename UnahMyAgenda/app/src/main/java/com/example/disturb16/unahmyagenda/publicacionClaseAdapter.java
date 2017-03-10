package com.example.disturb16.unahmyagenda;

import android.content.Context;
import android.content.Intent;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.RelativeLayout;
import android.widget.TextView;

import java.util.List;

/**
 * Created by Disturb16 on 18/02/2016.
 */
public class publicacionClaseAdapter extends RecyclerView.Adapter<publicacionClaseAdapter.postHolder>{


    List<postModel> posts;
    Context context;

   publicacionClaseAdapter(List<postModel> posts, Context context){
        this.posts = posts;
       this.context = context;
    }

    @Override
    public postHolder onCreateViewHolder(ViewGroup parent, int viewType) {
            View v = LayoutInflater.from(parent.getContext()).inflate(R.layout.class_posts, parent, false);
            postHolder pvh = new postHolder(v);
            return pvh;
    }

    @Override
    public void onBindViewHolder(postHolder holder, int position) {
        final int pos = position;

        holder.titulo.setText(posts.get(position).titulo);
        holder.fecha.setText(posts.get(position).fecha);
        if (posts.get(position).commentsCount == "1" )
            holder.commentsCount.setText(posts.get(position).commentsCount +" comentario");
        else
            holder.commentsCount.setText(posts.get(position).commentsCount +" comentarios");
        holder.titulo.setSelected(true);
        holder.titulo.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {
                Intent intent = new Intent(context, PostDetail.class);
                intent.putExtra("titulo", posts.get(pos).titulo);
                intent.putExtra("postID", posts.get(pos).postID);
                context.startActivity(intent);
            }
        });

    }

    @Override
    public int getItemCount() {
        return posts.size();
    }

    @Override
    public void onAttachedToRecyclerView(RecyclerView recyclerView) {
        super.onAttachedToRecyclerView(recyclerView);
    }

    public  class postHolder extends RecyclerView.ViewHolder{
        RelativeLayout root;
        TextView titulo, fecha, commentsCount;

        postHolder(View itemView) {
            super(itemView);
            root =  (RelativeLayout)itemView.findViewById(R.id.root);
            titulo = (TextView)itemView.findViewById(R.id.titulo);
            fecha = (TextView)itemView.findViewById(R.id.fecha);
            commentsCount = (TextView)itemView.findViewById(R.id.commentsCount);
        }

        }
    }


