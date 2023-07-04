<?php

if (isset($_GET['select'])) {
    echo 'the selected value is: '. $_GET['select'];
} else {
    echo 'No value selected. Please select';
}