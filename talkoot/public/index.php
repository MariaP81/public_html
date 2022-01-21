<?php

  // Suoritetaan projektin alustusskripti.
  require_once '../src/init.php';

  // Siistitään polku urlin alusta ja mahdolliset parametrit urlin lopusta.
  // Siistimisen jälkeen osoite /~koodaaja/lanify/tapahtuma?id=1 on 
  // lyhentynyt muotoon /tapahtuma.
  $request = str_replace($config['urls']['baseUrl'],'',$_SERVER['REQUEST_URI']);
  $request = strtok($request, '?');

   // Luodaan uusi Plates-olio ja kytketään se sovelluksen sivupohjiin.
   $templates = new League\Plates\Engine(TEMPLATE_DIR);


  // Selvitetään mitä sivua on kutsuttu ja suoritetaan sivua vastaava
  // käsittelijä.
  switch ($request) {
    case '/':
    case '/tapahtumat':
      require_once MODEL_DIR . 'tapahtuma.php';
      $tapahtumat = haeTapahtumat();
      echo $templates->render('tapahtumat',['tapahtumat' => $tapahtumat]);
      break;
    case '/tapahtuma':
      require_once MODEL_DIR . 'tapahtuma.php';
      $tapahtuma = haeTapahtuma($_GET['id']);
      if ($tapahtuma) {
        echo $templates->render('tapahtuma',['tapahtuma' => $tapahtuma]);
      } else {
        echo $templates->render('tapahtumanotfound');
      }
      break;
      // ... switch-lauseen alku säilyy sellaisenaan
      case '/lisaa_tili':
        if (isset($_POST['laheta'])) {
          $formdata = cleanFormData($_POST);
          require_once CONTROLLER_DIR . 'tili.php';
          $tulos = lisaaTili($formdata);
          if ($tulos['status'] == "200") {
            echo "Tili on luotu tunnisteella $tulos[id]";
            break;
          }
          echo $templates->render('tili_lisaa', ['formdata' => $formdata, 'error' => $tulos['error']]);
          break;
        } else {
          echo $templates->render('tili_lisaa', ['formdata' => [], 'error' => []]);
          break;
        }
    default:
      echo $templates->render('notfound');
    }
    

  
       
     

?> 

