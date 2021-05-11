<p style="display: <? echo $is_reserved || isset($data['do_reserve']) ? 'flex' : 'none'; ?>; position: fixed; background-color: rgba(0,0,0,0.31); width: 100%; height: 100%; margin: 0">
<p style="display: <? echo $is_reserved || isset($data['do_reserve']) ? 'flex' : 'none'; ?>; flex-direction: column; width: 25%; height: 25%; background-color: white; border: black solid; position: fixed; justify-content: center; align-items: center">
    <?echo isset($data['do_reserve']) ? 'Ваша машина забронирована на '.substr($data['daterange'],0,10) : 'Машину уже забронировали'; ?>
    <a href="car_catalog.php">Вернуться в каталог</a>
</p>
</p>