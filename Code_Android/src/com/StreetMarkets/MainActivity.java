package com.StreetMarkets;

import android.os.Bundle;
import android.app.Activity;
import android.app.PendingIntent;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.telephony.SmsManager;
import android.view.Menu;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

public class MainActivity extends Activity {

    private Button btnSendSMS, btnScan;
	private EditText txtPhoneNo, txtMessage, txtQuantity, txtPrice, txtNoOfScans;
	private static String ScanData="";
	

	@Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        
        btnScan = (Button) findViewById(R.id.ScanButton);
        btnSendSMS = (Button) findViewById(R.id.SendButton);   // handlers, not variables that hold value
        txtPhoneNo = (EditText) findViewById(R.id.number);
        txtMessage = (EditText) findViewById(R.id.ScannedData);
        txtQuantity = (EditText) findViewById(R.id.quantity);
        txtPrice = (EditText) findViewById(R.id.price);
        txtNoOfScans = (EditText) findViewById(R.id.scans);
        //ScanData+="0,"+txtNoOfScans.getText().toString()+";";
        //Toast.makeText(getBaseContext(),txtNoOfScans.getText().toString(), 
          //      Toast.LENGTH_SHORT).show();
                            
        btnScan.setOnClickListener(new View.OnClickListener() // invoking scan
        {
            public void onClick(View v) 
            { 
            			Intent intent = new Intent("com.google.zxing.client.android.SCAN");
            			intent.putExtra("SCAN_MODE", "ONE_D_MODE");
            			startActivityForResult(intent, 0);
            			
             }
        });
        
        btnSendSMS.setOnClickListener(new View.OnClickListener()  // sending message
        {
            public void onClick(View v) 
            {                
                String phoneNo = txtPhoneNo.getText().toString();  // extracting data from field handlers
                ScanData = ScanData.substring(0, ScanData.length() - 1);
                ScanData="@search4you 0,"+txtNoOfScans.getText().toString()+";"+ScanData;
                String message = ScanData; 
                Toast.makeText(getBaseContext(),phoneNo+"---"+message, 
                        Toast.LENGTH_SHORT).show();
                if (phoneNo.length()>0 && message.length()>0)
                   {
                	Toast.makeText(getBaseContext(),phoneNo+" "+message, 
                            Toast.LENGTH_SHORT).show(); 
                   
                    sendSMS(phoneNo, message);
                   }
                else
                    Toast.makeText(getBaseContext(),"Please enter both phone number and message.", 
                        Toast.LENGTH_SHORT).show();
            }
        });     
    }
	

	public void onActivityResult(int requestCode, int resultCode, Intent intent) {  // capture result of scan
		   if (requestCode == 0) {
		     if (resultCode == RESULT_OK) {
		        ScanData =ScanData + intent.getStringExtra("SCAN_RESULT");
		        ScanData += ","+txtQuantity.getText().toString()+","+txtPrice.getText().toString()+";";
		        //String format = intent.getStringExtra("SCAN_RESULT_FORMAT");
		        // Handle successful scan
		        Toast.makeText(getBaseContext(),txtQuantity.getText().toString()+" "+txtPrice.getText().toString(),Toast.LENGTH_LONG).show();
		        Toast.makeText(getBaseContext(),ScanData,Toast.LENGTH_LONG).show();
		      } 
		     else if (resultCode == RESULT_CANCELED) {
		         // Handle cancel
		    	 Toast.makeText(getBaseContext(),"Unsuccessfull :(", 
	                        Toast.LENGTH_SHORT).show();
		      }
		   }
		}
		
	
	
    private void sendSMS(String phoneNo, String message)
    {   
    	String SENT = "SMS_SENT";
        String DELIVERED = "SMS_DELIVERED";
 
        PendingIntent sentPI = PendingIntent.getBroadcast(this, 0,
            new Intent(SENT), 0);
 
        PendingIntent deliveredPI = PendingIntent.getBroadcast(this, 0,
            new Intent(DELIVERED), 0);
 
        //---when the SMS has been sent---
        registerReceiver(new BroadcastReceiver(){
            @Override
            public void onReceive(Context arg0, Intent arg1) {
                switch (getResultCode())
                {
                    case Activity.RESULT_OK:
                        Toast.makeText(getBaseContext(), "SMS sent", 
                                Toast.LENGTH_SHORT).show();
                        break;
                    case SmsManager.RESULT_ERROR_GENERIC_FAILURE:
                        Toast.makeText(getBaseContext(), "Generic failure", 
                                Toast.LENGTH_SHORT).show();
                        break;
                    case SmsManager.RESULT_ERROR_NO_SERVICE:
                        Toast.makeText(getBaseContext(), "No service", 
                                Toast.LENGTH_SHORT).show();
                        break;
                    case SmsManager.RESULT_ERROR_NULL_PDU:
                        Toast.makeText(getBaseContext(), "Null PDU", 
                                Toast.LENGTH_SHORT).show();
                        break;
                    case SmsManager.RESULT_ERROR_RADIO_OFF:
                        Toast.makeText(getBaseContext(), "Radio off", 
                                Toast.LENGTH_SHORT).show();
                        break;
                }
            }
        }, new IntentFilter(SENT));
 
        //---when the SMS has been delivered---
        registerReceiver(new BroadcastReceiver(){
            @Override
            public void onReceive(Context arg0, Intent arg1) {
                switch (getResultCode())
                {
                    case Activity.RESULT_OK:
                        Toast.makeText(getBaseContext(), "SMS delivered", 
                                Toast.LENGTH_SHORT).show();
                        break;
                    case Activity.RESULT_CANCELED:
                        Toast.makeText(getBaseContext(), "SMS not delivered", 
                                Toast.LENGTH_SHORT).show();
                        break;                        
                }
            }
        }, new IntentFilter(DELIVERED));        
 
        SmsManager sms = SmsManager.getDefault();
        sms.sendTextMessage(phoneNo, null, message, sentPI, deliveredPI);
    	
    	
    	
        //PendingIntent pi = PendingIntent.getActivity(this, 0,
        //    new Intent(this, MainActivity.class), 0);                
        //SmsManager sms = SmsManager.getDefault();
        //sms.sendTextMessage(phoneNo, null, message, pi, null);        
    }  
    
    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.activity_main, menu);
        return true;
    }
}
