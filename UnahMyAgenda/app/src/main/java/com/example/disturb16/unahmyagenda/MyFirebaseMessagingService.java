package com.example.disturb16.unahmyagenda;

import android.app.NotificationManager;
import android.app.PendingIntent;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.media.RingtoneManager;
import android.net.Uri;
import android.support.v4.app.NotificationCompat;
import android.util.Log;

import com.google.firebase.messaging.FirebaseMessagingService;
import com.google.firebase.messaging.RemoteMessage;

/**
 * Created by Disturb16 on 16/08/2016.
 */
public class MyFirebaseMessagingService extends FirebaseMessagingService {


    private static final String TAG = "FCM Service";
    @Override
    public void onMessageReceived(RemoteMessage remoteMessage) {
        // TODO: Handle FCM messages here.
        // If the application is in the foreground handle both data and notification messages here.
        // Also if you intend on generating your own notifications as a result of a received FCM
        // message, here is where that should be initiated.
        Log.d(TAG, "From: " + remoteMessage.getFrom());
        Log.d(TAG, "Notification Message Body: " + remoteMessage.getNotification().getBody());
        SharedPreferences userData = getSharedPreferences("user", 0);
        //if ( userData.getString("userType", "").equals("2") ){
        sendNotification(
                remoteMessage.getData().get("tituloClase").toString(),
                remoteMessage.getData().get("seccion").toString(),
                remoteMessage.getNotification().getBody());
        //}
    }

    private void sendNotification( String tituloClase, String seccion, String messageBody) {

        Intent intent = new Intent(this, ClassDetail.class);
        intent.putExtra("titulo", tituloClase);
        intent.putExtra("seccion", seccion);
        PendingIntent pendingIntent =  PendingIntent.getActivity( this, 0, intent, PendingIntent.FLAG_UPDATE_CURRENT);

        Uri defaultSoundUri= RingtoneManager.getDefaultUri(RingtoneManager.TYPE_NOTIFICATION);
        NotificationCompat.Builder notificationBuilder = new NotificationCompat.Builder(this)
                .setSmallIcon(R.mipmap.ic_launcher)
                .setContentTitle(tituloClase)
                .setContentText(messageBody)
                .setAutoCancel(true)
                .setSound(defaultSoundUri)
                .setContentIntent(pendingIntent);

        NotificationManager notificationManager =
                (NotificationManager) getSystemService(Context.NOTIFICATION_SERVICE);

        notificationManager.notify(0, notificationBuilder.build());
    }

}
