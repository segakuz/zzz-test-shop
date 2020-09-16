<?php

/**
 * Model class for product data
 */
class Product
{

    /**
     * Gets all products
     * 
     * @return array
     */
    public function getAllProducts()
    {
        $pdo = new Db();
        $query = 'SELECT * FROM products';
        $productsList = $pdo->getAll($query);
        return $productsList;
    }

    /**
     * Gets all products with rating property
     * 
     * @return array
     */
    public function getAllProductsWithRating()
    {
        $pdo = new Db();
        $query = "SELECT p.*, ROUND(AVG(pr.rating), 1) AS rating_average 
            FROM products_rating pr 
            INNER JOIN products p
            ON pr.id_product = p.id
            GROUP BY p.id";
        $productsWithRating = $pdo->getAll($query);
        return $productsWithRating;
    }

    /**
     * Gets products by given ids
     * 
     * @param array $ids
     * 
     * @return array
     */
    public function getProductsByIds(array $ids)
    {
        $ids = implode(',', $ids);
        $pdo = new Db();
        $query = "SELECT * FROM products WHERE id IN ({$ids})";
        $products = $pdo->getAll($query);
        return $products;
    }
}
