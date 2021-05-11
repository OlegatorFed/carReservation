<?php
    require ('includes/db.php');

    $cars = R::find('cars');

    $reserves = R::find('reserve');
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="shortcut icon" href="#">

    <title>Document</title>
</head>
<body>
    <?php

        if(!count($cars))
        {
            echo 'No cars';
        }
        else
        {
            foreach ($cars as $item)
            {
                $on = $item->auto_trans == 'on' ? 'v' : 'x';

                $status = $item->status;
                $status_color = $status == 0 ? 'green' : 'red';
                $status_reserve = $status == 0 ? 'Reserve' : 'Taken';
                $status_href = $status == 0 ? 'href="/car_reserv.php?car='. $item->id .'"': '';

                echo '<form style="display: flex; flex-direction: column">
                            <div style="display: flex; flex-direction: row">
                                <div style="margin: 5px; background-color: bisque">Name: '. $item->car_name .'</div>
                                <div style="margin: 5px; background-color: bisque">Year: '. $item->manufacture_year .'</div>
                                <div style="margin: 5px; background-color: bisque">Deposit: '. $item->deposit .' ₽</div>
                                <div style="margin: 5px; background-color: bisque">Price a day: '. $item->price .' ₽</div>
                                <div style="margin: 5px; background-color: bisque">Auto transmission: '. $on .'</div>
                                <div style="margin: 5px; background-color: bisque">Seat count: '. $item->seats .'</div>
                                <div style="margin: 5px; background-color: bisque">Gas usage: '. $item->gas_use .' l./100km</div>
                                <div style="margin: 5px; background-color: bisque">Trunk volume: '. $item->trunk .' l.</div>
                                <div style="margin: 5px; background-color: bisque">Power: '. $item->power .' h. p.</div>
                                <div style="margin: 5px; background-color: bisque">Drive unit: '. $item->drive .'</div>
                                <div style="margin: 5px; background-color: bisque">Steering wheel: '. $item->steer .'</div>
                                <div style="margin: 5px; background-color: bisque">Steering wheel: '. $item->steer .'</div>
                            </div>
                            <div>
                                <a style="color: white; background-color: '. $status_color .'" '. $status_href .'>'. $status_reserve .'</a>
                            </div>
                        </form>
                   <hr style="color: cornflowerblue; width: 100%">
                ';
            }
        }
    ?>

    <script src="scripts/main.js"></script>
</body>
</html>
