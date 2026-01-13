<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Donations</title>
    <link rel="icon" type="image/png" href="icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body class="bg-secondary">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <div class="card shadow" style="font-size: 1.35rem;">
                    <div class="card-header bg-dark text-white text-center" style="font-size: 2.2rem; padding: 1.5rem 1rem;">
                        <h2 class="mb-0">Donation Drive</h2>
                    </div>
                    <div class="card-body p-5">
                        <form id="donation-form">
                            <div class="mb-4">
                                <label for="amount" class="form-label" style="font-size: 1.3rem;">Donation Amount (PHP)</label>
                                <input type="number" class="form-control form-control-lg" id="amount" name="amount" min="1" value="10" required style="font-size: 1.3rem; height: 3.2rem;">
                            </div>
                            <div id="paypal-button-container" class="mb-4"></div>
                        </form>
                        <div id="donation-success" class="alert alert-success d-none text-center" role="alert" style="font-size: 1.3rem;">
                            Thank you for your donation!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://www.paypal.com/sdk/js?client-id=AScI4_3SDMrltP0uA-w5PS9KDjk27hlGMs7q3x0VrXGJgiuTaoBXkatjqBCxe4FUiAP2vP6ttxpRSAW0&currency=PHP"></script>
    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                const amount = document.getElementById('amount').value;
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: amount,
                            currency_code: 'PHP'
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    document.getElementById('donation-form').classList.add('d-none');
                    document.getElementById('donation-success').classList.remove('d-none');
                });
            }
        }).render('#paypal-button-container');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>