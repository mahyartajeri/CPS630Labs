<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
        <link href="./style.css" rel="stylesheet" />
        <style>
                .accordion-button:not(.collapsed) {
                        background-color: #6c757d;
                        color: #fff;
                }
        </style>
        <title>SCS Home</title>
</head>

<body>
        <?php include './header.php' ?>
        <div class="container-fluid mt-5 py-5">
                <h1 class="text-center mb-4">Frequently Asked Questions</h1>
                <div class="accordion" id="faqAccordion">
                        <!-- FAQ Item -->
                        <div class="accordion-item">
                                <h2 class="accordion-header" id="faq1">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                                <i class="fas fa-question-circle"></i> How can I place an order?
                                        </button>
                                </h2>
                                <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="faq1" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                                To place an order, please visit our website and browse our selection of products. Add the desired items to your cart and proceed to checkout to complete your purchase.
                                        </div>
                                </div>
                        </div>
                        <!-- End FAQ Item -->


                        <!-- FAQ Item -->
                        <div class="accordion-item">
                                <h2 class="accordion-header" id="faq2">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                                <i class="fas fa-question-circle"></i> How do I track my order?
                                        </button>
                                </h2>
                                <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="faq2" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                                You can track your order by logging into your account on our website and navigating to the "Order History" section. From there, you can view the status of your order and track its progress.
                                        </div>
                                </div>
                        </div>
                        <!-- End FAQ Item -->

                        <!-- FAQ Item -->
                        <div class="accordion-item">
                                <h2 class="accordion-header" id="faq3">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                                <i class="fas fa-question-circle"></i> Can I browse products without registering?
                                        </button>
                                </h2>
                                <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="faq3" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                                Yes, you can browse products without registering on the website.
                                        </div>
                                </div>
                        </div>
                        <!-- End FAQ Item -->

                        <!-- FAQ Item -->
                        <div class="accordion-item">
                                <h2 class="accordion-header" id="faq4">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                                <i class="fas fa-question-circle"></i> Do I need to create an account to make a purchase?
                                        </button>
                                </h2>
                                <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="faq4" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                                A: Yes, you need to create an account to make a purchase on the website.
                                        </div>
                                </div>
                        </div>
                        <!-- End FAQ Item -->

                        <!-- FAQ Item -->
                        <div class="accordion-item">
                                <h2 class="accordion-header" id="faq5">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                                <i class="fas fa-question-circle"></i> How can I create an account?
                                        </button>
                                </h2>
                                <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="faq5" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                                You can create an account by clicking on the "Sign Up" button on the website's homepage.
                                        </div>
                                </div>
                        </div>
                        <!-- End FAQ Item -->

                        <!-- FAQ Item -->
                        <div class="accordion-item">
                                <h2 class="accordion-header" id="faq6">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                                                <i class="fas fa-question-circle"></i> What payment methods are accepted on the website?
                                        </button>
                                </h2>
                                <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="faq6" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                                The website accepts various payment methods including credit/debit cards, PayPal, and bank transfers.
                                        </div>
                                </div>
                        </div>
                        <!-- End FAQ Item -->

                        <!-- FAQ Item -->
                        <div class="accordion-item">
                                <h2 class="accordion-header" id="faq7">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                                                <i class="fas fa-question-circle"></i> Can I cancel my order after placing it?
                                        </button>
                                </h2>
                                <div id="collapse7" class="accordion-collapse collapse" aria-labelledby="faq7" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                                All sales are final.
                                        </div>
                                </div>
                        </div>
                        <!-- End FAQ Item -->

                        <!-- FAQ Item -->
                        <div class="accordion-item">
                                <h2 class="accordion-header" id="faq8">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                                                <i class="fas fa-question-circle"></i> Is there a warranty on the products sold on the website?
                                        </button>
                                </h2>
                                <div id="collapse8" class="accordion-collapse collapse" aria-labelledby="faq8" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                                It depends on the product. Some products may come with a warranty, while others may not. You can check the product page or contact customer support to know more.
                                        </div>
                                </div>
                        </div>
                        <!-- End FAQ Item -->
                </div>
        </div>
</body>

</html>