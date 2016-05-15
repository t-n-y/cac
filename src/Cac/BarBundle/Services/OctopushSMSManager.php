<?php

namespace Cac\BarBundle\Services;

use Cac\BarBundle\Lib\Octopush\SMS;

class OctopushSMSManager
{
    // Octopush Globals as const
    const SMS_STANDARD = 'XXX';
    const SMS_WORLD = 'WWW';
    const SMS_PREMIUM = 'FR';
    const INSTANTANE = 1;
    const DIFFERE = 2;
    const SIMULATION = 'simu';
    const REEL = 'real';

    public $user_login; // string
    public $api_key;   // string
    public $sms_text; // string
    public $sms_recipients;  // array
    public $recipients_first_names;  // array
    public $recipients_last_names;  // array
    public $sms_fields_1;  // array
    public $sms_fields_2;  // array
    public $sms_fields_3;  // array
    public $sms_mode;  // int (instantanous or deffered)
    public $sms_type;  // int (standard or pro)
    public $sending_date;  // int
    public $sms_sender;   // string
    public $request_mode;   // string
    public $request_id;   // string
    public $sms_ticket;   // string
    public $with_replies; // int
    public $transactional; // int
    public $msisdn_sender; // int
    public $request_keys; // int

    // SMS parts
    public $user_batch_id; // string
    public $finished; // int
    public $action; // string

    protected $config;

    public function __construct($config)
    {
        $this->config = $config;

        $this->user_login	 = $this->config['user_login'];
        $this->api_key		 = $this->config['api_key'];
        $this->sms_text = '';
        $this->sms_recipients			 = array();
        $this->recipients_first_names	 = array();
        $this->recipients_last_names	 = array();
        $this->sms_fields_1				 = array();
        $this->sms_fields_2				 = array();
        $this->sms_fields_3				 = array();
        $this->sms_mode		 = self::INSTANTANE;
        $this->sending_date	 = time();
        $this->sms_d		 = date('d');
        $this->sms_m		 = date('m');
        $this->sms_h		 = date('H');
        $this->sms_i		 = date('i');
        $this->sms_y		 = date('Y');
        $this->sms_sender	 = 'CampagneSMS';
        $this->sms_type		 = self::SMS_STANDARD;
        $this->sms_mode		 = self::INSTANTANE;
        $this->request_mode	 = self::REEL;
        $this->request_id	 = '';
        $this->with_replies	 = 0;
        $this->transactional = 0;
        $this->msisdn_sender = 0;
        $this->request_keys	 = '';

        // SMS parts
        $this->user_batch_id = '';
    }

    public function send()
    {
        $domain	 = $this->config['domain'];
        $path	 = $this->config['path_sms'];
        $port	 = $this->config['port'];
        $data = array(
            'user_login'			 => $this->user_login,
            'api_key'				 => $this->api_key,
            'sms_text'				 => $this->sms_text,
            'sms_recipients'		 => implode(',', $this->sms_recipients),
            'recipients_first_names' => implode(',', $this->recipients_first_names),
            'recipients_last_names'	 => implode(',', $this->recipients_last_names),
            'sms_fields_1'			 => implode(',', $this->sms_fields_1),
            'sms_fields_2'			 => implode(',', $this->sms_fields_2),
            'sms_fields_3'			 => implode(',', $this->sms_fields_3),
            'sms_mode'				 => $this->sms_mode,
            'sms_type'				 => $this->sms_type,
            'sms_sender'			 => $this->sms_sender,
            'request_mode'			 => $this->request_mode,
            'request_id'			 => $this->request_id,
            'with_replies'			 => $this->with_replies,
            'transactional'			 => $this->transactional,
            'msisdn_sender'			 => $this->msisdn_sender
        );
        if ($this->sms_mode == self::DIFFERE)
        {
            // GMT + 1 (Europe/Paris)
            $data['sending_date'] = $this->sending_date;
        }
        // Si des champs sont définis, on calcule la clé
        if ($this->request_keys !== '')
        {
            $data['request_keys']	 = $this->request_keys;
            $data['request_sha1']	 = $this->_get_request_sha1_string($this->request_keys, $data);
        }
        return trim($this->_httpRequest($domain, $path, $port, $data));
    }

    public function getBalance()
    {
        $domain	 = $this->config['domain'];
        $path	 = $this->config['path_balance'];
        $port	 = $this->config['port'];
        $data = array(
            'user_login' => $this->user_login,
            'api_key'	 => $this->api_key
        );
        return trim($this->_httpRequest($domain, $path, $port, $data));
    }
    private function _get_request_sha1_string($request_keys, $data)
    {
        $A_char_to_field = array(
            'T'	 => 'sms_text',
            'R'	 => 'sms_recipients',
            'M'	 => 'sms_mode',
            'Y'	 => 'sms_type',
            'S'	 => 'sms_sender',
            'D'	 => 'sms_date',
            'a'	 => 'recipients_first_names',
            'b'	 => 'recipients_last_names',
            'c'	 => 'sms_fields_1',
            'd'	 => 'sms_fields_2',
            'e'	 => 'sms_fields_3',
            'W'	 => 'with_replies',
            'N'	 => 'transactional',
            'Q'	 => 'request_id'
        );
        $request_string	 = '';
        for ($i = 0, $n = strlen($this->request_keys); $i < $n; $i++)
        {
            $char = $this->request_keys[$i];
            if (!isset($A_char_to_field[$char]) || !isset($data[$A_char_to_field[$char]]))
                continue;
            $request_string .= $data[$A_char_to_field[$char]];
        }
        $request_sha1 = sha1($request_string);
        return $request_sha1;
    }
    private function _httpRequest($domain, $path, $port, $A_fields = array())
    {
        $ssl = $domain . $path;
        @set_time_limit(0);
        $qs	 = array();
        foreach ($A_fields as $k => $v)
        {
            $qs[] = $k . '=' . urlencode($v);
        }
        $request = join('&', $qs);
        if (function_exists('curl_init') AND $ch = curl_init(substr($domain, $this->config['cut']) . $path))
        {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_PORT, $port);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($ch);
            curl_close($ch);
            return $result;
        }
        else if (ini_get('allow_url_fopen'))
        {
            $fp = fsockopen(substr($domain, $this->config['cut']), $port, $errno, $errstr, 100);
            if (!$fp)
            {
                echo 'Unable to connect to host. Try again later.';
                return null;
            }
            $header = "POST " . $path . " HTTP/1.1\r\n";
            $header .= 'Host: ' . substr($domain, $this->config['cut']) . "\r\n";
            $header .= "Accept: text\r\n";
            $header .= "User-Agent: Octopush\r\n";
            $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
            $header .= "Content-Length: " . strlen($request) . "\r\n";
            $header .= "Connection: close\r\n\r\n";
            $header .= "{$request}\r\n\r\n";
            fputs($fp, $header);
            $result = '';
            while (!feof($fp))
                $result .= fgets($fp, 1024);
            fclose($fp);
            $result = substr($result, strpos($result, "\r\n\r\n") + 4);
            return $result;
        }
        else
        {
            die('Server does not support HTTP(S) requests.');
        }
        return $response;
    }
    public function set_user_login($user_login)
    {
        $this->user_login = $user_login;
    }
    public function set_api_key($api_key)
    {
        $this->api_key = $api_key;
    }
    public function set_sms_text($sms_text)
    {
        $this->sms_text = $sms_text;
    }
    public function set_sms_type($sms_type)
    {
        $this->sms_type = $sms_type;
    }
    public function set_sms_recipients($sms_recipients)
    {
        $this->sms_recipients = $sms_recipients;
    }
    public function set_recipients_first_names($first_names)
    {
        $this->recipients_first_names = $first_names;
    }
    public function set_recipients_last_names($last_names)
    {
        $this->recipients_last_names = $last_names;
    }
    public function set_sms_fields_1($sms_fields_1)
    {
        $this->sms_fields_1 = $sms_fields_1;
    }
    public function set_sms_fields_2($sms_fields_2)
    {
        $this->sms_fields_2 = $sms_fields_2;
    }
    public function set_sms_fields_3($sms_fields_3)
    {
        $this->sms_fields_3 = $sms_fields_3;
    }
    public function set_sms_mode($sms_mode)
    {
        $this->sms_mode = $sms_mode;
    }
    public function set_sms_sender($sms_sender)
    {
        $this->sms_sender = $sms_sender;
    }
    public function set_date($y, $m, $d, $h, $i)
    {
        $this->sms_y = intval($y);
        $this->sms_d = intval($d);
        $this->sms_m = intval($m);
        $this->sms_h = intval($h);
        $this->sms_i = intval($i);
        $this->sending_date = mktime($this->sms_h, $this->sms_i, 0, $this->sms_m, $this->sms_d);
    }
    public function set_simulation_mode()
    {
        $this->request_mode = self::SIMULATION;
    }
    public function set_sms_ticket($sms_ticket)
    {
        $this->sms_ticket = $sms_ticket;
    }
    public function set_sms_request_id($request_id)
    {
        $this->request_id = preg_replace('`[^0-9a-zA-Z]*`', '', $request_id);
    }
    /*
     * Notify Octopush plateform that you want to recieve the answers that your recipients will send back to your sending(s)
     */
    public function set_option_with_replies($with_replies)
    {
        if (!isset($with_replies) || intval($with_replies) !== 1)
        {
            $this->with_replies = 0;
        }
        else
        {
            $this->with_replies = 1;
        }
    }
    /*
     * Notify Octopush that you are making a transactional sending.
     * With this option, sending marketing SMS is strongly forbidden, and may make your account blocked in case of abuses.
     * DO NOT USE this option if you are not sure to understand what a transactional SMS is.
     */
    public function set_option_transactional($transactional)
    {
        if (!isset($transactional) || intval($transactional) !== 1)
        {
            $this->transactional = 0;
        }
        else
        {
            $this->transactional = 1;
        }
    }
    /*
     * Use a MSISDN number.
     */
    public function set_sender_is_msisdn($msisdn_sender)
    {
        $this->msisdn_sender = $msisdn_sender;
    }
    public function set_request_keys($request_keys)
    {
        $this->request_keys = $request_keys;
    }

    public function set_user_batch_id($user_batch_id)
    {
        $this->user_batch_id = preg_replace('`[^0-9a-zA-Z]*`', '', $user_batch_id);
    }
    /*
     * Finish the transmission of trames and allow platform to build campaign from package.
     */
    public function set_finished($finished)
    {
        if (intval($finished) === 1)
            $this->finished	 = 1;
        else
            $this->finished	 = 0;
    }
    /*
     * Send or delete a campaign.
     */
    public function set_action($action)
    {
        $this->action = $action;
    }
}
