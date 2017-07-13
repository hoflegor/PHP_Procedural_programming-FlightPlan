<?php

require_once('includes/functions.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//Sprawdzanie lotnisk
    if (isset($_POST['departure']) === true
        &&
        $_POST['departure'] === ''
    ) {
        echo "<h2>Nie podano lotniska odlotu!!</h2>";
    }

    if (isset($_POST['arrival']) === true
        &&
        $_POST['arrival'] === ''
    ) {
        echo "<h2>Niepodano lotniska przylotu!!</h2>";
    }

    if (isset($_POST['departure']) === true
        &&
        isset($_POST['arrival']) === true
        &&
        ($_POST['arrival'] != $_POST['departure'])
    ) {
        $departure = $_POST['departure'];
        $arrival = $_POST['arrival'];
    } elseif ($_POST['departure'] != ''
        && $_POST['arrival'] != ''
    ) {
        echo
        "<h2>Lotniska wylotu i przylotu nie mogą być takie same!!</h2>";
    }
//sprawdznie daty
    if (isset($_POST['startTime']) === true
        &&
        $_POST['startTime'] === ''
    ) {
        echo "<h2>Nie podano daty lotu!!</h2>";
    } elseif (isset($_POST['startTime']) === true) {
        $startTime = $_POST['startTime'];
    }
//sprawdzanie czasu lotu

    if (isset($_POST['flightLength']) === true
        &&
        ($_POST['flightLength'] == ''
            ||
            $_POST['flightLength'] === '0')
    ) {
        echo "<h2>Nie podano czasu lotu!!";
    } elseif (isset($_POST['flightLength']) === true
        &&
        $_POST['flightLength'] > 0
    ) {
        $flightLength = $_POST['flightLength'];
    }

//sprawdzanie ceny
    if (isset($_POST['price']) === true
        &&
        $_POST['price'] > 0
    ) {
        $price = $_POST['price'];
    } else {
        echo "<h2>Nie podano ceny lotu!!!</h2>";
    }

}

///Wyświetlanie danych z formularza

if (isset($departure)
    &&
    isset($arrival)
    &&
    isset($startTime)
    &&
    isset($flightLength)
    &&
    isset($price)
){
    $depName = nameByCode($departure);

    $arName = nameByCode($arrival);

    $tzDep = tzByCode($departure);
    $depLocal = new DateTimeZone (tzByCode($departure));

    $tzAr = tzByCode($arrival);
    $arLocal = new DateTimeZone (tzByCode($arrival));

    $startDT = new DateTime($startTime);
    $startDT->setTimezone($depLocal);
    $startDate = $startDT->format('d.m.Y / G:i:s');
//    var_dump ($startDate) . "<br>";

    $endDT = $startDT->modify("+$flightLength hour");
    $endDT->setTimezone($arLocal);
    $endDate = $endDT->format('d.m.Y / G:i:s');
//    var_dump($endDate);
//TODO style do style.css
//    TODO echo tabeli, inna metoda
    echo "
    <link rel='stylesheet' href='css/style.css'>
    <table>
        <tr>
            <th scope='col' 
            colspan='2'><h1><ins><em>Bilet lotniczy</em></ins></h1></th>
        </tr>
        <tr>
            <th id='halfWidth' scope='col'><ins>Lotnisko wylotu<br>(kod 
            lotniska):</ins></th>
            <th id='halfWidth' scope='col'><ins>Lotnisko przylotu<br>(kod 
            lotniska):</ins></th>
        </tr>
        <tr>
            <td id='halfWidth'><h1><em>$depName<br>
            ($departure)</em></h1></td>         
            <td id='halfWidth'><h1><em>$arName<br>
            ($arrival)</h1></td>
        </tr>
        <tr>
            <th id='halfWidth' scope='col'><ins>Data / godzina wylotu<br>
            (czas lokalny):</ins></th>
            <th id='halfWidth' scope='col'><ins>Data / godzina przylotu<br>
            (czas lokalny):</ins></th>
        </tr>
        <tr>
<!--
//        TODO tz
-->
            <td id='halfWidth'>$startDate<br>($tzDep)</td>
            <td id='halfWidth'>$endDate<br>($tzAr)</td>
        </tr>
        <tr >
            <th scope='col' colspan='2'><ins>Czas lotu (w godzinach):<ins></ins></th>
        </tr>
        <tr>
            <td colspan='2'>$flightLength h</td>
        </tr>
        <tr>
            <th scope='col' colspan='2'><ins>Cena lotu (PLN):</ins></th>
        </tr>
        <tr>
            <td colspan='2'>$price PLN</td>
        </tr>
    </table>
    ";

}