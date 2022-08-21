// Обработка формы добавления товара
// Ожидание загрузки всего документа, после чего будет выполнена анонимная функция
$(function(){
    // Выбор элемента с «id="formAddProduct"» (Форма)
    const formAddProduct = $('#formAddProduct');
    // Выбор элемента с «id="popUpSuccess"» (Всплывающее окно)
    const popUpSuccess = $('#popUpSuccess');
    // Выбор элемента с «id="result"» (Текст сообщения)
    const message = $('#result');

    // Обработчик события "Отправка формы по нажатию кнопки "Добавить товар"
    formAddProduct.submit(function() {
        $.ajax({
            method: 'POST',
            url: '/content/ajax/products_add.php',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: new FormData(this),
            success: function(dataJson) {
                // Вывод сообщения из ajax.php
                message.html(dataJson);
                // Если данные из формы записались в базу успешно
                if (dataJson === true) {
                    // Скрытие формы и отображение всплывающего окна
                    formAddProduct.attr('hidden','hidden');
                    popUpSuccess.removeAttr('hidden');
                    // Взято из "scripts.js":
                    //const form = document.querySelector('.custom-form');
                    //const popupEnd = document.querySelector('.page-add__popup-end');
                    //form.hidden = true;
                    //popupEnd.hidden = false;
                }
                else {
                    message.html(dataJson);
                }
            },
            error: function() {
                // Вывод сообщения
                message.html('Ошибка при добавлении/изменении товара');
            }
        });
        return false;
    });
});