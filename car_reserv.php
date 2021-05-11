<?php
    require ('includes/db.php');

    $data = $_POST;
    $car_id = $_GET['car'];

    $is_exists = R::find('cars', 'id = ?', array($car_id));
    $is_reserved = R::find('reserve', 'car_id = ?', array($car_id));

    if (isset($car_id) && $is_exists)
    {
        if (!$is_reserved)
        {
            if (isset($data['do_reserve']))
            {
                $date_from = substr($data['daterange'],0,10);
                $date_to = substr($data['daterange'],13,10);

                $reserve = R::dispense('reserve');
                $reserve->car_id = $car_id;
                $reserve->fullname = $data['full-name'];
                $reserve->phone_number = $data['phone-number'];
                $reserve->from = $date_from;
                $reserve->to = $date_to;
                R::store($reserve);
//                echo 'noice';
            }
        }
    }
    else
    {
        header('Location: /car_catalog.php');
    }
//echo $car_reserved ? 'flex' : 'none';

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
    <script>
        $(function() {
            let today = moment().format('MM/DD/YYYY');
            $('input[name="daterange"]').daterangepicker({
                minDate: moment(),
                "opens": "center",
                buttonClasses: "hide",
                locale: {
                    format: 'DD/MM/YYYY',
                    "applyLabel": "Принять",
                    "cancelLabel": "Отмена",
                    "fromLabel": "От",
                    "toLabel": "До",
                    "daysOfWeek": [
                        "Вс",
                        "Пн",
                        "Вт",
                        "Ср",
                        "Чт",
                        "Пт",
                        "Сб"
                    ],
                    "monthNames": [
                        "Январь",
                        "Февраль",
                        "Март",
                        "Апрель",
                        "Май",
                        "Июнь",
                        "Июль",
                        "Август",
                        "Сентябрь",
                        "Октябрь",
                        "Ноябрь",
                        "Декабрь"
                    ],
                    "firstDay": 1
                }
            });
        });
    </script>

    <title>Document</title>
</head>
<body style="display: flex; justify-content: center; margin: 0">
    <form action="car_reserv.php?car=<?echo $car_id?>" method="post" style="display: flex; align-items: center; flex-direction: column">
        <p>
            <label>Full name</label>
            <input type="text" class="text-only" name="full-name" required>
        </p>
        <p>
            <label>Phone number</label>
            <input type="text" class="numbers-only" name="phone-number" required>
        </p>
        <p>
            <label>Reserve date</label>
            <input type="text" name="daterange" readonly="readonly" required/>
        </p>
        <p>
            <button type="submit" name="do_reserve">Reserve</button>
        </p>
    </form>

    <div style="display: <? echo $is_reserved || isset($data['do_reserve']) ? 'flex' : 'none'; ?>; position: fixed; background-color: rgba(0,0,0,0.31); width: 100%; height: 100%; margin: 0; align-items: center; justify-content: center">
        <div style="display: <? echo $is_reserved || isset($data['do_reserve']) ? 'flex' : 'none'; ?>; flex-direction: column; width: 25%; height: 25%; background-color: white; border: black solid; position: fixed; justify-content: center; align-items: center">
            <?echo isset($data['do_reserve']) && !$is_reserved ? 'Ваша машина забронирована на '.substr($data['daterange'],0,10) : 'Машину уже забронировали'; ?>
            <a href="car_catalog.php">Вернуться в каталог</a>
        </div>
    </div>


    <script src="scripts/main.js"></script>
</body>
</html>