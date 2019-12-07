<div class="product_listing" >

    <div style="height: 100%; width: 20%;"><img src="Bilder/<?php echo $productnumber; ?>.png" style="max-height:100%; max-height:100%"></div>
    <div style=" width:100%" ><a href="Productpage.php?ProductNumber=<?php echo $productnumber; ?>" style="font-size: 2em;"><?php echo $name;?></a><p>Artikelnummer: <?php echo $productnumber;?></p></div>
    <div>

        <button class= "buyButton liteknapp" type="submit" form="amountForm"><?php
            if ($instock > 0) {
                echo "Köp";
            } else {
                echo "Slut i lager";
            }
            ?></button>
        <div id ="listingAmountDiv"class ="selectAmountdiv" <?php if ($instock == 0) {echo "hidden";}?>>
            <form class="amountform" id="amountForm" action="<?php
                                                             if ($instock > 0) {
                                                                 echo "buy.php";
                                                             } else {
                                                                 echo "#";
                                                             }
                                                             ?>"
                  class="form-container" method="post">
                <label for="antal"><b>Antal</b></label>
                <input type="number" value="1" name="quantity" max="<?php echo $instock;?>" min="1">
                <input type="hidden" value="<?php echo $productnumber; ?>" name="ProductNumber">
            </form>

        </div>

    </div>
</div>
