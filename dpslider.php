<?php
/*
	Plugin Name: DreamPoints Slider by KRIS_IV
	Description: Wysuwany slider z linkiem do DP
	Version: v1.0.1
	Author: Krzysztof Kubiak
	Author URI: http://my-motivator.pl
	License: GPL2
*/

add_action('admin_init', 'dp_settings_init' );
add_action('admin_menu', 'dp_main_menu_add_page');

// Init plugin options to white list our options
function dp_settings_init(){
	register_setting( 'dp_settings_filed', 'dp_options', 'dp_validate' );
}

// Add menu page
function dp_main_menu_add_page(){
    add_menu_page( 'DreamPoints Slider', 'DP Slider', 'manage_options', 'dp_menu_page', 'dp_menu_page', plugins_url('images/LOGO_16.png',__FILE__), 99 );
}

add_action( 'admin_enqueue_scripts', 'dp_menu_css_scripts' );

function dp_menu_css_scripts(){
	wp_register_style( 'dpslidermenu-style', plugins_url('css/menu.css', __FILE__) );
	wp_enqueue_style( 'dpslidermenu-style' );
}

// Draw the menu page itself
function dp_menu_page() {
//WERSJA PLUGINU
$wersja = 'v1.0';
//PODAJ POWYŻEJ WERSJĘ
	?>
	<div class="wrap">
		<h2><div class="dp_logo_program"></div> DreamPoints Slider <?php echo $wersja; ?></h2>
	<div id="welcome-panel" class="welcome-panel">
		<form method="post" action="options.php">
			<?php settings_fields('dp_settings_filed'); ?>
			<?php $options = get_option('dp_options'); ?>
			<table class="form-table">
				<tr valign="top"><th scope="row">Wybieram prosty slider:</th>
					<td><input name="dp_options[option1]" type="checkbox" value="1" <?php 
						if(isset($options['option1'])){checked($options['option1'], 1);}
					?> /></td>
				</tr>
				<tr valign="top"><th scope="row">Wyświetl własny opis:</th>
					<td><input name="dp_options[option2]" type="checkbox" value="1" <?php 
						if(isset($options['option2'])){checked($options['option2'], 1);} 
					?> /></td>
				</tr>				
				<tr valign="top"><th scope="row">Treść opisu:</th>
					<td><textarea name="dp_options[tekst1]" type="text" cols="80" rows="4"><?php echo $options['tekst1']; ?></textarea></td>
				</tr>
				
			</table>
			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Zapisz zmiany') ?>" />
			</p>
		</form>
	</div>
	<div id="welcome-panel" class="welcome-panel">
		<h3>Zmiany:</h3>
		<h4>v1.0</h4>
			<ul>
			<li> - Dodano opcję slider bez ręki (tradycyjny)</li>
			<li> - Możliwość wyłączenia tradycyjnego opisu wewnątrz slidera</li>
			</ul>
		<h4>v0.3</h4>
			<ul>
			<li> - Poprawiony CSS (wczytywanie czcionek na windows XP)</li>
			<li> - Inne błędy formatowania</li>
			</ul>
			
	</div>
	<?php	
}

// Sanitize and validate input. Accepts an array, return a sanitized array.
function dp_validate($input) {
	// Our first value is either 0 or 1
if (isset($input['option1'])) {$input['option1'] = ( $input['option1'] == 1 ? 1 : 0 );}
if (isset($input['option2'])) {$input['option2'] = ( $input['option2'] == 1 ? 1 : 0 );}
	$input['tekst1'] =  ($input['tekst1']);

	return $input;
}


//Slider
add_action('wp_head', 'dp_slider');

function dp_slider () 
{
$options = get_option('dp_options');
if(isset($options['option1'])){ $kindoftxt= $options['option1']; }
if(isset($options['option2'])){ $kindofopis= $options['option2']; }
$realny_opis= $options['tekst1'];
 echo '
	<a href="http://www.dreampoints.pl" target="_blank">
		<div id="dp_slider">
			<div id="dp_slider_content">
				<div id="dp_foto_outside">';
if(isset($options['option1'])){ if ($kindoftxt==true) {
echo ' <div id="traditional_text">DreamPoints</div>';
}
} else {
}


echo '
				</div>
				<div id="dp_foto_inside"></div>
			</div>
			<div id="dp_slider_text"> 
			<div class="dpsliderlogo">
				</div> 
				
				<div class="dp_l1">
				<a href="http://www.dreampoints.pl" target="_blank"> ';
				
if(isset($options['option2'])) {if ($kindofopis==true){
	echo $realny_opis;
} 
}else{
	echo bloginfo();
	echo '
						 przyniosą korzyści o jakich nawet Ci się nie śniło!<br>
						Oszczędzaj z kartą <strong>DreamPoints</strong>.';
}

echo				'</a>
					</div>
					<div class="dp_l2">
						<div class="sliderbutton">
							<a href="http://dreampoints.pl/"> Dowiedz się więcej</a>
						</div>
					</div>
				</div>
			</div>
		</a>
		';

}

//Add CSS
add_action( 'wp_enqueue_scripts', 'style_CSS_dpslider' );

function style_CSS_dpslider() 
{
$options = get_option('dp_options');
if(isset($options['option1'])){ $kindofcss = $options['option1'];}
if(isset($options['option1'])){ if ($kindofcss==true) {
	wp_register_style( 'dpslider-style2', plugins_url('css/style_traditional.css', __FILE__) );
	wp_enqueue_style( 'dpslider-style2' );
} 
}else {
	wp_register_style( 'dpslider-style', plugins_url('css/style.css', __FILE__) );
	wp_enqueue_style( 'dpslider-style' );
	
}

}	


?>