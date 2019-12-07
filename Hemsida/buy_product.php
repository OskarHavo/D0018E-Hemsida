<p id="out_of_order" <?php if ($instock > 0) {echo "hidden";}?>>Slut i lager</p>

<button class= "buyButton liteknapp" type="submit" form="amountForm<?php echo $productnumber; ?>" <?php if ($instock == 0) {echo "hidden";}?>><?php
    if ($instock > 0) {
        echo "Köp";
    } else {
        echo "Slut i lager";
    }
    ?></button>
<div id ="listingAmountDiv" class ="selectAmountdiv" <?php if ($instock == 0) {echo "hidden";}?>>
    <form class="amountform" id="amountForm<?php echo $productnumber; ?>" action="buy.php" class="form-container" method="post">
        <label for="antal"><b>Antal</b></label>
        <input type="number" value="1" name="quantity" max="<?php echo $instock;?>" min="1">
        <input type="hidden" value="<?php echo $productnumber; ?>" name="ProductNumber">
    </form>

</div>
