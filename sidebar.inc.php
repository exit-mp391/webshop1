<?php

require_once './Category.class.php';

$c = new Category();

$categories = $c->all();

/* PREVOD SAJTA */
$langs = file_get_contents('./langs.json');
$langs = json_decode($langs);
$l = $langs->rs;
// var_dump($langs);


// http://requests.ryanmccue.info/docs/usage.html

include './library/Requests.php';

Requests::register_autoloader();

$data = Requests::get("http://api.openweathermap.org/data/2.5/weather?q=Nis,Serbia&APPID=5ef67dd8df978efdd811890b558e1538&units=metric");

$data = json_decode($data->body);
$icon = "http://openweathermap.org/img/w/"
. $data->weather[0]->icon
. ".png";

$temp = $data->main->temp;
$pressure = $data->main->pressure;
$humidity = $data->main->humidity;
$temp_min = $data->main->temp_min;
$temp_max = $data->main->temp_max;

$widget = Requests::get("http://www.kurir.rs/news_widget_amc/?source=widget&amp;medium=banner&amp;campaign=Elle");


?>

<!-- <h3>Kategorije</h3> -->
<h3><?php echo $l->titles->category ?></h3>

<div class="list-group">
	<?php foreach($categories as $cat): ?>
		<a href="products.php?cat_id=<?php echo $cat['id']; ?>" class="list-group-item">
			<span class="badge"><?php echo $cat['count'] ?></span>
			<?php echo $cat['title']; ?>
		</a>
	<?php endforeach; ?>
</div>


<h3>Weather info</h3>
<img src="<?php echo $icon; ?>" />
<p>
	<strong>Temperature:</strong> <?php echo $temp; ?><br />
</p>


<!-- <iframe src="http://www.kurir.rs/news_widget_amc/?source=widget&amp;medium=banner&amp;campaign=Elle" width="100%" height="500px" border="0" style="overflow: scroll; border: 0px;"></iframe> -->
