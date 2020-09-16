<?php include './assets/tpl/layouts/header.php'; ?>

<main class="container py-5">
    <h1>ABC shop</h1>
    <div class="fixed-top text-right">
        <div class="d-inline-block px-5 py-2 text-info lead card m-1 shadow border-info">
            Your cash: $<?= $cash; ?>
        </div>
        <br>
        <a href="/cart/" class="d-inline-block px-5 py-2 lead card m-1 shadow bg-info text-white" title="Go to cart">
            Cart
            <span class="badge badge-pill badge-light cart-items-count"><?= $cartItemsCount; ?></span>
        </a>
    </div>
    <section class="my-5">
        <h2 class="display-4">Catalog</h2>
        <div class="row text-center mt-5">
            <?php 
                foreach($products as $product):
            ?>
            <div class="col-md-3 col-6 mb-3">
                <div class="card">
                    <div class="card-body product" data-id="<?= $product['id']; ?>">
                        <h3 class="card-title"><?= $product['name']; ?></h3>
                        <p class="rating <?= ($is_rated[$product['id']])? 'rated' : 'not-rated' ; ?> card-text mt-5">
                            <span class="rating-stars text-info d-inline-block">
                                <img src="./assets/icons/star-fill.svg" alt="Star icon" width="16" height="16">
                                <img src="./assets/icons/star-fill.svg" alt="Star icon" width="16" height="16">
                                <img src="./assets/icons/star-fill.svg" alt="Star icon" width="16" height="16">
                                <img src="./assets/icons/star-fill.svg" alt="Star icon" width="16" height="16">
                                <img src="./assets/icons/star-fill.svg" alt="Star icon" width="16" height="16">
                            </span>
                            <span>(<span class="average-rating"><?= $product['rating_average']; ?></span>)</span>
                        </p>
                        <p class="card-text"><small class="text-muted user-rating">
                        <?= ($is_rated[$product['id']])?
                                'Your rating: ' . $is_rated[$product['id']] :
                                'Click star to rate it';
                        ?>
                        </small></p>
                        <p class="price card-text lead font-weight-bold mt-5">$<?= $product['price']; ?></p>
                        <button type="button" class="btn btn-primary add-to-cart">Add to Cart</button>
                    </div>
                </div>
            </div>
            <?php 
                endforeach;
            ?>
        </div>
    </section>
</main>

<?php include './assets/tpl/layouts/footer.php'; ?>