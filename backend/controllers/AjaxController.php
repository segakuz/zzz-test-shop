<?php

/**
 * class for ajax actions
 */
class AjaxController
{
    /**
     * Adds product with given id to cart
     * 
     * @param int $id Product id
    */
    public function addToCartAction($id)
    {
        $id = abs(intval(test_input($id)));
        $cart = new Cart();
        $cartItemsCount = $cart->addToCart($id);
        echo $cartItemsCount;
        return true;
    }

    /**
     * Removes product with given id from cart
     * 
     * @param int $id Product id
     */
    public function removeProductAction($id)
    {
        $id = abs(intval(test_input($id)));
        $session = App::getApp()->getRequest()->getSession();
        $cartProducts = $session->get('products');
        unset($cartProducts[$id]);
        $session->set('products', $cartProducts);

        $ids = array_keys($cartProducts);
        $productModel = new Product();
        $products = $productModel->getProductsByIds($ids);
        $cartModel = new Cart();
        $totalPrice = $cartModel->getTotalPrice($products);
        echo $totalPrice;
        return true;
    }

    /**
     * Adds rating to product
     * 
     * @param int $id Product id
     * @param int $rating Given rating
     */
    public function addRatingAction($id, $rating)
    {
        $id = abs(intval(test_input($id)));
        $rating = abs(intval(test_input($rating)));
        $session = App::getApp()->getRequest()->getSession();
        $productsRating = array();
        if( ! is_null($session->get('is_rated')))
        {
            $productsRating = $session->get('is_rated');
        }
        if( array_key_exists($id, $productsRating) )
        {
            $response = false;
        }
        else
        {
            $ratingInstance = new Rating();
            $ratingInstance->addRating($id, $rating);
            $productsRating[$id] = $rating;
            $session->set('is_rated', $productsRating);
            $avgRating = $ratingInstance->getAvgRating($id);
            $response = $avgRating;
        }
        echo $response;
        return true;
    }

    /**
     * Changes products quantity in cart
     */
    public function changeQuantityAction()
    {
        $input = App::getApp()->getRequest()->getInput();
        $id = abs(intval(test_input($input->get('id'))));
        $quantity = abs(intval(test_input($input->get('quantity'))));

        $cartModel = new Cart();
        $cartModel->changeItemQuantity($id, $quantity);
        
        $productsInCart = $cartModel->getProducts();
        $ids = array_keys($productsInCart);
        $productModel = new Product();
        $products = $productModel->getProductsByIds($ids);
        $totalPrice = $cartModel->getTotalPrice($products);
        echo $totalPrice;
        return true;
    }

    /**
     * Chooses transport type
     */
    public function chooseTransportAction()
    {
        $input = App::getApp()->getRequest()->getInput();
        $transportId = abs(intval(test_input($input->get('transportId'))));
        $cartModel = new Cart();
        $cartModel->chooseTransport($transportId);

        $productsInCart = $cartModel->getProducts();
        $ids = array_keys($productsInCart);
        $productModel = new Product();
        $products = $productModel->getProductsByIds($ids);

        $transportPrice = $cartModel->getTransportPrice($transportId);
        $totalPrice = $cartModel->getTotalPrice($products);
        echo json_encode(compact('transportPrice', 'totalPrice'));
        return true;
    }

    /**
     * Pay action for cart form submit
     */
    public function payAction()
    {
        $wallet = new Wallet();
        $cash = $wallet->getCash();
        $cartModel = new Cart();
        $productsInCart = $cartModel->getProducts();
        $ids = array_keys($productsInCart);
        $productModel = new Product();
        $products = $productModel->getProductsByIds($ids);
        $totalPrice = $cartModel->getTotalPrice($products);

        if(! $wallet->check($totalPrice))
        {
            $alert = 'You do not have enough money';
            echo json_encode(compact('alert'));
            return true;
        } 
        else
        {
            $cash = $wallet->deduct($totalPrice);
            $session = App::getApp()->getRequest()->getSession();
            $session->clear('products');
            $session->clear('transport');
            $paid = "Thank you! You have paid \${$totalPrice}, your current cash \${$cash}";
            echo json_encode(compact('paid', 'cash'));
            return true;
        }

        $alert = 'Something wrong!';
        echo json_encode(compact('alert'));
        return true;
    }
}
