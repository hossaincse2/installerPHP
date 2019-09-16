<?php
/**
 * We are installing.
 */
define( 'SCRIPT_INSTALLING', true );

/**
 * We are blissfully unaware of anything.
 */
define( 'SCRIPT_SETUP_CONFIG', true );

/**
 * Disable error reporting
 *
 * Set this to error_reporting( -1 ) for debugging
 */
error_reporting( 0 );

 $step = isset( $_GET['step'] ) ? (int) $_GET['step'] : -1;

 if(isset($step) && $step == 3 ){
   $login = 'login.php'; 
   header("Location: $login"); 
   exit();
 }

if ( !defined('ABSPATH') )
        define('ABSPATH', dirname(__FILE__) . '/');

// Support wp-config-sample.php one level up, for the develop repo.
if ( file_exists( ABSPATH . 'sample-database.php' ) ) {
     $config_file = file( ABSPATH . 'sample-database.php' );
     //print_r($config_file);
} elseif ( file_exists( dirname( ABSPATH ) . '/sample-database.php' ) ) {
	$config_file = file( dirname( ABSPATH ) . '/sample-database.php' );
} else {
 		printf(
			/* translators: %s: wp-config-sample.php */
			 'Sorry, I need a %s file to work from. Please re-upload this file to your WordPress installation.',
			'<code>sample-database.php</code>'
     );
       die();
}

// Check if wp-config.php has been created
if ( file_exists( ABSPATH . 'database.php' ) ) {
 		'<p>' . printf(
			/* translators: 1: wp-config.php, 2: install.php */
			 'The file %1$s already exists. If you need to reset any of the configuration items in this file, please delete it first. You may try <a href="%2$s">installing now</a>.',
			'<code>database.php</code>',
			'setup-config.php?step=2'
        ) . '</p>';
          die();
 }

// Check if wp-config.php exists above the root directory but is not part of another installation
if ( @file_exists( ABSPATH . '../database.php' ) && ! @file_exists( ABSPATH . '../database.php' ) ) {
	 
		'<p>' . printf(
			/* translators: 1: wp-config.php, 2: install.php */
			 'The file %1$s already exists one level above your WordPress installation. If you need to reset any of the configuration items in this file, please delete it first. You may try <a href="%2$s">installing now</a>.',
			'<code>database.php</code>',
			'install.php'
		) . '</p>';
	  die();
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="robots" content="noindex,nofollow" />
	<title><?php echo 'WordPress &rsaquo; Setup Configuration File'; ?></title>
 </head>
<body class="setup">
    <div class="container-wrapper">
<?php
switch ( $step ) {
    case -1:
     $step_1 = 'setup-config.php?step=1'; 
     ?>
       <div class="container">
        <p>Welcome to WordPress. Before getting started, we need some information on the database. You will need to know the following items before proceeding.</p>
        <ol>
            <li><?php echo 'Database name'; ?></li>
            <li><?php echo  'Database username'; ?></li>
            <li><?php echo 'Database password'; ?></li>
            <li><?php echo 'Database host'; ?></li>
         </ol>
         <p>We’re going to use this information to create a wp-config.php file. If for any reason this automatic file creation doesn’t work, don’t worry. All this does is fill in the database information to a configuration file. You may also simply open wp-config-sample.php in a text editor, fill in your information, and save it as wp-config.php. Need more help? We got it.</p>
       <p>In all likelihood, these items were supplied to you by your Web Host. If you don’t have this information, then you will need to contact them before you can continue. If you’re all ready…</p>
        <p class="step"><a href="<?php echo $step_1; ?>" class="button button-large"><?php  echo  'Lets go!' ; ?></a></p>
       </div>
     <?php

     break;
?> 
 
 <?php

case 1:
 
		?>
<h1 class="screen-reader-text"><?php echo 'Set up your database connection'; ?></h1>
<form method="post" action="setup-config.php?step=2">
	<p><?php echo 'Below you should enter your database connection details. If you&#8217;re not sure about these, contact your host.'; ?></p>
	<table class="form-table" role="presentation">
		<tr>
			<th scope="row"><label for="dbname"><?php echo 'Database Name'; ?></label></th>
			<td><input name="dbname" id="dbname" type="text" aria-describedby="dbname-desc" size="25" value=""/></td>
			<td id="dbname-desc"><?php echo 'The name of the database you want to use with WordPress.'; ?></td>
		</tr>
		<tr>
			<th scope="row"><label for="uname"><?php echo 'Username'; ?></label></th>
			<td><input name="uname" id="uname" type="text" aria-describedby="uname-desc" size="25" value="" /></td>
			<td id="uname-desc"><?php echo 'Your database username.'; ?></td>
		</tr>
		<tr>
			<th scope="row"><label for="pwd"><?php echo 'Password'; ?></label></th>
			<td><input name="pwd" id="pwd" type="text" aria-describedby="pwd-desc" size="25" value="" autocomplete="off" /></td>
			<td id="pwd-desc"><?php echo 'Your database password.'; ?></td>
		</tr>
		<tr>
			<th scope="row"><label for="dbhost"><?php echo 'Database Host'; ?></label></th>
			<td><input name="dbhost" id="dbhost" type="text" aria-describedby="dbhost-desc" size="25" value="localhost" /></td>
			<td id="dbhost-desc">
			<?php
 				printf( 'You should be able to get this info from your web host, if %s doesn&#8217;t work.', '<code>localhost</code>');
			?>
			</td>
		</tr> 
	</table>
		 
	<p class="step"><input name="submit" type="submit" value="<?php echo 'Submit'; ?>" class="button button-large" /></p>
</form>
		<?php
		break;

    case 2:
        $dbname = trim( $_POST['dbname'] );
		$uname  = trim( $_POST['uname'] );
		$pwd    = trim( $_POST['pwd'] );
        $dbhost = trim( $_POST['dbhost'] );

        $install = 'install.php';

        
       // print_r($config_file);
        //$conn = new PDO("mysql:host={$dbhost};dbname={$dbname}", $uname,$pwd,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $conn = new mysqli($dbhost, $uname, $pwd, $dbname);

	    // if(isset($_GET['refresh'])  && $_GET['refresh'] == '1'){
        //    $sql = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA LIKE '".$dbname."'";
        //     $result = $conn->query($sql);
        //     $tables = $result->fetch_all(MYSQLI_ASSOC);
        //     foreach($tables as $table) {
        //         $sql = "TRUNCATE TABLE `".$table['TABLE_NAME']."`";
        //         $result = $conn->query($sql);
        //     }
        //  }
		// Error handling
		// if(mysqli_connect_error()) {
		// 	trigger_error("Failed to conencto to MySQL: " . mysql_connect_error(),
		// 		 E_USER_ERROR);
		// }
        if(!mysqli_connect_error()){
        foreach ( $config_file as $line_num => $line ) { 
           //
              
            if (strpos($line, '$db_') === false) {
                     continue;
                } 
             $config_file[6] =  "private ".'$db_host'." = '$dbhost';"."\n";
             $config_file[7] =  "private ".'$db_user'." = '$uname';"."\n";
             $config_file[8] =  "private ".'$db_pass'." = '$pwd';"."\n";
             $config_file[9] =  "private ".'$db_name'." = '$dbname';"."\n";
             
        } 
        
         if ( file_exists( ABSPATH . 'sample-database.php' ) ) {
			$path_to_wp_config = ABSPATH . 'database.php';
		} else {
			$path_to_wp_config = dirname( ABSPATH ) . '/database.php';
		}

		$handle = fopen( $path_to_wp_config, 'w' );
		foreach ( $config_file as $line ) {
            //echo $line;
			 fwrite( $handle, $line );
		}
		fclose( $handle );
        chmod( $path_to_wp_config, 0666 );
        // file edit and also import db into database
     
            echo "Database Connection Successfully."."\n";
            require($install);
        }else{
            // trigger_error("Failed to conencto to MySQL: " . mysql_connect_error(),
			// 	 E_USER_ERROR);
            echo 'Database Not Connection.';
            echo '<a href="setup-config.php?step=1">&nbsp;Please Back Database</a>';
            die();
        }
        
        ?>


            <div class="container">
                <h3>SignUp</h3>
                <form action="setup-config.php?step=3" method="POST">
                <table class="form-table" role="presentation">
                    <tr>
                        <th scope="row"><label for="companyName"><?php echo 'Company Name'; ?></label></th>
                        <td><input name="companyName" id="companyName" type="text" aria-describedby="dbname-desc" size="25" value=""/></td>
                        <td id="companyName-desc"><?php echo 'The name of Company Name.'; ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="name"><?php echo 'Name'; ?></label></th>
                        <td><input name="name" id="name" type="text" aria-describedby="uname-desc" size="25" value="" /></td>
                        <td id="uname-desc"><?php echo 'Your name.'; ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="username"><?php echo 'Username'; ?></label></th>
                        <td><input name="username" id="username" type="text" aria-describedby="username-desc" size="25" value="" autocomplete="off" /></td>
                        <td id="username-desc"><?php echo 'Your username.'; ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="email"><?php echo 'Email'; ?></label></th>
                        <td><input name="email" id="email" type="text" aria-describedby="email-desc" size="25" value="" /></td>
                        <td id="email-desc"> <?php echo 'Your Email username.'; ?> </td>
                    </tr> 
                    <tr>
                        <th scope="row"><label for="password"><?php echo 'Password'; ?></label></th>
                        <td><input name="password" id="password" type="text" aria-describedby="password-desc" size="25" value="" autocomplete="off" /></td>
                        <td id="password-desc"><?php echo 'Your password.'; ?></td>
                    </tr>
                </table>
                   <h4>SMTP Setup</h4>
                   <table class="form-table" role="presentation">
                    <tr>
                        <th scope="row"><label for="host"><?php echo 'SMTP Host'; ?></label></th>
                        <td><input name="host" id="host" type="text" aria-describedby="host-desc" size="25" value=""/></td>
                        <td id="host-desc"><?php echo 'The name of SMTP Host.'; ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="smtpuser"><?php echo 'SMTP User'; ?></label></th>
                        <td><input name="smtpuser" id="smtpuser" type="text" aria-describedby="smtpuser-desc" size="25" value="" /></td>
                        <td id="smtpuser-desc"><?php echo 'Your SMTP User.'; ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="smtppassword"><?php echo 'SMTP Password'; ?></label></th>
                        <td><input name="smtppassword" id="smtppassword" type="text" aria-describedby="smtppassword-desc" size="25" value="" autocomplete="off" /></td>
                        <td id="smtppassword-desc"><?php echo 'Your SMTP Password.'; ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="smtpPort"><?php echo 'SMTP Port'; ?></label></th>
                        <td><input name="smtpPort" id="smtpPort" type="text" aria-describedby="smtpPort-desc" size="25" value="" /></td>
                        <td id="smtpPort-desc"> <?php echo 'Your  SMTP Port.'; ?> </td>
                    </tr> 
                    <tr>
                        <th scope="row"><label for="SMTPSecure"><?php echo 'SMTP Secure '; ?></label></th>
                        <td><input name="SMTPSecure" id="SMTPSecure"  type="text" value="TLS" aria-describedby="SMTPSecure-desc" size="25" value="" autocomplete="off" /></td>
                        <td id="SMTPSecure-desc"><?php echo 'Your SMTP Secure.'; ?></td>
                    </tr>
                </table>
                     	<p class="step"><input name="submit" type="submit" value="<?php echo 'Submit'; ?>" class="button button-large" /></p>
                </form>
            </div>


        <?php
 
        break; 
}
			?> 
  
</div>
</body>
</html>
