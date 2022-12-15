<p>Hello, {{ $email_data['name'] }}</p>
<p>Please verify your email below:</p>
<a href="http://127.0.0.1:8000/verify?code={{ $email_data['verification_code'] }}">Click Here!</a>