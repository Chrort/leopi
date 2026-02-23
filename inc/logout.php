<?php

//zurücksetzen und zerstören der Session -> dann weiterleitung an die Hauptseite

session_start();
session_unset();
session_destroy();

header("Location: /leopi/index.php?logoutSucces");
