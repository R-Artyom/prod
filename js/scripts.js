'use strict';

const toggleHidden = (...fields) => {

  fields.forEach((field) => {

    if (field.hidden === true) {

      field.hidden = false;

    } else {

      field.hidden = true;

    }
  });
};

const labelHidden = (form) => {

  form.addEventListener('focusout', (evt) => {

    const field = evt.target;
    const label = field.nextElementSibling;

    if (field.tagName === 'INPUT' && field.value && label) {

      label.hidden = true;

    } else if (label) {

      label.hidden = false;

    }
  });
};

const toggleDelivery = (elem) => {

  const delivery = elem.querySelector('.js-radio');
  const deliveryYes = elem.querySelector('.shop-page__delivery--yes');
  const deliveryNo = elem.querySelector('.shop-page__delivery--no');
  const fields = deliveryYes.querySelectorAll('.custom-form__input');

  delivery.addEventListener('change', (evt) => {

    if (evt.target.id === 'dev-no') {

      fields.forEach(inp => {
        if (inp.required === true) {
          inp.required = false;
        }
      });


      toggleHidden(deliveryYes, deliveryNo);

      deliveryNo.classList.add('fade');
      setTimeout(() => {
        deliveryNo.classList.remove('fade');
      }, 1000);

    } else {

      fields.forEach(inp => {
        if (inp.required === false) {
          inp.required = true;
        }
      });

      toggleHidden(deliveryYes, deliveryNo);

      deliveryYes.classList.add('fade');
      setTimeout(() => {
        deliveryYes.classList.remove('fade');
      }, 1000);
    }
  });
};

const filterWrapper = document.querySelector('.filter__list');
if (filterWrapper) {

  filterWrapper.addEventListener('click', evt => {

    const filterList = filterWrapper.querySelectorAll('.filter__list-item');

    filterList.forEach(filter => {

      if (filter.classList.contains('active')) {

        filter.classList.remove('active');

      }

    });

    const filter = evt.target;

    filter.classList.add('active');

  });

}

const shopList = document.querySelector('.shop__list');
if (shopList) {

  shopList.addEventListener('click', (evt) => {

    const productId = document.querySelector('#productId');
    const productPrice = document.querySelector('#price');
    const productPriceDelivery = document.querySelector('#priceDelivery');
    // Значение идентификатора товара, отправляемого в форме
    productId.value = parseInt(evt.target.id);
    // Стоимость товара, отображаемая на странице, если самовывоз
    productPrice.innerText = parseFloat(evt.target.children[2].textContent) + ' руб.';
    // Стоимость товара, отображаемая на странице, если доставка на дом
    productPriceDelivery.innerText = parseFloat(evt.target.children[3].textContent) + ' руб.';

    const prod = evt.path || (evt.composedPath && evt.composedPath());;

    if (prod.some(pathItem => pathItem.classList && pathItem.classList.contains('shop__item'))) {

      const shopOrder = document.querySelector('.shop-page__order');

      toggleHidden(document.querySelector('.intro'), document.querySelector('.shop'), shopOrder);

      window.scroll(0, 0);

      shopOrder.classList.add('fade');
      setTimeout(() => shopOrder.classList.remove('fade'), 1000);

      const form = shopOrder.querySelector('.custom-form');
      labelHidden(form);

      toggleDelivery(shopOrder);

      const buttonOrder = shopOrder.querySelector('.button');
      //const popupEnd = document.querySelector('.shop-page__popup-end');
      // Обработка кнопки "Применить"
      buttonOrder.addEventListener('click', (evt) => {

        form.noValidate = true;

        const inputs = Array.from(shopOrder.querySelectorAll('[required]'));

        inputs.forEach(inp => {

          // !! - Преобразование значений к логическому типу, т.е. если поле
          // формы заполнено, то true, если пустое - то false
          if (!!inp.value) {

            if (inp.classList.contains('custom-form__input--error')) {
              inp.classList.remove('custom-form__input--error');
            }

          } else {

            inp.classList.add('custom-form__input--error');

          }
        });

        if (inputs.every(inp => !!inp.value)) {

        } else {
          window.scroll(0, 0);
          evt.preventDefault();
        }
      });
    }
  });
}

const pageOrderList = document.querySelector('.page-order__list');
if (pageOrderList) {

  pageOrderList.addEventListener('click', evt => {


    if (evt.target.classList && evt.target.classList.contains('order-item__toggle')) {
      var path = evt.path || (evt.composedPath && evt.composedPath());
      Array.from(path).forEach(element => {

        if (element.classList && element.classList.contains('page-order__item')) {

          element.classList.toggle('order-item--active');

        }

      });

      evt.target.classList.toggle('order-item__toggle--active');

    }

    if (evt.target.classList && evt.target.classList.contains('order-item__btn')) {

      const status = evt.target.previousElementSibling;
      const id = evt.target.value;
      $.ajax({
        url: '/content/ajax/orders.php',
        method: 'GET',
        dataType: 'json',
        cache: false,
        data: {orderId: id, orderStatus: status.textContent},
        success: function(dataJson) {
          // Если данные в базе обновились успешно
          if (dataJson === true) {
            if (status.classList && status.classList.contains('order-item__info--no')) {
              status.textContent = 'Обработан';
            } else {
              status.textContent = 'Не обработан';
            }
            status.classList.toggle('order-item__info--no');
            status.classList.toggle('order-item__info--yes');
          }
        }
      });

    }

  });

}

const checkList = (list, btn) => {

  if (list.children.length === 1) {

    btn.hidden = false;

  } else {
    btn.hidden = true;
  }

};
const addList = document.querySelector('.add-list');
if (addList) {

  const form = document.querySelector('.custom-form');
  labelHidden(form);

  const addButton = addList.querySelector('.add-list__item--add');
  const addInput = addList.querySelector('#product-photo');
  const oldPhoto = document.querySelector('#product-photo-old');

  checkList(addList, addButton);

  addInput.addEventListener('change', evt => {

    oldPhoto.hidden = true;
    const template = document.createElement('LI');
    const img = document.createElement('IMG');

    template.className = 'add-list__item add-list__item--active';
    template.addEventListener('click', evt => {
      oldPhoto.hidden = false;
      addList.removeChild(evt.target);
      addInput.value = '';
      checkList(addList, addButton);
    });

    const file = evt.target.files[0];
    const reader = new FileReader();

    reader.onload = (evt) => {
      img.src = evt.target.result;
      template.appendChild(img);
      addList.appendChild(template);
      checkList(addList, addButton);
    };

    reader.readAsDataURL(file);

  });

}

const productsList = document.querySelector('.page-products__list');
if (productsList) {

  productsList.addEventListener('click', evt => {

    const target = evt.target;

    if (target.classList && target.classList.contains('product-item__delete')) {
      const id = target.value;
      $.ajax({
        url: '/content/ajax/products.php',
        method: 'GET',
        dataType: 'json',
        cache: false,
        data: {idProduct: id},
        success: function(dataJson) {
          // Если данные из базы удалились успешно
          if (dataJson === true) {
            productsList.removeChild(target.parentElement);
            if (productsList.childElementCount === 0) {
              location.reload();
            }
          }
        }
      });
    }

  });

}

// jquery range maxmin
if (document.querySelector('.shop-page')) {
  const sliderMin = parseFloat($('#sliderMin').attr('value'));
  const sliderMax = parseFloat($('#sliderMax').attr('value'));

  const sliderMinActive = parseFloat($('.min-price').text());
  const sliderMaxActive = parseFloat($('.max-price').text());

  $('#sliderMin').attr('value', sliderMinActive);
  $('#sliderMax').attr('value', sliderMaxActive);

  $('.range__line').slider({
    min: sliderMin,
    max: sliderMax,
    values: [sliderMinActive, sliderMaxActive],
    range: true,
    step: 1,
    stop: function(event, ui) {
      const min = ui.values[0];
      const max = ui.values[1];
      $('.min-price').text(min + ' руб.');
      $('.max-price').text(max + ' руб.');

      $('#sliderMin').attr('value', min);
      $('#sliderMax').attr('value', max);

    },
    slide: function(event, ui) {

      $('.min-price').text($('.range__line').slider('values', 0) + ' руб.');
      $('.max-price').text($('.range__line').slider('values', 1) + ' руб.');

    }
  });

}
