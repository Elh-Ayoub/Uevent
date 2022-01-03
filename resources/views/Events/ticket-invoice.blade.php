<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Create event - {{env('APP_NAME')}}</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/invoice.css') }}">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo.png')}}"/>
</head>
<body class="hold-transition sidebar-collapse layout-top-nav">
<div class="wrapper">
    <table class="body-wrap">
        <tbody><tr>
            <td></td>
            <td class="container" width="600">
                <div class="content">
                    <table class="main" width="100%" cellpadding="0" cellspacing="0">
                        <tbody><tr>
                            <td class="content-wrap aligncenter">
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tbody><tr>
                                        <td class="content-block">
                                            <h2>Thanks for subscription to event</h2>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block">
                                            <table class="invoice">
                                                <tbody>
                                                    <tr class="row justify-content-between px-2 text-muted">
                                                        <td class="text-bold">{{$author->full_name}}</td><td>{{$ticket->created_at}}</td>
                                                    </tr>
                                                    <tr class="text-muted">
                                                        <td>Invoice #{{$ticket->id}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table class="invoice-items" cellpadding="0" cellspacing="0">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="text-info">Event</td>
                                                                        <td class="alignright text-muted">{{$event->title}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-info">Ticket price</td>
                                                                        <td class="alignright text-muted">{{($event->ticket_price == 0) ? ("Free") : ($event->ticket_price)}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-info">Event begins at</td>
                                                                        <td class="alignright text-muted">{{$event->begins_at}}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block">
                                            Uevent &copy; Ucode 2021
                                        </td>
                                    </tr>
                                </tbody></table>
                            </td>
                        </tr>
                    </tbody></table>
                    <div class="footer">
                        <table width="100%">
                            <tbody><tr>
                                <td class="aligncenter content-block">Questions? Email <a href="mailto:">{{env('MAIL_FROM_ADDRESS')}}</a></td>
                            </tr>
                        </tbody></table>
                    </div></div>
            </td>
            <td></td>
            </tr>
        </tbody>
    </table>
</div>
<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- jQuery UI -->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
@if(Session::get('fail'))
<script>
  $(function() {
    toastr.error("{{Session::get('fail')}}")
  });
</script>
@endif
@if(Session::get('success'))
<script>
  $(function() {
    toastr.success("{{Session::get('success')}}")
  });
</script>
@endif
@if(Session::get('fail-arr'))
    @foreach(Session::get('fail-arr') as $key => $err)
    <script>
      $(function() {
        toastr.error("{{$err[0]}}");
      });
    </script>
    @endforeach
@endif
</body>
</html>