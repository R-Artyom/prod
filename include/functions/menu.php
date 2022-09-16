<?php
/**
* Функция ищет заголовок текущей страницы в массиве с описанием пунктов меню
* @param array $array - входной массив с описанием пунктов меню
* @return string возвращает заголовок страницы (строку)
*/
function findTitle(array $array): string
{
    // Цикл по всем пунктам меню массива
    foreach ($array as $value) {
        // Если страница найдена (находимся в разделе)
        if (isCurrentUrl($value['path'])) {
            // Возвращаем заголовок страницы
            return $value['title'];
        // Проверка вложенных каталогов первого уровня
        } else if (isset($value['pathLevel1'])) {
            foreach ($value['pathLevel1'] as $value1) {
                if (isCurrentUrl($value['path'] . $value1)) {
                    return $value['title'];
                // Проверка вложенных каталогов второго уровня
                } else if (isset($value['pathLevel2'])) {
                    foreach ($value['pathLevel2'] as $value2) {
                        if (isCurrentUrl($value['path'] . $value1 . $value2)) {
                            return $value['title'];
                        }
                    }
                }
            }
        }
    }
    // Если страница не найдена, то возвращаем ошибку
    return 'Страница не найдена';
}

/**
 * Функция поиска активной (текущей) страницы
 * @param array $array - входной массив с описанием пунктов меню
 * @return string возвращает url активной страницы (строку)
 */
function findUrlActive(array $array): string
{
    // Цикл по всем пунктам меню массива
    foreach ($array as $value) {
        // Если url страницы один в один совпадает
        if (isCurrentUrl($value['path'])) {
            return $value['path'];
        // Если совпадает только корневой каталог, но не "Главный"(/)
        } else if (strpos($_SERVER["REQUEST_URI"], $value['path']) === 0 && $value['path'] != PATH_MAIN) {
            return $value['path'];
        }
    }
    // Если не попал ни под один критерий - то это главная страница
    return PATH_MAIN;
}

/**
 * Функция определения активности текущей страницы
 * @param $path - ссылка на страницу, куда ведет пункт меню, которую необходимо проверить
 * @return bool возвращает результат проверки (true / false)
 */
function isCurrentUrl($path): bool
{
    // Возврат результата сравнения
    return $path === parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
}