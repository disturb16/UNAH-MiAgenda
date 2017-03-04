package com.example.disturb16.unahmyagenda;

import android.content.Context;
import android.support.v7.widget.CardView;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import java.util.List;


import android.widget.ImageView;

import com.squareup.picasso.Picasso;

/**
 * Created by Disturb16 on 18/02/2016.
 */
public class CommentsClassAdapter extends RecyclerView.Adapter<CommentsClassAdapter.CommenttHolder>{

    List<CommentsClass> comments;
    Context context;

    CommentsClassAdapter(List<CommentsClass> _comment, Context _context){
        comments = _comment;
        context = _context;
    }

    @Override
    public CommenttHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View v = LayoutInflater.from(parent.getContext()).inflate(R.layout.comment, parent, false);
        CommenttHolder pvh = new CommenttHolder(v);
        return pvh;

    }

    @Override
    public void onBindViewHolder(CommenttHolder holder, int position) {
        holder.content.setText(comments.get(position).comment);
        holder.userName.setText(comments.get(position).userName);
        Picasso.with(context)
                .load(comments.get(position).profileImg)
                .resize(50, 50)
                .into(holder.commentUserImg);
    }

    @Override
    public int getItemCount() {
        return comments.size();
    }

    @Override
    public void onAttachedToRecyclerView(RecyclerView recyclerView) {
        super.onAttachedToRecyclerView(recyclerView);
    }

    public  class CommenttHolder extends RecyclerView.ViewHolder{
        CardView cv;
        TextView content, userName;
        ImageView commentUserImg;

        CommenttHolder(View itemView) {
            super(itemView);
            content = (TextView)itemView.findViewById(R.id.content);
            userName = (TextView)itemView.findViewById(R.id.user);
            commentUserImg = (ImageView) itemView.findViewById(R.id.commentUserImg);
        }

    }
}



