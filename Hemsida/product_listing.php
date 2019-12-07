<div class="product_listing" >

    <div style="height: 100%; width: 20%;"><img src="Bilder/<?php echo $productnumber; ?>.png" style="max-height:100%; max-height:100%"></div>
    <div style=" width:100%" ><a href="Productpage.php?ProductNumber=<?php echo $productnumber; ?>" style="font-size: 2em;"><?php echo $name;?></a><p>Artikelnummer: <?php echo $productnumber;?></p></div>
    <div style="background-color:#bd0b0b; min-width:30%">

        <?php include($_SERVER['DOCUMENT_ROOT']."/buy_product.php");?>

    </div>
</div>
<!-- Fixa till min CSS tack! -->
