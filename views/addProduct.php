<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>Test</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light p-4">
    <div class="container-fluid">
        <h1 class="navbar-brand">Product Add</h1>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
    <form action="" method="post" name="form" id="form" onsubmit="return validateForm()">
        <div class="mb-3">
                    <label class="form-label">SKU</label>
                    <input name="sku" type="text" class="form-control" onblur="validate('sku')" oninput="validate('sku')">
                    <div class="invalid-feedback">sku is a required field</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input name="name"  type="text" class="form-control" onblur="validate('name')" oninput="validate('name')">
            <div class="invalid-feedback">name is a required field</div>
        </div>
        <div class="mb-3">
            <label>Price ($)</label>
            <input name="price"  type="number" class="form-control" onblur="validate('price')" oninput="validate('price')">
            <div class="invalid-feedback">price is a required field</div>
        </div>
        <div class="mb-3">
            <label>Type Switcher</label>
            <select class="form-select mb-3" name="type" oninput="validate('type'); updateForm();">
                <option selected>Choose type</option>
                <option value="size">Size</option>
                <option value="weight">Weight</option>
                <option value="dimensions">Dimentions</option>
            </select>
            <div class="invalid-feedback">type is a required field</div>
        </div>
        <div class="mb-3" style="display: none" id="size" >
            <label>Size (MB)</label>
            <input name="size"  type="number" class="form-control" onblur="validate('size')">
            <div class="invalid-feedback">Size is a required field</div>
            <div>This is the storage in megabytes</div>
        </div>
        <div class="mb-3" style="display: none" id="weight">
            <label>Weight (kg)</label>
            <input name="weight"  type="number" class="form-control" onblur="validate('weight')">
            <div class="invalid-feedback">Weight is a required field</div>
            <div>This is the weight in kg</div>
        </div>
        <div class="mb-3" id="dimensions" style="display: none">
            <div>
                <label>Height (CM)</label>
                <input name="height"   type="number" class="form-control" onblur="validate('height')" >
                <div class="invalid-feedback">Height is a required field</div>
            </div>
            <div class="mb-3">
                <label>Width (CM)</label>
                <input name="width"  type="number" class="form-control" onblur="validate('width')">
                <div class="invalid-feedback">Width is a required field</div>
            </div>
            <div class="mb-3">
                <label>Length (CM)</label>
                <input name="length" type="number" class="form-control" onblur="validate('length')">
                <div class="invalid-feedback">Length is a required field</div>
            </div>

            <div>This is the length in cm</div>
        </div>
    </form>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<script>

    let inputFields ={
        "sku": document.forms["form"]['sku'],
        "name": document.forms["form"]['name'],
        "price": document.forms["form"]["price"],
        "type":document.forms["form"]["type"],
        "size":document.forms["form"]["size"],
        "weight":document.forms["form"]["weight"],
        "height":document.forms["form"]["height"],
        "length":document.forms["form"]["length"],
        "width":document.forms["form"]["width"],
    };


    formFieldsValues={
        "sku":false,
        "name":false,
        "price":false,
        "type":false,
        "size":false,
        "weight":false,
        "height":false,
        "width":false,
        "length":false,
    };

    let selectedType="";

    let staticFields=["sku","name","price","type"];
    let optionalFields=["weight","dimensions","size"];
    let dimensionsFields=["height","width","length"];
    let disableCandidates=["length","height","width","size","weight"];


    function validateForm(){
        for (let i = 0; i < staticFields.length; i++) {
            if(formFieldsValues[staticFields[i]]===false){
                populateErrors();
                return false;
            }
        }
        if(selectedType!=='dimensions'){
            if(formFieldsValues[selectedType]===false){
                populateErrors();
                return false;
            }
        }else{
            for (let i = 0; i < dimensionsFields.length; i++) {
                if(formFieldsValues[dimensionsFields[i]]===false){
                    populateErrors();
                    return false
                }
            }
        }

        disable(getOptionsToBeDisabled());
        return true;
    }

    function getOptionsToBeDisabled(){
        let toBeDisabled=[];
        if(selectedType==="weight"){
            toBeDisabled = disableCandidates.filter(ele=>(ele!=="weight"));
        }else if(selectedType==="size"){
            toBeDisabled = disableCandidates.filter(ele=>(ele!=="size"));
        }else if(selectedType==="dimensions"){
            toBeDisabled = disableCandidates.filter(ele=>(ele!=="length" && ele!=="height" && ele!=="width"));
        }
        return toBeDisabled;
    }


    function disable(options){
        for (let i = 0; i < options.length; i++) {
           console.log(inputFields[options[i]].disabled = true);
        }
    }

    function populateErrors(){
        for (let i = 0; i < staticFields.length; i++) {
            if(formFieldsValues[staticFields[i]]===false){
                inputFields[staticFields[i]].classList.add("is-invalid");
            }
        }
        if(selectedType!=='dimensions'){
            if(formFieldsValues[selectedType]===false){
                inputFields[selectedType].classList.add("is-invalid");
            }
        }else{
            for (let i = 0; i < dimensionsFields.length; i++) {
                if(formFieldsValues[dimensionsFields[i]]===false){
                    inputFields[dimensionsFields[i]].classList.add("is-invalid");
                }
            }
        }
    }

    function validate(inputName){
        if(inputName === 'type'){
            if(inputFields[inputName].value==='Choose type'){
                formFieldsValues[inputName]=false;
                inputFields[inputName].classList.add("is-invalid");
            }else{
                formFieldsValues[inputName]=true;
                inputFields[inputName].classList.remove("is-invalid");
            }
        }else{
            if(inputFields[inputName].value.trim()===''){
                formFieldsValues[inputName]=false;
                inputFields[inputName].classList.add("is-invalid");
            }else{
                formFieldsValues[inputName]=true;
                inputFields[inputName].classList.remove("is-invalid");
            }
        }
    }

    function updateForm(){
        closeAllOptionalFields();
        let newField = inputFields['type'].value;
        selectedType=newField;
        document.querySelector("#"+newField).style.display="";
    }


    function closeAllOptionalFields(){
        optionalFields.forEach(function (item,index){
            document.querySelector("#"+item).style.display="none";
        });
    }



</script>

</body>
</html>