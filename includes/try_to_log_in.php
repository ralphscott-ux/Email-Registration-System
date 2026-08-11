<h1>You are not logged in yet.</h1>
<h2>Log in:</h2>
<form method="POST" action="<?php echo "../" . $page_template; ?>">
    <input type="hidden" name="form_type" value="login" />
    <input type="shown" name="username" required />
    <input type="shown" name="email" required />
    <input type="shown" name="dob" required />
    <input type="shown" name="email" required />
</form>
<h2>Sign up:</h2>
<form method="POST" action="<?php echo "../" . $page_template; ?>">
    <input type="hidden" name="form_type" value="signup" />
    <input type="shown" name="username" required />
    <input type="shown" name="email" required />
</form>