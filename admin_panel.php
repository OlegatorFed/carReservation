<?php
    require ('includes/db.php');

    if (!isset($_SESSION['logged_user']))
    {
        header('Location: /');
    }
    else
    {
        echo $_SESSION['logged_user'];
    }

    $data = $_POST;
    if (isset($data['do_reg']))
    {
        $car = R::dispense('cars');
        $car->car_name = $data['car_name'];
        $car->manufacture_year = $data['year'];
        $car->deposit = $data['deposit'];
        $car->price = $data['price'];
        $car->auto_trans = $data['auto_trans'];
        $car->seats = $data['seats'];
        $car->gas_use = $data['gas_use'];
        $car->trunk = $data['trunk'];
        $car->power = $data['power'];
        $car->drive = $data['drive'];
        $car->steer = $data['steer'];
        $car->status = 0;
        R::store($car);
        echo '<p>Car registered</p>';
    }

    if (isset($_POST['status']))
    {
        $new_status = R::load('cars', $_POST['id']);
        $new_status->status = $_POST['status'];
        R::store($new_status);
    }


    $cars = R::find('cars');

    $reserve = R::find('reserve');

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script type="text/javascript" src="scripts/datarangepicker.js"></script>
    <script>
        $(function() {
            <?
                foreach ($reserve as $item)
                {
                    echo 'makeCalenar("daterange'. $item->car_id .'", "'. $item->from .'", "'. $item->to .'");';
                }
            ?>
        });
    </script>

    <style>
        .available {
            cursor: default !important;
            pointer-events: none !important;
        }
        .today {
            background-color: burlywood !important;
            color: white !important;
        }
        .disabled {
            text-decoration: none !important;
        }
    </style>

    <title>Admin Panel</title>
</head>
<body style="display: flex; flex-direction: column">
    <a href="logout.php">Log out</a>
    <form action="admin_panel.php" method="post">
        <div>
            <p>Car name</p>
            <input type="text" name="car_name" required>
        </div>
        <div>
            <p>Manufacture year</p>
            <input type="text" class="numbers-only" name="year" required>
        </div>
        <div>
            <p>Deposit</p>
            <input type="text" class="numbers-only" name="deposit" required>
            ₽
        </div>
        <div>
            <p>Price a day</p>
            <input type="text" class="numbers-only" name="price" required>
            ₽
        </div>
        <hr>
        <p><strong>Stats</strong></p>
        <div>
            <p>Auto transmission</p>
            <input type="checkbox" name="auto_trans">
        </div>
        <div>
            <p>Number of seats</p>
            <input type="text" class="numbers-only" name="seats" required>
        </div>
        <div>
            <p>Gas usage a 100 km</p>
            <input type="text" class="numbers-only" name="gas_use" required> l.
        </div>
        <div>
            <p>Trunk volume</p>
            <input type="text" class="numbers-only" name="trunk" required> l.
        </div>
        <div>
            <p>Power</p>
            <input type="text" class="numbers-only" name="power" required> h. p.
        </div>
        <div>
            <p>Drive unit</p>
            <select name="drive">
                <option>Back</option>
                <option>Forward</option>
                <option>Both</option>
            </select>
        </div>
        <div>
        <p>Steering wheel</p>
            <select name="steer">
                <option>Right</option>
                <option>Left</option>
            </select>
        </div>
        <p><button type="submit" name="do_reg">Register car</button></p>
    </form>
    <hr width="100%" size="5px" color="black">

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
                $free = $status == 0 ? 'selected' : '';
                $reserved = $status == 1 ? 'selected' : '';
                $taken = $status == 2 ? 'selected' : '';

                $is_reserved = R::find('reserve', 'car_id = ?', array($item->id));
                $calendar = $is_reserved ? '<input type="text" name="daterange'. $item->id .'" readonly="readonly" required/>' : '';

                echo '<div style="display: flex; flex-direction: row">
                        <div style="margin: 10px; background-color: bisque">Name: '. $item->car_name .'</div>
                        <div style="margin: 10px; background-color: bisque">Year: '. $item->manufacture_year .'</div>
                        <div style="margin: 10px; background-color: bisque">Deposit: '. $item->deposit .' ₽</div>
                        <div style="margin: 10px; background-color: bisque">Price a day: '. $item->price .' ₽</div>
                        <div style="margin: 10px; background-color: bisque">Auto transmission: '. $on .'</div>
                        <div style="margin: 10px; background-color: bisque">Seat count: '. $item->seats .'</div>
                        <div style="margin: 10px; background-color: bisque">Gas usage: '. $item->gas_use .' l./100km</div>
                        <div style="margin: 10px; background-color: bisque">Trunk volume: '. $item->trunk .' l.</div>
                        <div style="margin: 10px; background-color: bisque">Power: '. $item->power .' h. p.</div>
                        <div style="margin: 10px; background-color: bisque">Drive unit: '. $item->drive .'</div>
                        <div style="margin: 10px; background-color: bisque">Steering wheel: '. $item->steer .'</div>
                        <div style="margin: 10px; background-color: bisque">
                            <select class="status" onchange="getStatus(this, '. $item->id .');">
                                <option '. $free .'>Free</option>
                                <option '. $reserved .'>Reserved</option>
                                <option '. $taken .'>Taken</option>
                            </select>
                        </div>
                        '. $calendar .'
                     </div>
                     <hr style="color: cornflowerblue; width: 100%">
                ';
            }
        }
    ?>

    <script src="scripts/main.js"></script>
</body>
</html>
