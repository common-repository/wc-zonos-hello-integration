document.addEventListener('DOMContentLoaded', function() {
  var addOnsSelect = document.querySelectorAll('.wc-pao-addon-select');
  var addOnsRadios = document.querySelectorAll('.wc-pao-addon-radio');
  var addOnsCustomPriceInputs = document.querySelectorAll('.wc-pao-addon-custom-price');

  if(addOnsSelect) {
    addOnsSelect.forEach(function(addOnSelect) {
      addOnSelect.addEventListener('change', function() {
        zonos.displayCurrency();
      })
    });
  }

  if(addOnsRadios) {
    addOnsRadios.forEach(function(addOnRadio) {
      addOnRadio.addEventListener('change', function() {
        zonos.displayCurrency();
      })
    });
  }

  if(addOnsCustomPriceInputs) {
    addOnsCustomPriceInputs.forEach(function(addOnsCustomPriceInput) {
      addOnsCustomPriceInput.addEventListener('keyup', function() {
        zonos.displayCurrency();
      });

      addOnsCustomPriceInput.addEventListener('mouseup', function() {
        zonos.displayCurrency();
      });
    });
  }
});