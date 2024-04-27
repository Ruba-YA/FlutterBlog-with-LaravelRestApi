<form method="POST" action="/register">
    @csrf
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" required>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>

    <label for="age_verification">Is age more than 18?</label>
    <input type="checkbox" name="age_verification" id="age_verification" value="1">

    <label>Gender:</label>
    <input type="radio" name="gender" value="male"> Male
    <input type="radio" name="gender" value="female"> Female

    <button type="submit">Submit</button>
</form>
