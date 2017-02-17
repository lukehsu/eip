<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
    <h2>GP業績</h2>
    <img src="<?php echo $message->embed($GP); ?>">
    .<br>
    .<br>
    .<br>
    <h2>HP業績</h2>
	<img src="<?php echo $message->embed($HP); ?>">
    .<br>
    .<br>
    .<br>
    <h2>聯邦業績</h2>
	<img src="<?php echo $message->embed($uni); ?>">
    .<br>
    .<br>
    .<br>
    <h2>保健業績</h2>
	<img src="<?php echo $message->embed($heal); ?>">
    </body>
</html>