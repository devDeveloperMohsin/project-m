<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>
  <h1>Hi</h1>
  <p>
    You have been invited to join the <strong>{{ $data->for }}</strong> by {{ $data->by }}.
    Please click the below button to join.
  </p>
  <a href="{{ $data->link }}">Join Now</a>
  
  <p>If the button does not work you can click here</p>
  <a href="{{ $data->link }}">{{ $data->link }}</a>
</body>

</html>
