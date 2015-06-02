<?php
  session_start(); //Hier wird die Session gestartet
  include 'functions.php'; //Import wichtiger Funktionen
  
  if(!empty($_SESSION['email_bereits_angegeben']) && $_SESSION['email_bereits_angegeben'] == "ja"){
  /*
    -- ANFANG -- User hat sich bereits angemeldet - $_SESSION['email_bereits_angegeben'] ist mit ja vergeben und positiv
  */
?>
  
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <style>
      #maindiv {
        background: #CCC;
        border: 1px solid #666;
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 1.2em;
        color: #333;
        position: absolute;
        width: 280px;
        height: 250px;
        top: 30%;
        left: 50%;
        margin-top: -75px;
        margin-left: -100px;
        vertical-align: center;
      }
      #textdiv {
        position: relative;
        top: 30%;
        -webkit-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
      }
    </style>
  </head>
  <body>
    <div id="maindiv">
      <div id="textdiv">
        <center>
          <h6>Vielen Dank f&uuml;r deine Anmeldung.</h6>
        </center>
      </div>
    </div>
  </body>
</html>
  
<?php
  /*
    -- ENDE -- User hat sich bereits angemeldet - $_SESSION['email_bereits_angegeben'] ist mit ja vergeben und positiv
  */  
  } else {
  /*
    -- ANFANG -- User ist neu und hat seine E-Mail noch nicht angegeben - $_SESSION['email_bereits_angegeben'] ist leer
  */

  $ist_email_akzeptabel = false; //global - zeigt die Gültigkeit der EMail: true = gültig; false = ungültig
  $feldfarbe_email = "style=\"background:white\""; //global - gibt die Feldfarbe Inputfelds an 
  
  //INITIALISIERUNG - Überprüft die EMail und manipuliert entsprechend die globalen Variablen
  function meldung_email() {
    global $ist_email_akzeptabel, $feldfarbe_email, $meldung_email;
    if(!empty($_POST['formular_gesendet'])) {
      if(is_bool(check_email($_POST['email'])) AND check_email($_POST['email']) == true) {
        $feldfarbe_email = "style=\"background:green\"";
        $fehlermeldung = fehlermeldung('haken');
        $meldung_email = "<td> $fehlermeldung </td>";
        $ist_email_akzeptabel = true;
      } else {      
        $feldfarbe_email = "style=\"background:red\"";
        $fehlermeldung = check_email($_POST['email']);
        $meldung_email = "<td> $fehlermeldung </td>";
      }
    }
  }
?>

<?php
  //AUSFÜHREN - Überprüft die EMail und manipuliert entsprechend die globalen Variablen
  meldung_email()
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <style>
      h6 {
        color: red;
      }
      #maindiv {
        background: #CCC;
        border: 1px solid #666;
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 1.2em;
        color: #333;
        position: absolute;
        width: 280px;
        height: 250px;
        top: 30%;
        left: 50%;
        margin-top: -75px;
        margin-left: -100px;
        vertical-align: center;
      }
      #textdiv {
        position: relative;
        top: 50%;
        -webkit-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
      }
    </style>
  </head>
  <body>
    <div id="maindiv">
      <center>
        <form name="EMailangeben" method="post" action="<?php $_SERVER['PHP_SELF']?>">
        <br>
        <h5>Gettit Alpha Anmeldung</h5>
        <input type="text" name="email" <?php echo $feldfarbe_email ?> <?php if(!empty($_POST['formular_gesendet']) && !empty($_POST['email'])) echo "value=\"", $_POST['email'], "\""?>>
        <br>
        <br>
        <input type="hidden" name="formular_gesendet" value="true">
        <input type="submit" name="Anmelden" value="Anmelden">
        <h6><?php if(!empty($meldung_email)) echo $meldung_email ?></h6>
        </form>
      </center>
    </div>
  </body>
</html>

<?php

  //Trägt die EMail in die Tabelle ein
  function trage_email_ein($email) {
    mysql_verbindung();
    $eintrag = "INSERT INTO gettit (
    email) 
    VALUES (
    '$email'
    )";
    $eintragen = mysql_query($eintrag);
  }

  //Überprüft ob die EMail gültig ist
  //true - trägt die EMail in die Tabelle ein
  if($ist_email_akzeptabel) {
  trage_email_ein($_POST['email']);
  $_SESSION['email_bereits_angegeben'] = "ja";
  $_SESSION['email_bereits_angegeben'] = "ja";
  }
  
  /*
    -- ENDE -- User ist neu und hat seine E-Mail noch nicht angegeben - $_SESSION['email_bereits_angegeben'] ist leer
  */
}
?>