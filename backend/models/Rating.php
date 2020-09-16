<?php

/**
 * Model class for products rating
 */
class Rating
{
    /**
     * Adds rating to product with given id
     * 
     * @param int $id
     * @param int $rating
     */
    public function addRating($id, $rating)
    {
        $pdo = new Db();
        $query = "INSERT INTO products_rating VALUES(null, :id, :rating)";
        $params = compact('id', 'rating');
        $result = $pdo->execute($query, $params);
        return true;
    }

    /**
     * Gets average rating for product with given id
     * 
     * @param int $id
     */
    public function getAvgRating($id)
    {
        $pdo = new Db();
        $query = "SELECT ROUND(AVG(pr.rating), 1) AS rating_average 
            FROM products_rating pr 
            INNER JOIN products p
            ON pr.id_product = p.id
            AND p.id = ?";
        $params = [$id];
        $result = $pdo->getOne($query, $params);
        return $result;
    }

    /**
     * Gets rating for given products
     * 
     * @param array $products
     * 
     * @return array
     */
    public function getRatings(array $products)
    {
        $ids = [];
        foreach($products as $key => $value)
        {
            $ids[] = $value['id'];
        }
        $in = '(' . implode(',',$ids) . ')';
        $query = "SELECT p.id, ROUND(AVG(pr.rating), 1) AS rating_average 
            FROM products_rating pr 
            INNER JOIN products p
            ON pr.id_product = p.id
            AND p.id IN " . $in . " GROUP BY p.id";
        $pdo = new Db();
        $result = $pdo->getAll($query);
        return $result;
    }
}
