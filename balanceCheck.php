<?php include 'paypalBalance.php'; ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>PayPal Balance</title>
  <link rel="icon" type="image/png" href="icon.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<?php include 'includes/bgcolor.html'; ?>
<div class="d-flex justify-content-end align-items-end p-3 top-0 start-0">
  <button type="button" class="btn btn-light btn-sm border" onclick="window.history.back();">Close</button>
</div>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-dark text-white text-center">
          <h4 class="mb-0">PayPal Balance</h4>
        </div>
        <div class="card-body text-center p-4">
          <h1 id="balance" class="fw-bold text-success">
            ₱<?php echo $balanceValue . " " . $balanceCurrency; ?>
          </h1>
          <p class="text-muted">Sandbox Account</p>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
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

        // Refresh balance after donation
        fetch('paypalBalance.php')
          .then(res => res.text())
          .then(balance => {
            document.getElementById('balance').innerHTML = "₱" + balance;
          });
      });
    }
  }).render('#paypal-button-container');
</script>

</html>