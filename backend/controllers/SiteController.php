<?php

/**
 * Controller class for catalog
 */
class SiteController
{
    /**
     * Displays catalog page
     */
    public function indexAction()
    {
        $wallet = new Wallet();
        $cash = $wallet->getCash();
        $productModel = new Product();
        $products= $productModel->getAllProductsWithRating();
        $session = $this->getSession();
        $is_rated = $session->get('is_rated');
        $cart = new Cart();
        $cartItemsCount = $cart->itemsCount();
        $data = compact('cash', 'cartItemsCount', 'products', 'is_rated');
        $view = new View(DEFAULT_ACTION . '.php');
        $view->render($data);
        return true;
    }

    /**
     * Returns session object
     * 
     * @return object 
     */
    private function getSession()
    {
        return App::getApp()->getRequest()->getSession();
    }
}
