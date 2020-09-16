<?php

//web routes
return [
    'ajax/addrating/([0-9]+)/([1-5])' => 'ajax/addRating/$1/$2',
    'ajax/addtocart/([0-9]+)' => 'ajax/addToCart/$1',
    'ajax/removeproduct/([0-9]+)' => 'ajax/removeProduct/$1',
    'ajax/changequantity' => 'ajax/changeQuantity',
    'ajax/choosetransport' => 'ajax/chooseTransport',
    'ajax/pay' => 'ajax/pay',
    'cart' => 'cart/index',
    'index.php' => 'site/index',
    '' => 'site/index',
];