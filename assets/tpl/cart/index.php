<?php include './assets/tpl/layouts/header.php'; ?>

<main class="container py-5">
    <h1>ABC shop</h1>
    <div class="fixed-top text-right">
        <div class="d-inline-block px-5 py-2 text-info lead card m-1 shadow border-info">
            Your cash: $<span class="cash"><?= $cash; ?></span>
        </div>
    </div>
    <section class="my-5">
        <h2 class="display-4 d-inline-block mr-4">Cart</h2>
        <a href="/">Back to catalog</a>

        <?php if(!empty($products)): ?>
        <form class="needs-validation cart-form" method="POST" novalidate>
            <div class="table-responsive mt-5">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach($products as $product): ?>

                        <tr class="cart-product" data-id="<?= $product['id']; ?>" data-price="<?= $product['price']; ?>">
                            <td>
                                <img class="delete-product" src="/assets/icons/x-square.svg" alt="X icon" width="20" height="20">
                            </td>
                            <td><?= $product['name']; ?></td>
                            <td>$<?= $product['price'] + 0; ?></td>
                            <td>
                                <input class="pl-1 quantity" type="number" name="quantity" min="1" step="1" value="<?= $cartProducts[$product['id']]; ?>">
                            </td>
                            <td>$<span class="product-total"><?= $product['price'] * $cartProducts[$product['id']]; ?><span></td>
                        </tr>

                        <?php endforeach; ?>

                        <tr>
                            <th scope="row" colspan="3" class="text-right">Transport type</th>
                            <td>
                                <select class="custom-select transport" name="transport" required>
                                    <option selected disabled value="">Choose...</option>
                                    <?php foreach($transports as $transport): ?>
                                    <option value="<?= $transport['id']; ?>"
                                    <?= (intval($transport['id']) === $chosenTransport)? 'selected': '' ; ?>>
                                        <?= $transport['name']; ?>
                                    </option>
                                    <?php endforeach; ?>

                                </select>
                                <div class="invalid-feedback">
                                    Please select a transport type.
                                </div>
                            </td>
                            <td class="transport-price">
                                <?php
                                    if($chosenTransport)
                                    {
                                        echo '$', $chosenTransportPrice + 0;
                                    }
                                ?>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th scope="row" colspan="4" class="text-right">Cart total</th>
                            <td class="font-weight-bold">$<span class="total-price"><?= $totalPrice + 0; ?></span></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="text-right">
                <input class="btn btn-primary btn-lg px-5" type="submit" value="Pay">
            </div>
        </form>
        <?php else: ?>
            <p class="mt-5">The Cart is empty</p>
        <?php endif; ?>

    </section>
</main>

<?php include './assets/tpl/layouts/footer.php'; ?>
