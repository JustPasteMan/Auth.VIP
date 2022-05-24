<?php

class functions {

	public static function generate_license($type = 1, $mask = null) {
        $normal_mode = static function($a, $l){
            $out = '';

            for($i = 0; $i < $a; $i++)
                $out .= self::random_string($l).'-';

            return substr($out, 0, -1);
        };

	    switch($type){
            case 1:
                return $normal_mode(4, 5); 

            case 2:
                return $normal_mode(6, 5);

            case 3:
                return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', random_int(0, 65535), random_int(0, 65535), random_int(0, 65535), random_int(16384, 20479), random_int(32768, 49151), random_int(0, 65535), random_int(0, 65535), random_int(0, 65535));

            case 4:
                //key masks
                //123-XXXX turns into 123-UJKL (example)

                $mask_arr = str_split($mask);

                $size_of_mask = count($mask_arr);

                for($i = 0; $i < $size_of_mask; $i++)
                    if($mask_arr[$i] === 'X')
                        $mask_arr[$i] = self::random_string(1);

                return implode('', $mask_arr);

            default:
                return 'unknown';
        }
	}

	public static function is_valid_timestamp($timestamp) : bool {
        try{
            new DateTime('@'.(string)$timestamp);
        }
        catch(Exception $ex){
            return false;
        }

        return true;
	}

	public static function random_string($length = 10, $keyspace = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'): string {
        $out = '';

        for($i = 0; $i < $length; $i++){
            $rand_index = random_int(0, strlen($keyspace) - 1);

            $out .= $keyspace[$rand_index];
        }

        return $out;
	}

	static function get_ip() { //headers used by fluxcdn
        if (isset($_SERVER['HTTP_X_REAL_IP']))
            return $_SERVER['HTTP_X_REAL_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        else
            return 'unknown';
    }

	public static function captcha_check($secret, $response) {
        $curl_inst = curl_init('https://www.google.com/recaptcha/api/siteverify');

        curl_setopt($curl_inst, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl_inst, CURLOPT_POST, true);

        curl_setopt($curl_inst, CURLOPT_POSTFIELDS, array(
            'secret' => $secret,
            'response' => $response
        ));

		$response = curl_exec($curl_inst);

		curl_close($curl_inst);

		$response = json_decode($response);

		return $response->success; //bool ?
	}

    public static function get_days_date_dif($timestamp , $local_time = null) : int {
        if($local_time === null)
            $local_time = time();

        $first = new DateTime("@$timestamp");

        $second = new DateTime("@$local_time");

        return (int)$first->diff($second)->format('%d') + 1; 
        
        //1 is added because the result is one day less than the original time
    }

    public static function get_time_to_add($days): string {
        return '+' . $days . ' days'; // Lol, useless right?
    }

	public static function xss_clean($s) : string {
		return htmlentities($s, ENT_QUOTES, 'UTF-8');
	}

    public static function box($str, $type = 0) : void {
		$str_type = static function($type){
            switch($type){
                case 0:
                    return 'info';
                case 1:
                    return 'warning';
                case 2:
                    return 'success';
                case 3:
                    return 'error';
            }
            return null;
        }; ?> 
        
        <script> alert("<?php echo self::xss_clean($str); ?>"); </script> 
<?php
    }

	public static function display_user_data($username, $is_premium, $is_admin) : void {
        //username, is premium, is admin

        if($is_admin){
            $role_type = "Admin";
        } else if($is_premium){
            $role_type = "Premium user";
        } else {
            $role_type = "Free user";
        }

        ?>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow"><div class="drop-heading">
														<div class="text-center">
                                                        <h5 class="text-dark mb-0"><?php echo $username; ?></h5>
                                                        <small class="text-muted">Role: <?php echo $role_type; ?></small>
														</div>
													</div>
													<div class="dropdown-divider m-0"></div>
                                                    <?php if($is_admin) { ?>
                                                       <a class="dropdown-item" href="../admin/">
														<i class="dropdown-icon fe fe-user"></i> Admin Page
													</a> 
                                                    <?php } ?> 
													<a class="dropdown-item" href="account.php">
														<i class="dropdown-icon fe fe-mail"></i> Account 
													</a>
													<a class="dropdown-item" href="logout.php">
														<i class="dropdown-icon fe fe-alert-circle"></i> Sign out
													</a> 
                </div>
        <?php
    }

    public static function display_classes() : void{
        //class name + location
        $classes_folder = '../classes/';

        $classes = array(
            'C#' => $classes_folder.'c%23.zip',
            'C++' => $classes_folder.'c++.zip',
        );

        ?>

        <li class="side-menu-label1"><a href="javascript:void(0)">Classes</a></li>

<?php 
        foreach($classes as $class => $location){
            echo "<li><a href='$location' class='slide-item'> $class </a></li>";
        }
    }

	public static function display_news() : void {

        /*$values = [
            'Name' => ['News', 'changelog.txt'],
            'Name2' => ['News info 2', 'link.txt']
        ]; */

        $values = [];

        foreach($values as $name => $in) { ?>

       
            <a class="dropdown-item d-flex" href="<?php echo $in[1]; ?>">
	<div class="me-3 notifyimg  bg-secondary-gradient brround box-shadow-primary">
<i class="fe fe-mail"></i></div>
				<div class="mt-1">
                <h5 class="notification-label mb-1"><?php echo $name; ?></h5>
                <span class="notification-subtext"><?php echo $in[0]; ?></span>
															</div>
														</a> 
        
<?php   } 
    }
}

class encryption{
    private $enc_key, $iv_key;

    public function __construct($enc_key, $iv_key = null, $sha_mode = true){
        $this->enc_key = ($sha_mode) ?
            substr(hash('sha256', $enc_key), 0, 32) : $enc_key;

        if(strlen($this->enc_key) !== 32)
            throw new Exception('wrong key length');

        $this->iv_key = substr($iv_key, 0, 16);
    }

    public function encrypt($message, $custom_iv = null) : string {
        if($custom_iv === null && strlen($this->iv_key) !== 16)
            throw new Exception('not valid iv length');

        $used_iv = $custom_iv ?? $this->iv_key; //custom iv has priority

        $encrypted_string = openssl_encrypt($message, $this->method, $this->enc_key, true, $used_iv);

        return bin2hex($encrypted_string);
    }

    public function decrypt($message, $custom_iv = null){
        $message = hex2bin($message);

        if($custom_iv === null && strlen($this->iv_key) !== 16)
            throw new Exception('not valid iv length');

        $used_iv = $custom_iv ?? $this->iv_key; //custom iv has priority

        return openssl_decrypt($message, $this->method, $this->enc_key, true, $used_iv);
    }

    #region static_b64_deprecated

    public static function static_encrypt($text, $key = 'c_auth_project') : string {
        $iv = random_bytes(16);

        return base64_encode( openssl_encrypt($text, 'aes-256-cbc', md5($key), true, $iv) . '{c_auth}' . $iv);
    }

    public static function static_decrypt($text, $key = 'c_auth_project') {
        $data = explode('{c_auth}', base64_decode($text));

        return openssl_decrypt($data[0], 'aes-256-cbc', md5($key), true, $data[1]);
    }
    #endregion

    private string $method = 'aes-256-cbc';
}
