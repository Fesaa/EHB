<link rel="stylesheet" href="{{ asset("css/main.css") }}">
@include('content.header')

<div class="form-container">
    <form action="{{ route('register') }}" method="post" class="form">
        @csrf

        <label for="name">Name:</label><br>
        <input type="text" id="name" name="user"><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email"><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br>

        <p>Already have an account? <a href="{{ route('login') }}">Login</a> instead</p>

        <input type="submit" value="Register" class="form-confirm">
    </form>
</div>
<div class="errors-container">
    @if($errors->any())
        <div class="errors">
            <p>Cannot register</p>
            <ul>
                @foreach($errors->all() as $error)
                    <li class="error">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

