<form action="<?php echo urldecode($_GET['completeUrl']); ?>" method="post" style="display: flex; flex-direction: column; width:30%;">
    <img src='<?php echo urldecode($_GET['qrSrc']); ?>'>

    <input type="hidden" name="transactionId" value="<?php echo $_GET['transactionId']; ?>">
    <button type="submit">I Paid, Complete My Order.</button>
</form>