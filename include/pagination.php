<?php
/**
 * Функция формирования массива, необходимого для постраничной навигации
 * @param $pageActive - номер текущей страницы
 * @param $pageCount - номер последней страницы (количество страниц)
 * @return array - результирующий массив
 */
function getPageButtons($pageActive, $pageCount): array
{
    // Массив "Кнопки страниц"
    $pageButtons = [
        // Кнопка "Предыдущая (<)"
        'previous' => [
            'show' => true,
            'num' => null,
            'text' => '<',
            'class' => 'paginator__flip',
            'active' => null,
        ],
        // Кнопка "Первая страница (1)"
        'first' => [
            'show' => true,
            'num' => 1,
            'text' => '1',
            'class' => 'paginator__item',
            'active' => null,
        ],
        // Кнопка "Левый разделитель (...)"
        'firstSep' => [
            'show' => true,
            'num' => null,
            'text' => '...',
            'class' => 'paginator__sep',
            'active' => null,
        ],
        'left2' => [
            'show' => null,
            'num' => null,
            'text' => null,
            'class' => 'paginator__item',
            'active' => null,
        ],
        'left1' => [
            'show' => true,
            'num' => null,
            'text' => null,
            'class' => 'paginator__item',
            'active' => null,
        ],
        // Кнопка "Текущая страница"
        'active' => [
            'show' => true,
            'num' => $pageActive,
            'text' => $pageActive,
            'class' => 'paginator__item',
            'active' => null,
        ],
        'right1' => [
            'show' => true,
            'num' => null,
            'text' => null,
            'class' => 'paginator__item',
            'active' => null,
        ],
        'right2' => [
            'show' => null,
            'num' => null,
            'text' => null,
            'class' => 'paginator__item',
            'active' => null,
        ],
        // Кнопка "Правый разделитель (...)"
        'lastSep' => [
            'show' => true,
            'num' => null,
            'text' => '...',
            'class' => 'paginator__sep',
            'active' => null,
        ],
        // Кнопка "Последняя страница"
        'last' => [
            'show' => true,
            'num' => $pageCount,
            'text' => $pageCount,
            'class' => 'paginator__item',
            'active' => null,
        ],
        // Кнопка "Следующая страница (>)"
        'next' => [
            'show' => true,
            'num' => null,
            'text' => '>',
            'class' => 'paginator__flip',
            'active' => null,
        ],
    ];

    // Формирование номера необходимых кнопок страниц
    $pageButtons['previous']['num'] = $pageActive - 1;
    $pageButtons['left2']['num'] = $pageActive - 2;
    $pageButtons['left1']['num'] = $pageActive - 1;
    $pageButtons['right1']['num'] = $pageActive + 1;
    $pageButtons['right2']['num'] = $pageActive + 2;
    $pageButtons['next']['num'] = $pageActive + 1;

    // Формирование текста необходимых кнопок страниц
    $pageButtons['left2']['text'] = $pageButtons['left2']['num'];
    $pageButtons['left1']['text'] = $pageButtons['left1']['num'];
    $pageButtons['right1']['text'] = $pageButtons['right1']['num'];
    $pageButtons['right2']['text'] = $pageButtons['right2']['num'];

    // Формирование признака "Показывать кнопку страницы"
    // Левая часть кнопок
    if ($pageButtons['left1']['num'] < 1) {
        $pageButtons['left1']['show'] = null;
        $pageButtons['right2']['show'] = true;
    }
    if ($pageButtons['active']['num'] == 1) {
        $pageButtons['previous']['show'] = null;
        $pageButtons['firstSep']['show'] = null;
        $pageButtons['first']['show'] = null;
    }
    if ($pageButtons['active']['num'] == 2) {
        $pageButtons['first']['show'] = null;
        $pageButtons['firstSep']['show'] = null;
    }
    if ($pageButtons['active']['num'] == 3) {
        $pageButtons['firstSep']['show'] = null;
    }
    // Правая часть кнопок (аналогична левой)
    if ($pageButtons['right1']['num'] > $pageCount) {
        $pageButtons['right1']['show'] = null;
        $pageButtons['left2']['show'] = true;
    }
    if ($pageButtons['active']['num'] == $pageCount) {
        $pageButtons['lastSep']['show'] = null;
        $pageButtons['next']['show'] = null;
        $pageButtons['last']['show'] = null;
    }
    if ($pageButtons['active']['num'] >= $pageCount - 1) {
        $pageButtons['lastSep']['show'] = null;
        $pageButtons['last']['show'] = null;
    }
    if ($pageButtons['active']['num'] >= $pageCount - 2) {
        $pageButtons['lastSep']['show'] = null;
    }
    // Проверка граничных значений вторых кнопок
    if ($pageButtons['left2']['num'] < 1) {
        $pageButtons['left2']['show'] = null;
    }
    if ($pageButtons['right2']['num'] > $pageCount) {
        $pageButtons['right2']['show'] = null;
    }
    if ($pageCount == 1) {
        $pageButtons['active']['show'] = null;
    }

    // Возврат массива
    return $pageButtons;
}

/**
 * Функция формирования фразы "Найдено х моделей"
 * @param $number - число "x"
 * @return string - результирующая фраза
 */
function getPhraseCountModels($number): string
{
    // Остатка от деления на 100 хватит, чтобы создать правильное окончание слова,
    // но остатки 11,12,13,14,15,16,17,18,19 выбиваются из общей картины,
    // поэтому для чисел с остатком 0..19 необходимо проверять остаток от деления на 100,
    // а для всех остальных - остаток от деления на 10.
    if ($number % 100 < 20) {
        $balance = $number % 100;
    }
    else {
        $balance = $number % 10;
    }
    //1,21,31,41,51,61,71,81,91
    if ($balance == 1) {
        return "Найдена $number модель";
        //2,22,32,42,52,62,72,82,92
        //3,23,33,43,53,63,73,83,93
        //4,24,34,44,54,64,74,84,94
    } elseif (($balance == 2) || ($balance == 3) || ($balance == 4)) {
        return "Найдены $number модели";
        //11,12,13,14,
        //5,15,25,35,45,55,65,75,85,95
        //6,16,26,36,46,56,66,76,86,96
        //7,17,27,37,47,57,67,77,87,97
        //8,18,28,38,48,58,68,78,88,98
        //9,19,29,39,49,59,69,79,89,99
        //0,10,20,30,40,50,60,70,80,90
    } else {
        return "Найдено $number моделей";
    }
}