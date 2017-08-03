import java.io.IOException;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Iterator;
import java.util.List;
import java.util.Map;
import java.util.Map.Entry;
import org.apache.http.HttpEntity;
import org.apache.http.NameValuePair;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.util.EntityUtils;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.methods.CloseableHttpResponse;
import org.apache.http.impl.client.CloseableHttpClient;
import org.apache.http.impl.client.HttpClients;

public class httppost2 {

	public static void main(String[] args) throws ClientProtocolException, IOException {
		String url = "http://api.pigai.org/oauth2/access_token";
		String appkey = "Your_App_Key";
		String secret = "Your_App_Secret";

		Map<String, String> params = new HashMap<String, String>();
		params.put("grant_type", "client_credentials");
		params.put("client_id", appkey);
		params.put("client_secret", secret);

		String cont = doPost(url, params, "utf-8");
		System.out.println(cont);
	}

    static public String doPost(String url,Map<String,String> map,String charset){
        HttpPost httpPost = null;
        String result = null;
        try{
    		CloseableHttpClient httpclient = HttpClients.createDefault();
            httpPost = new HttpPost(url);
            //…Ë÷√≤Œ ˝
            List<NameValuePair> list = new ArrayList<NameValuePair>();
            Iterator iterator = map.entrySet().iterator();
            while(iterator.hasNext()){
                Entry<String,String> elem = (Entry<String, String>) iterator.next();
                list.add(new BasicNameValuePair(elem.getKey(),elem.getValue()));
            }
            if(list.size() > 0){
                UrlEncodedFormEntity entity = new UrlEncodedFormEntity(list,charset);
                httpPost.setEntity(entity);
            }
    		CloseableHttpResponse response = httpclient.execute(httpPost);
            if(response != null){
                HttpEntity resEntity = response.getEntity();
                if(resEntity != null){
                    result = EntityUtils.toString(resEntity,charset);
                }
            }
        }catch(Exception ex){
            ex.printStackTrace();
        }
        return result;
    }
}
