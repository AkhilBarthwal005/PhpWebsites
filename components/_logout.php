<?php

    session_start();
    echo "You are logging out wait for some movement";
    session_unset();
    session_destroy();
    header("Location: /?logoutsuccess=true");

?>