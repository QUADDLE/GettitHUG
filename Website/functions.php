<?php
  
  //In dieser Datei liegt die Funktion "mysql_verbindung()"
  include 'mysql_daten.php';
  
  //Überprüft übergebenen String ob es eine gültige E-Mail-Adresse ist oder nicht
  //Quelle: http://www.php.de/forum/webentwicklung/php-fortgeschrittene/99-email-adresse-auf-korrektheit-%C3%BCberpr%C3%BCfen
  function check_email_syntax($email) {
    if(!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
        return false;
    }
    $email_array = explode("@", $email);
    $local_array = explode(".", $email_array[0]);
    for ($i = 0; $i < sizeof($local_array); $i++) {
        if(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
            return false;
        }
    }
    if(!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
        $domain_array = explode(".", $email_array[1]);
        if(sizeof($domain_array) < 2) {
            return false;
        }
        for($i = 0; $i < sizeof($domain_array); $i++) {
            if(!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
                return false;
            }
        }
    }
    return true;
  } 
  
  //Gibt de Code einer Fehlermeldung zurück
  //haken - gibt den HTML-Code zu einem grünen Hakenbild aus
  //a - Benutzername fehlt
  //b - EMail fehlt
  //c - EMail ist ungültig
  //d - Passwort fehlt
  //e - Passwort wurde nicht wiederholt
  //f - Passwort und wiederholtes Passwort stimmen nicht überein
  //g - Nutzername enthält nicht nur Zahlen und Buchstaben
  //h - Nutzername enthält Leerzeichen
  //i - Passwort muss min. eine Zahl und ein G-Buchstaben enthalten
  //j - Benutzername bereits vergeben
  //k - EMail bereits vergeben
  
  function fehlermeldung($code) {
    switch($code) {
      case 'haken':
        return "<img src=\"https://www.komma-news.de/landingpages/domains/sek/images/gruener_Haken.gif\">";
        break;
      case 'a':
        return "Bitte gib einen Benutzernamen an!";
        break;
      case 'b':
        return "Bitte gib eine E-Mail-Adresse an!";
        break;
      case 'c':
        return "Die E-Mail-Adresse ist ungültig!";
        break;
      case 'd':
        return "Bitte gib ein Passwort ein!";
        break;
      case 'e':
        return "Bitte wiederhole dein Passwort!";
        break;
      case 'f':
        return "Die Passwörter stimmen nicht überein!";
        break;
      case 'g':
        return "Es sind nur Zahlen (0-9) und Buchstaben (A-Z) erlaubt!";
        break;
      case 'h':
        return "Im Benutzername sind keine Leerzeichen erlaubt!";
        break;
      case 'i':
        return "Eine Zahl, Ein Großbuchstabe und Mindestlänge: 8 ;)";
        break;
      case 'j':
        return "Dieser Benutzername ist bereits vergeben!";
        break;
      case 'k':
        return "Diese E-Mail-Adresse ist bereits vergeben!";
        break;
      case 'l':
        return "Login-Daten falsch!";
        break;
    }
  }  
  //Überprüft ob die EMail bereits vergeben ist.
  //true = EMail vergeben
  //false = EMail frei
  function email_bereits_vergeben($email) {
    mysql_verbindung();
    $abfrage = "SELECT * FROM email WHERE email = '$email'";
    $data = mysql_query($abfrage);
    $i = 0;
    while($row = mysql_fetch_object($data)) {
      $i++;
    }
    if($i >= 1) {
      return true;
    } else {
      return false;
    }
  }
  //Gibt einen Fehlermeldung als String zurück
  //oder true wenn EMail korrekt ist  
  function check_email($email) {
    if($email == '') {
      return fehlermeldung('b');
    } else if(!check_email_syntax($email)) { 
      return fehlermeldung('c');
      } else if(email_bereits_vergeben($email)) {
        return fehlermeldung('k');
        } else {
          return true;
        }
  }  
  function mysql_verbindung_beispiel() {
    $server = "DEINSERVER";
    $benutzername = "DEINBENUTZERNAME";
    $passwort = "DEINPASSWORT";
    $datenbank = "DEINEDATENBANK";
    $verbindung = mysql_connect($server, $benutzername, $passwort) or die ("Die Verbindung konnte nicht hergestellt werden");
    mysql_select_db($datenbank) or die ("Fehler beim Verbinden mit der Datenbank.");
  }
?>