<form action="https://www.payfast.co.za/eng/process" method="post">
    <!-- merchant -->
    <input type="hidden" name="merchant_id" value="10000100">
    <input type="hidden" name="merchant_key" value="46f0cd694581a">
    <input type="hidden" name="return_url" value="https://www.example.com/success">
    <input type="hidden" name="cancel_url" value="https://www.example.com/cancel">
    <input type="hidden" name="notify_url" value="https://www.example.com/notify">
    <!-- customer -->
    <input type="hidden" name="name_first" value="John">
    <input type="hidden" name="name_last" value="Doe">
    <input type="hidden" name="email_address" value="john@doe.com">
    <input type="hidden" name="cell_number" value="0823456789">
    <!-- transaction -->
    <input type="hidden" name="m_payment_id" value="01AB">
    <input type="hidden" name="amount" value="100.00">
    <input type="hidden" name="item_name" value="Test Item">
    <!-- submit -->
    <input type="submit">
</form>