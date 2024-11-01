document.addEventListener('DOMContentLoaded', function() {

  if(isSingleVariationSelector()) {
    var variationSelector = document.querySelector(zHelloPriceSelector);
    initSelectorListener(variationSelector);
  } else {
    selectVariationsAndInit();
  }

  initZonos();
});

function initZonos() {
  zonosConfig();
  variationPriceTemplateListener();
}

function initSelectorListener(selector) {
  if(selector) {
    selector.addEventListener('change', function () {
      zonosConfig();
    });
  }
}

function selectVariationsAndInit() {
  var allSelectors = zHelloPriceSelector.split(',');
  allSelectors.forEach(function(selector) {
    var element = document.querySelector(selector);
    initSelectorListener(element);
  })
}

function isSingleVariationSelector() {
  if(zHelloPriceSelector.includes(',')) {
    return false;
  }
  return true;
}

function zonosConfig() {
  zonos.config({
    currencyConverter: function(convert, format) {
      productPrice(convert, format);
      setTimeout(function() {
        variationPrice(convert, format);
      }, 400);
    }
  });
}

function productPrice(convert, format) {
  // a price from your page
  var price;

  if(hasPreviousPrice($('.woocommerce-Price-amount.amount').first())) {
    price = $('ins .woocommerce-Price-amount.amount').eq(0).text();
  } else {
    price = $('.price .woocommerce-Price-amount.amount').first().text();
  }

  var numericPrice = Number(price.replace(/[^0-9.-]+/g,""));
  // a number (ie. 17.6)
  var foreignPrice = convert(numericPrice);
  // a formatted string (ie "CA$17.60")
  var displayPriceAgain = format(foreignPrice);

  if($('.woocommerce-Price-amount.amount').siblings('.js-zonos-price')) {
    $('.woocommerce-Price-amount.amount').siblings('.js-zonos-price').remove();
  }

  if($('.woocommerce-Price-amount.amount')) {
    if(hasPreviousPrice($('.woocommerce-Price-amount.amount').first())) {
      $('ins .woocommerce-Price-amount.amount').after('<span class="js-zonos-price"> / ' + displayPriceAgain + '</span>');
    } else {
      $('.woocommerce-Price-amount.amount').first().after('<span class="js-zonos-price"> / ' + displayPriceAgain + '</span>');
    }
  }
}

function hasPreviousPrice(priceContainer) {
  if(priceContainer.closest('del').length > 0) {
    return true;
  }
  return false;
}

function variationPrice(convert, format) {
  var price;

  if(hasPreviousPrice($('.woocommerce-variation-price .woocommerce-Price-amount.amount'))) {
    price = $('ins .woocommerce-Price-amount.amount').eq(1).text();
  } else {
    price = $('.woocommerce-variation-price .woocommerce-Price-amount.amount').text();
  }

  var numericPrice = Number(price.replace(/[^0-9.-]+/g,""));
  // a number (ie. 17.6)
  var foreignPrice = convert(numericPrice);
  // a formatted string (ie "CA$17.60")
  var displayPriceAgain = format(foreignPrice);

  if($('.woocommerce-variation-price .woocommerce-Price-amount.amount').siblings('.js-zonos-price')) {
    $('.woocommerce-variation-price .woocommerce-Price-amount.amount').siblings('.js-zonos-price').remove();
  }

  if(hasPreviousPrice($('.woocommerce-variation-price .woocommerce-Price-amount.amount'))) {
    $('.woocommerce-variation-price ins .woocommerce-Price-amount.amount').after('<span class="js-zonos-price"> / ' + displayPriceAgain + '</span>');
  } else {
    $('.woocommerce-variation-price .woocommerce-Price-amount.amount ').after('<span class="js-zonos-price"> / ' + displayPriceAgain + '</span>');
  }
}

// Since WC adds the variation price container dynamically with JS
// we use MutationObserver to check when the variation price is shown
// and run the displayCurrency
function variationPriceTemplateListener() {
  const targetNode = document.querySelector('.woocommerce-variation-add-to-cart');

  const config = { attributes: true, subtree: true };

  const callback = function() {
    zonos.displayCurrency();
  };

  // Create an observer instance linked to the callback function
  const observer = new MutationObserver(callback);

  // Start observing the target node for configured mutations
  observer.observe(targetNode, config);
}