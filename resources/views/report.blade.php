<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Solis Booking System</title>

  <style>
    html,
    body {
      margin: 10px;
      padding: 10px;
      font-family: sans-serif;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    p,
    span,
    label {
      font-family: sans-serif;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 0px !important;
    }

    table thead th {
      height: 28px;
      text-align: left;
      font-size: 16px;
      font-family: sans-serif;
    }

    table,
    th,
    td {
      border: 1px solid #ddd;
      padding: 8px;
      font-size: 14px;
    }

    .heading {
      font-size: 24px;
      margin-top: 12px;
      margin-bottom: 12px;
      font-family: sans-serif;
    }

    .small-heading {
      font-size: 18px;
      font-family: sans-serif;
    }

    .total-heading {
      font-size: 18px;
      font-weight: 700;
      font-family: sans-serif;
    }

    .order-details tbody tr td:nth-child(1) {
      width: 20%;
    }

    .order-details tbody tr td:nth-child(3) {
      width: 20%;
    }

    .text-start {
      text-align: left;
    }

    .text-end {
      text-align: right;
    }

    .text-center {
      text-align: center;
    }

    .company-data span {
      margin-bottom: 4px;
      display: inline-block;
      font-family: sans-serif;
      font-size: 14px;
      font-weight: 400;
    }

    .no-border {
      border: 1px solid #fff !important;
    }

    .bg-blue {
      background-color: #414ab1;
      color: #fff;
    }
  </style>
</head>

<body>
  <table class="order-details">
    <thead>
      <tr>
        <th width="50%" colspan="2">
          <img style="width: 8rem; height: 4rem; text-align: left" src="{{public_path().'/logo.png'}}" alt="" />
          <h2 class="text-start">Assigned Tasks Report</h2>
        </th>
        <th width="50%" colspan="2" class="text-end company-data">
          <span>Date: {{date('d/m/Y')}}</span> <br />
          <span>Phone : +254 *******</span> <br />
          <span>Mobile : +254 ***** /+254 ********</span> <br />
          <span>Address: , Nairobi
          </span>
          <br />
        </th>
      </tr>
  </table>
  <table>
    <thead>
      <tr>
        <th class="no-border text-start heading" colspan="5">Tasks Details</th>
      </tr>
      <tr class="bg-blue">
        <th>No.</th>
        <th>Task</th>
        <th>User</th>
        <th>Start Date</th>
        <th>Due Date</th>
        <th>Remarks</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      @php
      $total_price=0;
      $total_hours=0;
      $counter=1;
      $status=1;
      @endphp
      @foreach($data as $dataItem)
      <tr>

        <td width="2%">{{$counter}}</td>
        <td width="15%">{{$dataItem['task']['name']}}</td>
        <td width="15%">{{$dataItem['user']['name']}}</td>
        <td width="15%">{{$dataItem['task']['start_time']}}</td>
        <td width="15%">{{$dataItem['task']['due_date']}}</td>
        <td width="23%">{{$dataItem['remarks']}}</td>
        <td width="15%">{{$dataItem['task']['status']['name']}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <br />
  <p class="text-center"></p>
</body>

</html>