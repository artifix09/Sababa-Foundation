document.getElementById('donationForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission

    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const donationAmount = document.getElementById('donationAmount').value;
    const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked')?.value;
    const country = document.getElementById('country').value; // Get the country selected by the user

    // Simple validation
    if (!name || !email || !donationAmount || !paymentMethod) {
        alert("Please fill in all required fields.");
        return;
    }

    // Show payment method options once amount is entered
    if (donationAmount) {
        document.getElementById('paymentOptions').style.display = 'block';
    }

    // Process based on the payment method
    if (paymentMethod === 'paypal') {
        processPayPalPayment(donationAmount, country, name, email);
    } else if (paymentMethod === 'card') {
        processCardPayment(donationAmount, country, name, email);
    } else if (paymentMethod === 'easypaisa') {
        const easypaisaNumber = document.getElementById('easypaisaNumber').value;
        if (!easypaisaNumber) {
            alert("Please enter your EasyPaisa number.");
            return;
        }
        processEasyPaisaPayment(donationAmount, easypaisaNumber, country, name, email);
    } else {
        alert("Invalid payment method.");
    }
});

// Show payment method options when user proceeds
document.getElementById('proceedButton').addEventListener('click', function() {
    const donationAmount = document.getElementById('donationAmount').value;

    if (donationAmount) {
        document.getElementById('paymentOptions').style.display = 'block';
    } else {
        alert("Please enter a donation amount.");
    }
});

// Show EasyPaisa input field if selected
document.getElementById('easypaisa').addEventListener('change', function() {
    document.getElementById('easypaisaInput').style.display = 'block';
});

// Payment Handling Functions

function processPayPalPayment(amount, country, name, email) {
    let currency = country === 'pakistan' ? 'PKR' : 'USD';
    alert(`Redirecting to PayPal for payment of ${currency} ${amount}`);
    // You can replace this with PayPal integration (PayPal API)
    // Redirect to PayPal
}

function processCardPayment(amount, country, name, email) {
    let currency = country === 'pakistan' ? 'PKR' : 'USD';
    alert(`Redirecting to card payment gateway for payment of ${currency} ${amount}`);
    // You can replace this with a Card payment gateway integration (e.g., Stripe)
}

function processEasyPaisaPayment(amount, easypaisaNumber, country, name, email) {
    let currency = country === 'pakistan' ? 'PKR' : 'USD';
    alert(`Processing EasyPaisa payment of ${currency} ${amount} from number: ${easypaisaNumber}`);
    // You can replace this with EasyPaisa integration API
}
