<button class="openFormButton" id="userformbutton" onclick="openForm()">Du är inloggad som <?php echo $user;?></button>
<div class="form-popup" id="userform">
        <form action="logout.php" class="form-container">
            <h1>Du är inloggad som <?php echo $user;?></h1>

            <button type="submit" class="knapp">Logga ut!</button>
            <button type="button" class="knapp avbryt" onclick="closeForm()">Avbryt</button>
        </form>
</div>