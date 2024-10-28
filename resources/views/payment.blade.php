<!-- resources/views/payment.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stripe Payment</title>
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        /* General body styles */
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f7f8fc;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        /* Payment form container */
        .payment-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        /* Input and button styles */
        .form-group {
            margin-bottom: 20px;
        }
        #card-element {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        #payment-submit {
            width: 100%;
            padding: 12px;
            background-color: #6772e5;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        #payment-submit:hover {
            background-color: #5469d4;
        }
        /* Error message styles */
        .error {
            color: red;
            font-size: 0.9em;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <h2>Stripe Payment</h2>
        <form action="{{ route('process.payment') }}" method="POST" id="payment-form">
            @csrf
            <input type="hidden" name="amount" value="100"> <!-- Amount in dollars -->

            <div class="form-group">
                <label for="card-element">Credit or debit card</label>
                <div id="card-element"></div>
                <div id="card-errors" class="error" role="alert"></div>
            </div>

            <button type="submit" id="payment-submit">Pay $100</button>
        </form>
    </div>

    <script>
        const stripe = Stripe("{{ config('services.stripe.key') }}");
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        // Handle form submission
        document.getElementById('payment-form').addEventListener('submit', async (event) => {
            event.preventDefault();

            const { token, error } = await stripe.createToken(cardElement);
            const errorDiv = document.getElementById('card-errors');
            if (error) {
                errorDiv.textContent = error.message;
            } else {
                errorDiv.textContent = '';
                const form = document.getElementById('payment-form');
                const hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);
                form.submit();
            }
        });
    </script>
</body>
</html>
