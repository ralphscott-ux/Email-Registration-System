<?php require("includes/images.php"); ?>
<h1>Welcome to "Email registration system"!</h1>
Press one of the buttons on the nav bar to enter a certain page.
<h2>Profile:</h2>
<?php echo_image($profile, 100); ?><br>
<label for=username>Username:</label>
<p name=username><?php echo $username; ?></p>
<label for=email>Email address:</label>
<p name=email><?php echo $email; ?></p>
<label for=age>Age:</label>
<p name=age><?php
$now = new DateTime();
echo $now->diff($dateofbirth)->format("%Y years old");
?></p>