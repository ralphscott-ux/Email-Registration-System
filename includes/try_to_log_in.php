<h1>You are not logged in yet.</h1>
<h2>Log in:</h2>
<form method="POST" action="<?php echo $main_page; ?>">
    <input type="hidden" name="form_type" value="login" />
    <label for="username">Username:</label>
    <input type="text" name="username" required />
    <label for="email">Email:</label>
    <input type="text" name="email" required />
    <label for="password">Password:</label>
    <input type="password" name="password" required />
    <label for="dateofbirth">DOB:</label>
    <input type="date" name="dateofbirth" required />
    <button type="submit">Submit data</button>
</form>
<h2>Sign up:</h2>
<form method="POST" action="<?php echo $main_page; ?>">
    <input type="hidden" name="form_type" value="signup" />
    <label for="username">Username:</label>
    <input type="text" name="username" required />
    <label for="email">Email:</label>
    <input type="text" name="email" required />
    <label for="password">Password:</label>
    <input type="password" name="password" required />
    <label for="dateofbirth">DOB:</label>
    <input type="date" name="dateofbirth" required />
    <button type="submit">Submit data</button>
</form>