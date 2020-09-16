$(function(){

  //adds a product to cart
  $('.add-to-cart').on('click', function(){
    let id = $(this).parent().data('id');
    $.post('/ajax/addtocart/' + id, {}, function(data){
      $('.cart-items-count').text(data);
    });
    return false;
  });

  //removes product from cart
  $('.delete-product').on('click', function(){
    let parent = $(this).parents('.cart-product')
    let id = parent.data('id');
    $.post('/ajax/removeproduct/' + id, {}, function(data, status){
      parent.remove();
      if(data !== '0'){
        $('.total-price').text(data);
      } else {
        $('.cart-form').html('<p class="mt-5">The Cart is empty</p>');
      }
      
    });
  });

  //Sets transport type
  $('.transport').on('change', function(){
    let id = $(this).val();
    $.post('/ajax/choosetransport', {transportId: id}, function(data){
      $(".total-price").text(fixed(data.totalPrice));
      $(".transport-price").text('$' + fixed(data.transportPrice));
    }, 'json');
  })

  //Increases product total cost
  $('.quantity').on('change', function(){
    let quantity = parseInt($(this).val(), 10);
    let parent = $(this).parents('.cart-product')
    let id = parent.data('id');
    let price = parseFloat(parent.data('price'));
    let productTotal = fixed(price * quantity);
    if(quantity > 0){
      $.post(
        '/ajax/changequantity',
        {id: id,
        quantity: quantity},
        function(data){
          $(".total-price").text(data);
          parent.find(".product-total").text(productTotal);
        });
    }
  });

  //rates a product
  $('.rating-stars img').on('click', function(){
    let rate = $(this).index() + 1;
    let parent = $(this).parents('.product')
    let id = parent.data('id');
    $.post('/ajax/addrating/' + id + '/' + rate, {}, function(data, status){
      if(data){
        parent.find('.average-rating').text(data);
        renderRating(id);
        parent.find('.rating').removeClass('not-rated').addClass('rated');
        parent.find('.user-rating').text('Your rating: ' + rate);
      } else {
        alert('You have already rated this item');
      }
    });
    return false;
  });

  //Validates transport choice
  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  let forms = document.getElementsByClassName('needs-validation');
  // Loop over them and prevent submission
  let validation = Array.prototype.filter.call(forms, function(form) {
  form.addEventListener('submit', function(event) {
    event.preventDefault();
    event.stopPropagation();

    if (form.checkValidity() === true) {
      $.post('/ajax/pay', {}, function(data){
        if(data.alert){
          alert(data.alert);
        } else {
          $('.cart-form').html('<div class="alert alert-success">' + data.paid + '</div>');
          $('.cash').text(fixed(data.cash));
        }
      }, 'json');
    }
    form.classList.add('was-validated');
  }, false);
  });

  //Rounds floats
  function fixed(value, precision){
    let power = Math.pow(10, precision || 2);
    return Math.round(value * power) / power;
  }
  //Renders rating stars
  function renderRating(productId) {
    let productSelector = ".product[data-id=" + productId + "]";
    let averageRating = Math.round(parseFloat($(productSelector + " .average-rating").text()));
    for (let i = 1; i <= 5; i++) {
        let starSelector = productSelector + " .rating-stars img:nth-child(" + i + ")";
        $(starSelector).removeClass("star-fill");
        if (i <= averageRating) {
            $(starSelector).addClass("star-fill");
        }
    }
  }

  //sets current rating stars
  for (let i = 1; i <= $(".product").length; i++) {
      renderRating(i);
  }
});
