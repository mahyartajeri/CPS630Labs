<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
        <link href="./style.css" rel="stylesheet" />
        <title>SCS Reviews</title>
</head>

<body class="container-fluid">
        <?php include 'header.php' ?>

        <div class="mt-5 pt-5">
                <ul class="list-group" id="reviews" ng-bind-html="reviews">
                </ul>

                <div>
                        <h2>Submit a Review</h2>
                        <form id="reviewSubmit">
                                <label for="itemId">Item ID:</label>
                                <select type="text" id="itemId" name="itemId" ng-bind-html="itemsList">

                                </select>
                                <br>

                                <label for="rank">Rank:</label>
                                <input type="number" id="rank" name="rank" min="1" max="5">
                                <br>


                                <input type="submit"></input>
                        </form>
                        <textarea form="reviewSubmit" name="description" id="description" cols="35" wrap="soft"></textarea>

                </div>

        </div>
        <div id="error" ng-bind-html="error"></div>

</body>

</html