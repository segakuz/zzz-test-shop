<?php

/**
 * Model class for cash in wallet
 */
class Wallet
{
    /**
     * Default value 
     */
    private $wallet = 100;

    /**
     * Creates wallet instance
     */
    public function __construct()
    {
        $session = $this->getSession();
        if(is_null($session->get('cash')))
        {
            $session->set('cash', $this->wallet);
        }
    }

    /**
     * Gets cash value from session
     */
    public function getCash()
    {
        $session = $this->getSession();
        $cash = $this->format( $session->get('cash') );
        return $cash;
    }

    /**
     * Saves cash to session
     */
    public function setCash($cash)
    {
        $session = $this->getSession();
        $cash = $this->format($cash);
        $session->set('cash', $cash);
    }

    /**
     * Deducts given sum from cash
     */
    public function deduct($sum)
    {
        if($this->check($sum))
        {
            $sum = $this->format($sum);
            $cash = $this->getCash();
            $cash -= $sum;
            $this->setCash($cash);
            return $this->format($cash);
        }
    }

    /**
     * Checks if cash is enough for given sum
     * 
     * @return bool
     */
    public function check($sum)
    {
        $cash = $this->getCash();
        $sum = $this->format($sum);
        return ($sum < $cash);
    }

    /**
     * Gets session object
     * 
     * @return object
     */
    private function getSession()
    {
        return App::getApp()->getRequest()->getSession();
    }

    /**
     * Formats given float
     */
    private function format($num)
    {
        return number_format($num, 2);
    }
}
