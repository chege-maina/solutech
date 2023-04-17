<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{csrf_token()}}" />
  <title>{{env('APP_NAME')}}</title>
</head>

<body style="background-color:#f9fafb;">
  <div style="width: 100%; margin: 10px">
    <div style="width: 95%; text-align: left; margin: 2px">
      <img style="width: 8rem; height: 4rem; text-align: left" src="{{$message->embed(public_path().'/logo.png')}}" alt="" />
    </div>
    <div style="width: 95%; margin: 10px">
      <p class="text-2xl font-bold" style="font-weight: bold; font-size: 1rem">
        {{$mailData['title']}}
      </p>
    </div>
    <div style="width: 95%; margin: 1px 0px 1px 10px; padding: 1px 0px 1px 0px">
      <p style="font-weight: normal; font-size: 1rem;">Hi {{$mailData['name']}},</p>
    </div>
    <div style="
          width: 95%;
          margin: 2px;
          padding: 5px 10px;
          box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
          transition: 0.3s;
          border-radius: 5px;
        ">
      <p style="font-weight: normal; font-size: 1rem">
        {{$mailData['message']}}
        <span style="font-weight: bold">
          {{$mailData['bold']}}</span>
      </p>
      <div style="width: 95%; padding: 1px 0px 1px 0px">
        <a href="{{$mailData['link']}}" style="
              font-weight: normal;
              font-size: 1rem;
              color: #002d74;
              text-decoration: none;
            ">{{$mailData['linktext']}}</a>
      </div>

      <p style="font-weight: normal; font-size: 1rem">Regards,</p>
      <p style="font-weight: normal; font-size: 1rem">SOLUTECH</p>
      <p style="
            font-weight: normal;
            font-size: 0.7rem;
            width: 100%;
            text-align: center;
          ">
        You should only be receiving this email if you showed interested in
        using services from SOLUTECH
      </p>
    </div>
  </div>
</body>

</html>