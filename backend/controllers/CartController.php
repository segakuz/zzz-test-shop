<?php

/**
 * Controller class for cart page
 */
class CartController
{

    /**
     * Displays cart page with parametres
     */
    public function indexAction()
    {
        $cartModel = new Cart();
        $cartProducts = $cartModel->getProducts();
        $transports = $cartModel->getTransports();
        $chosenTransport = $cartModel->getChosenTransport();
        $wallet = new Wallet();
        $cash = $wallet->getCash();
        $products = false;
        $totalPrice = false;
        if($chosenTransport)
        {
            foreach($transports as $transport)
            {
                if($transport['id'] == $chosenTransport)
                {
                    $chosenTransportPrice = $transport['price'];
                    break;
                }
            }
        }
        if($cartProducts)
        {
            $productsIds = array_keys($cartProducts);
            $productModel = new Product();
            $products = $productModel->getProductsByIds($productsIds);
            $totalPrice = $cartModel->getTotalPrice($products);
        }
        $data = compact('cartProducts', 'products', 'totalPrice', 'cash', 'transports', 'chosenTransport', 'chosenTransportPrice');
        $view = new View('cart/index.php');
        $view->render($data);
        return true;
    }
}
