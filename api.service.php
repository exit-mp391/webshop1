<?php

// Ucitavamo user klasu
require_once './User.class.php';
// Kreiramo objekat User klase da bi smo mogli da koristimo njene metode
$u = new User();

// Pravimo prazan niz koji cemo vratiti kao rezultat izvrsavanja ovog servisa u JSON formatu
$output = [];

// Proveravamo da li u POST nizu postoji username
if(isset($_POST['username']) && $_POST['username'] != '') {
  // Ukoliko postoji username pozivamo metodu check_username (User.class.php) da proveri da li u bazi vec postoji korisnik sa izabranim korisnickim imenom
  $output['username_taken'] = $u->check_username($_POST['username']);
}

if(isset($_POST['email']) && $_POST['email'] != '') {
  // Ukoliko postoji email pozivamo metodu check_email (User.class.php) da proveri da li u bazi vec postoji korisnik sa izabranom email adresom
  $output['email_taken'] = $u->check_email($_POST['email']);
}


// Kazemo PHPu da zelimo da vratimo podatke u JSON formatu
header('Content-Type: application/json');

// Ispisujemo PHP niz u JSON formatu
echo json_encode($output);
