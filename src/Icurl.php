<?php 
namespace Mostafiz\Icurl;

class Icurl{
    private $ch;

    function __construct($url = null)
    {
        $this->ch = curl_init();
        
        if ($this->ch === false) {
          die("Curl handler initialize failed");
        }

        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);
    }

    function url($url)
    {
        curl_setopt($this->ch, CURLOPT_URL, $url);
        return $this;
    }

    function proxy($proxies = array())
    {
        $proxy = $proxies[ array_rand($proxies)]; 

        preg_match('/^(\d[\d.]+):(\d+)\b/', $proxy, $matches);

        if(count($matches))
        {
            $proxy = explode(':', $proxy);
            $ip = $proxy[0];
            $port = $proxy[1];
            curl_setopt($this->ch, CURLOPT_PROXY, $ip); 
            curl_setopt($this->ch, CURLOPT_PROXYPORT, $port);
            // curl_setopt($this->ch, CURLOPT_HTTPPROXYTUNNEL , 1);
        } 
        else 
        {
            die("Please give a array of valid proxies like [ '120.10.1.123:12345', '000.12.20.122:80' ]");
        }
        
        // curl_setopt($this->ch, CURLOPT_USERAGENT,"Mozilla/5.0 (Linux; U; Android 2.1-update1; ru-ru; GT-I9000 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17");

        return $this;
    }

    function auth($username, $password)
    {
        curl_setopt($this->ch, CURLOPT_PROXYUSERPWD, "$username:$password");
        return $this;
    }

    function get()
    {
        $exc = curl_exec($this->ch);
        
        if ($exc === false) {
            
          die(curl_error($this->ch));
        }
        
        
        return $exc;
    }

    function __destruct()
    {
        curl_close($this->ch); 
    }

}