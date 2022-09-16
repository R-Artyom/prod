/**
 * Настройка по умолчанию плагина blockUI
 */
// Настройка сообщения blockUI
$.blockUI.defaults.message = "Пожалуйста, подождите…";
// Настройка цвета фона страницы blockUI
$.blockUI.defaults.overlayCSS.backgroundColor = '#787B7F';
// Настройка цвета фона окна blockUI
$.blockUI.defaults.css.backgroundColor = '#787B7F';
// Настройка цвета шрифта blockUI
$.blockUI.defaults.css.color = '#FFF';
// Использовать блокирование пользовательского интерфейса для всех запросов ajax:
$(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);