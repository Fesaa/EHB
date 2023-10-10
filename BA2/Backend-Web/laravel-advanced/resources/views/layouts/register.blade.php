
<div class="login-errors">
    @if($errors->any())
        <div>
            <ul>
                @foreach($errors->all() as $error)
                    <li class="login-error">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>


<form action="{{ route('register') }}" method="post">
    @csrf

    <label for="name">Name:</label><br>
    <input type="text" id="name" name="user"><br>

    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email"><br>

    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password"><br>

    <input type="submit" value="Login">
</form>
