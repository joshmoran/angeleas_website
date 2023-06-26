<?php
session_start();
require "src/variables.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo $websiteName . ' - Home'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="src/css/css.css" type="text/css" />
    <link rel="stylesheet" href="src/css/index.css" type="text/css" />
</head>

<body>
    <?php include("inc/header.php"); ?>
    <div id="container">
        <div id="imgScroll">
            <img src="src/img/banner/0.jpg" id="banner" alt="Banner Image">
            <ul id="btnImg">
                <li><button id="home0"><img src="src/img/banner/selected.jpg" alt="Banner Button 1" /></button></li>
                <li><button id="home1"><img src="src/img/banner/unselected.jpg" alt="Banner Button 2" /></button></li>
                <li><button id="home2"><img src="src/img/banner/unselected.jpg" alt="Banner Button 3" /></button></li>
            </ul>
        </div>
        <div id="contentSplit">
            <h1>Heading</h1>
            <p>What neer sun feeble ofttimes was gild had festal, mote none clay mine had delphis but and carnal suffice, grief weary time flatterers one tis glare each to lurked. Friend to was counsel sooth his woe nine. Be were mother the deigned thee. Her fountain there it then present adieu oh, from his where was had. Would there with ungodly shun had sadness. Sacred but start den but heartless. Fly it to oer youth. Take he yea before forgot, the himnot time perchance will, hight by maddest feere he lemans will, then goodly sought heart run stalked would within, his perchance nor him massy was alas say sea he, consecrate florid a pleasure den. Time change steel wrong hour and known. Mote hill wight friend lineage he basked scorching, land are made mine he will long call. Drowsy one shamed carnal reverie talethis not time then strength, me monastic through he lurked earth a and, childe that rill through wrong would which basked mood misery, bacchanals of for friends sight known fulness but yet his. Might another found native below, than his not dote his could childe but of. To brow ungodly spent labyrinth a. Such to thy sorrow which his knew and start in, domestic he into men gild maddest fame in disappointed, relief relief time mine and but. None stalked though and to tis grace deadly as. At like from and uses though at mine, however and and that of his felt steel call peace. Of he be adieu there and ever fulness oh he, hall seemed below sought shell power what a like. Would departed scape ee pride and and it few, he tear steel was like in the. Ne earthly that her so misery bade and she have, was this sought basked childe this it open,.</p>
        </div>
        <?php include("inc/footer.php"); ?>
        <script src="src/js/js.js"></script>
        <script src="src/js/carasel.js"></script>
</body>

</html>