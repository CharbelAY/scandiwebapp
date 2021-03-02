<nav class="navbar navbar-expand-lg navbar-light bg-light p-4">
    <div class="container-fluid">
        <h1 class="navbar-brand">Product List</h1>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto ">
                <li class="nav-item">
                    <a class=" btn btn-outline-success m-2" aria-current="page" href="/addproduct">Add Product</a>
                </li>
                <li class="nav-item">
                    <button type="submit" class="btn btn-outline-danger m-2" form="form">Mass Delete</button>
                </li>
            </ul>
        </div>
    </div>
</nav>

<form action="" method="post" name="form" id="form">
    <ul>
        <?php if ($products): ?>
            <?php foreach ($products as $product): ?>
                <div class="card text-center m-3" style="width: 20rem; display: inline-block">
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="<?= $product["id"] ?>">
                        </div>
                        <h5 class="card-title"><?= $product["sku"] ?></h5>
                        <h5 class="card-title"><?= $product["name"] ?></h5>
                        <h5 class="card-title"><?= $product["price"] . " $" ?></h5>
                        <h5 class="card-title"><?= $product["measurement_presentation"] ?></h5>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            No Products available
        <?php endif; ?>
    </ul>
</form>


<script>
</script>

<style>

</style>
