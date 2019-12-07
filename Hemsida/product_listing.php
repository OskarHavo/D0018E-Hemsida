<div class="product_listing" >

    <div id="imagecontainer"><img src="Bilder/<?php echo $productnumber; ?>.png" style="max-height:100%; max-height:100%"></div>
    <div id="productlink" ><a href="Productpage.php?ProductNumber=<?php echo $productnumber; ?>" style="font-size: 2em;"><?php echo $name;?></a><p>Artikelnummer: <?php echo $productnumber;?></p></div>
    <div id="buy_me">

        <?php include($_SERVER['DOCUMENT_ROOT']."/buy_product.php");?>

    </div>
</div>
<!-- Fixa till min CSS tack! -->
