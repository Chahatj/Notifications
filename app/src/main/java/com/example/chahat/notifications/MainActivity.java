package com.example.chahat.notifications;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonArrayRequest;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.firebase.iid.FirebaseInstanceId;

import org.json.JSONArray;
import org.json.JSONException;

import java.util.HashMap;
import java.util.Map;

public class MainActivity extends AppCompatActivity {

    String SERVER_ADDRESS = "https://notificationsimplement.000webhostapp.com/notification.php?token=";


    EditText et_title,et_notification;
    Button bt_sendNotification;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        et_title = (EditText) findViewById(R.id.et_title);
        et_notification = (EditText) findViewById(R.id.et_notification);
        bt_sendNotification = (Button) findViewById(R.id.bt_sendNotification);

        final String token = FirebaseInstanceId.getInstance().getToken();

        bt_sendNotification.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if (et_title.getText().toString().trim().isEmpty()||et_notification.getText().toString().trim().isEmpty()){
                    Toast.makeText(getApplicationContext(),"Enter title and text",Toast.LENGTH_SHORT);
                }else {
                    String title = et_title.getText().toString();
                    String notification = et_notification.getText().toString();
                    sendNotificationToappServer(token,title,notification);
                }
            }
        });

    }

    public void sendNotificationToappServer(final String token,final String title, final String notification){
        StringRequest stringRequest = new StringRequest(Request.Method.POST,SERVER_ADDRESS+token,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                       /* Toast.makeText(MainActivity.this,response,Toast.LENGTH_LONG).show();*/
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(MainActivity.this,error.toString(),Toast.LENGTH_LONG).show();
                    }
                }){
            @Override
            protected Map<String,String> getParams(){
                Map<String,String> params = new HashMap<String, String>();
                params.put("title",title);
                params.put("message",notification);
                return params;
            }

        };

        RequestQueue requestQueue = Volley.newRequestQueue(this);
        requestQueue.add(stringRequest);
    }


}

