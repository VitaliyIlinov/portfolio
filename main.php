<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Portfolio</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <form action="index.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="photo">File input:</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
            <input type="file" name="photo[]" id="photo" multiple>
            <p class="help-block">Please download your pictures(jpg, png, gif).Max size 3mb,max picture-7</p>
        </div>
        <button type="submit" name="submit" class="btn btn-default">Submit</button>
    </form>
        <div><?=$file_was_send ? 'yes' : 'no' ?></div>
        <div>Quantity:<?=$count_result?></div>
        <?php if($count_result) : ?>
            <?php for($i=0;$i<$count_result;$i++): ?>
                <img src="<?=FOLDER_IMAGE.DIRECTORY_SEPARATOR.$result[$i]['md5']; ?>" title="<?='Name: '.$result[$i]['original'].';  Date: '.$result[$i]['date']  ?>" width="30%" height="350px">
            <?php endfor; ?>
        <?php endif;?>
</div>
</body>
</html>