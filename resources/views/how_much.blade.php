@extends('layouts.app')
@section('title','Доколе?')
@section('content')
    <div>
        <?php
        $dateOfDeparture = new DateTime();
        $dateOfDeparture->setDate(2018, 11, 20);
        $dateOfDeparture->setTimezone(new DateTimeZone('Europe/Kiev'));
        $dateOfDeparture->add(new DateInterval('P90D'));
        echo $dateOfDeparture->format('d-m-Y') . "\n";

        $departTimestamp = $dateOfDeparture->getTimestamp();
        $nowTimestamp = time();
        $daysToDepart = ($departTimestamp - $nowTimestamp) / (3600 * 24);
        ?>
        <br>
        <h4>До максимального отъезда осталось:
            <?= $daysToDepart;?> дней, но по факту:
            <?=(int)((strtotime('8 February 2019') - $nowTimestamp) / (3600 * 24));?>
            дней</h4>
    </div>
@endsection
