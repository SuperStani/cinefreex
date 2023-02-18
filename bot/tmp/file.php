
<?php

$conn = new PDO("mysql:host=localhost;dbname=netfluzmax", "admin", "@Naruto96");

$data = $conn->query("SELECT m.name, m.season, m.id FROM movie m  INNER JOIN episodes e ON m.id = e.movie GROUP by m.id");
//var_dump($data);
foreach($data as $movie) {
	file_put_contents(__DIR__ . "/backup.txt", $movie['name'] . " " . (($movie['season'] > 0) ? "S" . $movie['season'] : '') . " - " . $movie['id'] . PHP_EOL, FILE_APPEND | LOCK_EX);
}
