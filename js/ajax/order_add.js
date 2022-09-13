/**
 * Обработка формы отправки заказа
 */
// Ожидание загрузки всего документа, после чего будет выполнена анонимная функция
$(function(){
    // Выбор элемента "Форма"
    const formOrderAdd = $('.custom-form.js-order');
    // Выбор элемента "Всплывающее окно"
    const popUpSuccess = $('.shop-page__popup-end');
    // Выбор элемента "Текст сообщения"
    const message = $('#result');
    // Выбор класса "Страница оформления заказа"
    const shopPageOrder = $('.shop-page__order');

    // Обработчик события "Отправка формы по нажатию кнопки "Отправить заказ"
    formOrderAdd.submit(function() {
        $.ajax({
            method: 'POST',
            url: '/content/ajax/order_add.php',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: new FormData(this),
            success: function(dataJson) {
                // Если данные из формы записались в базу успешно
                if (dataJson === true) {
                    // Скрытие формы и отображение всплывающего окна
                    shopPageOrder.attr('hidden','hidden');
                    popUpSuccess.removeAttr('hidden');
                }
                else {
                    message.html(dataJson);
                }
            },
            error: function() {
                // Вывод сообщения
                message.html('Ошибка при отправке заказа');
            }
        });
        return false;
    });
});