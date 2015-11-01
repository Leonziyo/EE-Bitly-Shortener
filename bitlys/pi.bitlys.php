<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Google Sitemap Lite
 *
 * @package		Bitlys
 * @category	Modules
 * @author		Leonso Medina
 * @link        
 * @copyright 	
 */

$plugin_info = array(
	'pi_name'        => 'Bitlys',
	'pi_version'     => '1.0',
	'pi_author'      => 'Leonso Medina',
	'pi_author_url'  => '',
	'pi_description' => 'Transforms URL to bitly short form through bitly API',
	'pi_usage'       => Bitlys::usage()
  );


class Bitlys
{
    private $access_token = '';
	
	/**
	 * Constructor
	 * 
	 * @return unknown_type
	 */
	public function __construct()
	{								
	}        
    
    function transform() {
        
        $originalURL = ee()->TMPL->fetch_param('url');
        
        //if not URL provided in tag then return empty string
        if(!$originalURL) {
            return '';   
        }
        
        // Specify the URL for the POST Data to go to
        $url = "https://api-ssl.bitly.com/v3/shorten?access_token=". $this->access_token ."&longUrl=". urlencode($originalURL);

        // Initiate cURL (this must be compiled on the server)
        $ch = curl_init();

        // Set the URL
        curl_setopt($ch, CURLOPT_URL, $url);

        //curl_setopt($ch, CURLOPT_HEADER, true); // Display headers
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        $content = curl_exec ($ch);
        curl_close ($ch);
        
        //if failure then just return original URL
        if(!$content) {
            return $originalURL;
        }
        
        $result = json_decode($content);
        
        if($result == NULL || $result->status_code !== 200) {
            return $originalURL;
        }                
        
        return $result->data->url;
    }        
       
    static function usage()
    {
        ob_start(); 
        ?>
            INSTALLATION

            All you need to do to set it up is to edit this file:

            bitlys/pi.bitlys.php

            look for $access_token and set it to your bitly access token.
            
            You can obtain your bitly access token by going to this page and type in your bitly password:
            
            https://bitly.com/a/oauth_apps

            After that just move the bitlys directory into the thrid_party directory in your 
            Expression engine installation.

            -----------------------------------------------------

            USAGE
            
            Just pass a URL parameter to the template like shown below and it
            will return the bitly shortened version.

            {exp:bitlys:transform url="http://example.com"}

        <?php
        $buffer = ob_get_contents();

        ob_end_clean(); 

        return $buffer;
    }
    // END

}
/* End of file pi.bitlys.php */ 
/* Location: ./system/expressionengine/third_party/bitlys/pi.bitlys.php */ 