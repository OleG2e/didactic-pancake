@extends('layouts.app')
@section('title', 'Автобусное расписание')
@section('content')
    @component('components.hero')
        {{ Breadcrumbs::render('bus.schedule') }}
        <div class="box">
            @if (session('message'))
                @component('components.flash-message', ['type'=>'is-success'])
                    {{ session('message') }}
                @endcomponent
            @endif
            <h4 class="title is-size-4">Расписание движения автобусов Сыктывкар - Микунь</h4>
            <div class="table-container">
                <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                    <thead>
                    <tr>
                        <th>Дни отправления</th>
                        <th>Отправление из Сыктывкара</th>
                        <th>Прибытие в Микунь</th>
                        <th>Отправление из Микуни</th>
                        <th>Прибытие в Сыктывкар</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Дни отправления</th>
                        <th>Отправление из Сыктывкара</th>
                        <th>Прибытие в Микунь</th>
                        <th>Отправление из Микуни</th>
                        <th>Прибытие в Сыктывкар</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <tr>
                        <td>По средам</td>
                        <td>4:00</td>
                        <td>6:05</td>
                        <td>6:15</td>
                        <td>8:30</td>
                    </tr>
                    <tr>
                        <td>Ежедневно</td>
                        <td>4:45</td>
                        <td>6:50</td>
                        <td>7:20</td>
                        <td>9:40</td>
                    </tr>
                    <tr>
                        <td>Ежедневно</td>
                        <td>5:25</td>
                        <td>7:45</td>
                        <td>8:35</td>
                        <td>10:55</td>
                    </tr>
                    <tr>
                        <td>Ежедневно</td>
                        <td>7:00</td>
                        <td>9:20</td>
                        <td>10:10</td>
                        <td>12:30</td>
                    </tr>
                    <tr>
                        <td>Ежедневно</td>
                        <td>8:30</td>
                        <td>10:50</td>
                        <td>11:30</td>
                        <td>13:50</td>
                    </tr>
                    <tr>
                        <td>Ежедневно</td>
                        <td>9:25</td>
                        <td>11:45</td>
                        <td>12:35</td>
                        <td>14:45</td>
                    </tr>
                    <tr>
                        <td>Ежедневно</td>
                        <td>10:25</td>
                        <td>12:50</td>
                        <td>13:30</td>
                        <td>15:50</td>
                    </tr>
                    <tr>
                        <td>Ежедневно</td>
                        <td>11:30</td>
                        <td>13:50</td>
                        <td>15:10</td>
                        <td>17:30</td>
                    </tr>
                    <tr>
                        <td>Ежедневно</td>
                        <td>12:30</td>
                        <td>15:00</td>
                        <td>15:50</td>
                        <td>18:10</td>
                    </tr>
                    <tr>
                        <td>Ежедневно</td>
                        <td>14:05</td>
                        <td>16:25</td>
                        <td>17:00</td>
                        <td>19:20</td>
                    </tr>
                    <tr>
                        <td>Ежедневно</td>
                        <td>15:15</td>
                        <td>17:35</td>
                        <td>18:20</td>
                        <td>20:40</td>
                    </tr>
                    <tr>
                        <td>Ежедневно</td>
                        <td>16:30</td>
                        <td>18:50</td>
                        <td>19:25</td>
                        <td>21:45</td>
                    </tr>
                    <tr>
                        <td>Ежедневно</td>
                        <td>17:30</td>
                        <td>19:50</td>
                        <td>20:50</td>
                        <td>23:10</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <h4 class="title is-size-4">Расписание движения автобусов по Усть-Вымскому р-ну с 1 мая по 30 сентября 2019
                года</h4>
            <div class="table-container">
                <table class="table is-bordered is-narrow is-hoverable is-fullwidth">
                    <thead>
                    <tr>
                        <th>№ маршрута</th>
                        <th>Наименование маршрута</th>
                        <th>Дни отправления</th>
                        <th>Отправление с начального пункта</th>
                        <th>Отправление из промежуточного пункта</th>
                        <th>Отправление с конечного пункта</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>№ маршрута</th>
                        <th>Наименование маршрута</th>
                        <th>Дни отправления</th>
                        <th>Отправление с начального пункта</th>
                        <th>Отправление из промежуточного пункта</th>
                        <th>Отправление с конечного пункта</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <tr>
                        <th rowspan="2" style="text-align:center;vertical-align: middle;">151</th>
                        <td>Микунь - Айкино - Илья&nbsp;-&nbsp;шор</td>
                        <td>Будни
                            <hr>
                            Выходные дни
                        </td>
                        <td>из Микуни - 7:20, 8:20, 8:40, 9:30, 10:30, 11:30, 13:00, 15:00, 17:00, 18:40
                            <hr>
                            из Микуни - 8:20, 9:30, 15:00, 18:40
                        </td>
                        <td>в Илья&nbsp;-&nbsp;шор - 11:00, 15:30, 17:30, из Илья&nbsp;-&nbsp;шора - 7:20, 11:30, 15:55
                            <hr>
                            в Илья&nbsp;-&nbsp;шор - 15:30<br>из Илья&nbsp;-&nbsp;шора - 7:20, 15:55
                        </td>
                        <td>из Айкино - 6:45, 7:45, 8:00, 8:50, 9:20, 11:00, 12:00, 14:00, 16:20, 18:10
                            <hr>
                            из Айкино - 7:45, 8:50, 14:00, 18:10
                        </td>
                    </tr>
                    <tr>
                        <td>Жешарт - Микунь (прямые рейсы)</td>
                        <td>Будни
                            <hr>
                            Выходные дни
                        </td>
                        <td>6:00, 7:00 (заезд в Арабач), 10:10, 13:00, 15:30, 17:20 (заезд в Арабач)
                            <hr>
                            13:00, 17:20 (заезд в Арабач)
                        </td>
                        <td></td>
                        <td>9:30, 11:30, 13:00, 17:00, 18:40
                            <hr>
                            9:30, 18:40
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:center;vertical-align: middle;">162</th>
                        <td>Жешарт - Айкино</td>
                        <td>Будни
                            <hr>
                            Выходные дни
                        </td>
                        <td>6:00, 6:30 (через Илья&nbsp;-&nbsp;шор), 7:00 (заезд в Арабач), 8:00, 10:10, 13:00, 15:30,
                            17:20
                            (заезд в Арабач)
                            <hr>
                            6:30 (через Илья&nbsp;-&nbsp;шор), 8:00, 13:00, 17:20 (заезд в Арабач)
                        </td>
                        <td>17:50 (из Илья&nbsp;-&nbsp;шора в Жешарт)</td>
                        <td>7:45, 8:50, 10:00, 12:00 (заезд в Арабач), 13:30, 16:20, 17:30 (через Илья&nbsp;-&nbsp;шор с
                            заездом в Арабач), 19:30
                            <hr>
                            8:50, 10:00, 16:20, 19:30 (с заездом в Арабач)
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:center;vertical-align: middle;">164</th>
                        <td>Жешарт - Межег - Казлук</td>
                        <td>Будни
                            <hr>
                            Выходные дни
                        </td>
                        <td>6:20, 10:00, 13:35, 17:20
                            <hr>
                            10:00, 13:35, 17:20
                        </td>
                        <td>из Казлука - 7:10, 10:55, 14:30, 18:05
                            <hr>
                            из Казлука - 10:55, 14:30, 18:05
                        </td>
                        <td>из Межега - 7:25, 11:10, 14:50, 18:20
                            <hr>
                            из Межега - 11:10, 14:50, 18:20
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:center;vertical-align: middle;">61</th>
                        <td>Жешарт - Лесобаза</td>
                        <td>Ежедневно</td>
                        <td>7:00, 8:00, 8:45, 10:30, 11:15, 12:00, 14:30, 15:15, 16:30, 17:15, 18:40, 19:20</td>
                        <td></td>
                        <td>7:20, 8:20, 9:05, 10:50, 11:35, 12:20, 14:50, 15:35, 16:50, 17:35, 19:00, 19:40</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <a class="button is-info is-hovered" href="{{back()->getTargetUrl()}}">Назад</a>
    @endcomponent
@endsection