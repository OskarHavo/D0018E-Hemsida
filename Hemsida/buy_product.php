<button class= "buyButton liteknapp" type="submit" form="amountForm"><?php
    if ($instock > 0) {
        echo "Köp";
    } else {
        echo "Slut i lager";
    }
                            ?></button>
                        <div class ="selectAmountdiv" <?php if ($instock == 0) {echo "hidden";}?>>
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
