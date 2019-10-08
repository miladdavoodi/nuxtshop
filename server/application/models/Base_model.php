<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Base_model extends CI_Model
{


    function get_headers($function_name = 'getallheaders')
    {

        $all_headers = array();

        if (function_exists($function_name)) {

            $all_headers = $function_name();
        } else {

            foreach ($_SERVER as $name => $value) {

                if (substr($name, 0, 5) == 'HTTP_') {

                    $name = substr($name, 5);
                    $name = str_replace('_', ' ', $name);
                    $name = strtolower($name);
                    $name = ucwords($name);
                    $name = str_replace(' ', '-', $name);

                    $all_headers[$name] = $value;
                } elseif ($function_name == 'apache_request_headers') {

                    $all_headers[$name] = $value;
                }
            }
        }


        return $all_headers;
    }


    public function Json_Output_model($result)
    {

        if ($result['message']) $_result['message'] = $result['message'];

        if (count($result['value']) > 0) {
            foreach ($result['value'] as $keyIndex => $value) {

                $value = ($value === null) ? "" : $value;
                $_result[$keyIndex] = $value;
            }
        }

        if (!in_array(http_response_code(), array(200, 201))) $_result['authorization'] = ($result['authorization']) ? true : false;

        return json_encode($_result, JSON_UNESCAPED_UNICODE);
    }



}

