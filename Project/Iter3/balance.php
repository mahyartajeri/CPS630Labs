<!DOCTYPE html>
<html lang="en">

<head>

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
        <link href="./style.css" rel="stylesheet" />
        <title>SCS Buy Balance</title>
    </head>
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        }

        /* Firefox */
        input[type=number] {
        -moz-appearance: textfield;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <?php include 'header.php' ?>
        <br>
        <br>
        <br>
        <div class="row">
            <h1>Purchase Balance</h1>
            <h2>Current Balance: ${{currBalance}}</h2>
            <div class="col-md-6">
                <form name="creditCardForm" ng-submit="submitCreditCardForm()" novalidate>
                    <div class="form-group">
                        <label for="cardNumber">Card Number</label>
                        <input type="text" class="form-control" id="cardNumber" name="cardNumber" ng-model="cardNumber" placeholder="1234123412341234" required>

                    </div>
                    <div class="form-group">
                        <label for="cardName">Cardholder Name</label>
                        <input type="text" class="form-control" id="cardName" name="cardName" ng-model="cardName" placeholder="John Doe" required>

                    </div>
                    <div class="form-group">
                        <label for="expiryDate">Expiry Date</label>
                        <input type="text" class="form-control" id="expiryDate" name="expiryDate" ng-model="expiryDate" placeholder="mm/yy" required>

                    </div>
                    <div class="form-group">
                        <label for="cvv">CVV</label>
                        <input type="text" class="form-control" id="cvv" name="cvv" ng-model="cvv" placeholder="123" required>

                    </div>
                    <div class="form-group">
                        <label for="cvv">Balance to Add</label>
                        <input type="number" class="form-control" id="balance" name="balance" ng-model="balance" required>

                    </div>
                    <button type="submit" name="action" id="action" value="buyBalance" ng-model="action">Purchase</button>
                </form>
            </div>
        </div>
    </div>


</body>

</html>