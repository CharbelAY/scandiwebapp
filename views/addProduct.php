<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <title>Test</title>

    <style>
        label.error {
            color: red;
            font-size: 1rem;
            display: block;
            margin-top: 5px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light p-4">
    <div class="container-fluid">
        <h1 class="navbar-brand">Product Add</h1>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto ">
                <li class="nav-item">
                    <button type="submit" class="btn btn-outline-success m-2" form="form">Save</button>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-danger m-2" href="/products/list">Cancel</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container" style="width: 500px">

    <?php if ($errorMessage): ?>
        <div class="alert alert-danger" role="alert">
            <?= $errorMessage ?>
        </div>
    <?php endif; ?>

    <form action="" method="post" name="form" id="form">
        <div class="mb-3">
            <label class="form-label">SKU</label>
            <input name="sku" type="text" class="form-control" value="<?= $model->sku; ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input name="name" type="text" class="form-control" value="<?= $model->name; ?>">
        </div>
        <div class="mb-3">
            <label>Price ($)</label>
            <input name="price" type="number" class="form-control"
                   value="<?= $model->price == 0 ? null : $model->price; ?>">
        </div>
        <div class="mb-3">
            <label>Type Switcher</label>
            <select class="form-select mb-3" name="product_type_id" id="typeSelector"
                    value="<?= $model->type; ?>">
                <option value=""> Choose type</option>
                <?php foreach ($product_type as $type): ?>
                    <option value="<?= $type["type_name"]; ?>" <?= $model->type == $type["type_name"] ? 'selected="selected"' : '' ?>> <?= $type["type_name"] ?> </option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php foreach ($optionalInputs as $options): ?>
            <div class="mb-3 optional-container-class">
                <label><?= $options['label'] ?></label>
                <input name="<?= $options['name'] ?>" type="<?= $options['type'] ?>" class="form-control"
                       step="<?= $options['step'] ?>" value="<?= $model->{$options['name']}; ?>">
                <div><?= $options['message'] ?></div>
            </div>
        <?php endforeach; ?>
    </form>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

<script>


    $(document).ready(function () {

        function getOptionalFields(value) {

            $.post("/addproduct/appendtoform", {"type": value}, function (response) {
                renderFields(response);
            });
        }

        function renderFields(response) {
            removeOptionalFields("optional-container-class");
            let container = document.forms["form"];
            response.forEach(function (item, index) {
                const input = `
                            <div class="mb-3 optional-container-class">
                                <label>${item['label']}</label>
                                <input name="${item['name']}"  type="${item['type']}" class="form-control optional-input-class"  step="${item['step']}">
                                <div>${item['message']}</div>
                            </div>
`;
                container.insertAdjacentHTML('beforeend', input);

                addValidationsFor("optional-input-class");
            });
        }

        function addValidationsFor(className) {
            $(`.${className}`).each(function () {
                $(this).rules('add', {
                    required: true,
                    step: 0.01,
                    min: 0,
                });
            });
        }

        function removeOptionalFields(className) {
            document.querySelectorAll(`.${className}`).forEach(e => e.remove());

        }


        $('#typeSelector').on("change", (function (val) {
            getOptionalFields($("#typeSelector").val());
        }))

        $('#form').validate({ // initialize the plugin
            rules: {
                sku: {
                    required: true,
                },
                name: {
                    required: true
                },
                price: {
                    required: true,
                    step: 0.01,
                    min: 0,
                },
                product_type_id: {
                    required: true,
                }
            },
            messages: {
                sku: {
                    required: "SKU is a required field"
                },
                name: {
                    required: "Name is a required field"
                },
                price: {
                    required: "Price is a required field",
                    min: "Price can not be negative",
                    step: "Price can not contain more than two numbers after the dot"
                },
                product_type_id: {
                    required: "Type is a required field"
                }
            },
            submitHandler: function (form) {
                return true;
            },
        });

    });


</script>
</body>
</html>