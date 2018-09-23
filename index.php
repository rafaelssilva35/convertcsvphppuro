<?php
include_once('./html_includs/header.php');
if (!empty($_GET['erro'])) {
    ?>
    <br>
    <div class="container">
        <div class="alert alert-warning">
            <strong>Ops !</strong> <?=$_GET['erro']?>
            <button type="button" class="close" onclick="fecha('.alert')">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    <?php
}
?>
<div class="jumbotron">
    <div class="container">
       <h4>Selecione um arquivo no formato csv</h4>
    </div>
    <div class="container">
        <form method="post" action="phpclass/documents/documento.php" enctype="multipart/form-data">
            <input type="file" name="csv">
            <button class="btn btn-primary" type="submit">Enviar</button>
        </form>
    </div>
</div>

<script src="./assets/js/jquery.js"> </script>

<script>
    function fecha(element)
    {
        $(element).addClass('hide');
    }
</script>
<?php
include_once('./html_includs/footer.php');
?>
