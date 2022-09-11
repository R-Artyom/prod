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
    if ($pageButtons['left2']['num'] <= 1) {
        $pageButtons['left2']['show'] = null;
    }
    if ($pageButtons['right2']['num'] >= $pageCount) {
        $pageButtons['right2']['show'] = null;
    }
    if ($pageCount == 1) {
        $pageButtons['active']['show'] = null;
    }
    if ($pageCount == 4) {
        $pageButtons['firstSep']['show'] = null;
        $pageButtons['lastSep']['show'] = null;
    }

    // Возврат массива
    return $pageButtons;
}