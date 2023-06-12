<?php

        try {
            //session_destroy();
            session_start();
            session_destroy();
            header('Location: index.php');
            
        } catch (Exception $e) {
        }
        //header("Location: index.php");
