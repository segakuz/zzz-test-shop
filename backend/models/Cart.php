<?php

/**
 * Model class for cart data
 */
class Cart
{

    /**
     * Adds product with given id to cart
     * 
     * @param int $id Product id
     * 
     * @return int Products count in cart
     */
    public function addToCart($id)
    {
        $id = abs(intval(test_input($id)));
        $productsInCart = array();
        $shopSession = $this->getSession();

        if( ! is_null($shopSession->get('products')) )
        {
            $productsInCart = $shopSession->get('products');
        }
        if( array_key_exists($id, $productsInCart) )
        {
            $productsInCart[$id]++;
        }
        else
        {
            $productsInCart[$id] = 1 ;
        }
        $shopSession->set('products', $productsInCart);

        return $this->itemsCount();
    }

    /**
     * Counts products in cart
     * 
     * @return int
     */
    public function itemsCount() 
    {
        $shopSession = $this->getSession();
        if ( ! is_null($shopSession->get('products')) ) 
        {
            $count = 0;
            foreach ($shopSession->get('products') as $quantity) {
                $count = $count + $quantity;
            }
            return $count;
        } else {
            return 0;
        }
    }

    /**
     * Changes quantity of given product in cart
     * 
     * @param int $id
     * @param int $quantity
     */
    public function changeItemQuantity($id, $quantity)
    {
        $id = abs(intval(test_input($id)));
        $quantity = abs(intval(test_input($quantity)));
        $session = $this->getSession();
        $productsInCart = $session->get('products');
        $productsInCart[$id] = $quantity;
        $session->set('products', $productsInCart);
        return true;
    }

    /**
     * Gets products in cart
     */
    public function getProducts()
    {
        $shopSession = $this->getSession();
        if ( ! is_null($shopSession->get('products')) )
        {
            return $shopSession->get('products');
        }
        return false;
    }

    /**
     * Gets total price of products in cart with transport price
     * 
     * @param array $products
     */
    public function getTotalPrice($products)
    {
        $productsInCart = $this->getProducts();
        $total = 0;
        if($this->getChosenTransport())
        {
            $transportId = $this->getChosenTransport();
            $transportPrice = $this->getTransportPrice($transportId);
            $total += $transportPrice;
        }
        if ($productsInCart)
        {
            foreach ($products as $item) {

                $total += $item['price'] * $productsInCart[$item['id']];
            }
        }
        return $total;
    }

    /**
     * Gets transport types
     */
    public function getTransports()
    {
        $query = "SELECT * FROM transport";
        $pdo = new Db();
        $transports = $pdo->getAll($query);
        return $transports;
    }

    /**
     * Chooses transport in cart
     * 
     * @param int
     */
    public function chooseTransport($id)
    {
        $session = $this->getSession();
        $session->set('transport', $id);
        return true;
    }

    /**
     * Gets chosen transport type
     */
    public function getChosenTransport()
    {
        $session = $this->getSession();
        if ( ! is_null($session->get('transport')) )
        {
            return $session->get('transport');
        }
        return false;
    }

    /**
     * Gets transport price by given id
     * 
     * @param int $id
     */
    public function getTransportPrice($id)
    {
        $query = "SELECT price FROM transport WHERE id = :id";
        $pdo = new Db();
        $transportPrice = $pdo->getOne($query, ['id' => $id]);
        return $transportPrice;
    }

    /**
     * Removes products from cart
     */
    public function clear()
    {
        if ( ! is_null($this->session->get('products')) )
        {
            $this->session->set('products', null);
        }
    }

    /**
     * Deletes product with given id from cart
     * 
     * @param int $id
     */
    public function deleteProduct($id)
    {
        $productsInCart = $this->getProducts();
        unset($productsInCart[$id]);
        $this->session->set('products', $productsInCart);
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
