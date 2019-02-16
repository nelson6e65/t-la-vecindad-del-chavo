@php
$config = [
    'appName' => config('app.name'),
];

// $polyfills = [
//     'Promise',
//     'Object.assign',
//     'Object.values',
//     'Array.prototype.find',
//     'Array.prototype.findIndex',
//     'Array.prototype.includes',
//     'String.prototype.includes',
//     'String.prototype.startsWith',
//     'String.prototype.endsWith',
// ];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Styles --}}
    <link href="{{ mix('assets/css/app.css') }}" rel="stylesheet">

    <script>window.config = @json($config);</script>
  </head>

  <body>
    <div id="app">

      <style>
        .lds-ellipsis {
          display: inline-block;
          position: relative;
          width: 64px;
          height: 64px;
        }
        .lds-ellipsis div {
          position: absolute;
          top: 27px;
          width: 11px;
          height: 11px;
          border-radius: 50%;
          background: #000;
          animation-timing-function: cubic-bezier(0, 1, 1, 0);
        }
        .lds-ellipsis div:nth-child(1) {
          left: 6px;
          animation: lds-ellipsis1 0.6s infinite;
        }
        .lds-ellipsis div:nth-child(2) {
          left: 6px;
          animation: lds-ellipsis2 0.6s infinite;
        }
        .lds-ellipsis div:nth-child(3) {
          left: 26px;
          animation: lds-ellipsis2 0.6s infinite;
        }
        .lds-ellipsis div:nth-child(4) {
          left: 45px;
          animation: lds-ellipsis3 0.6s infinite;
        }
        @keyframes lds-ellipsis1 {
          0% {
            transform: scale(0);
          }
          100% {
            transform: scale(1);
          }
        }
        @keyframes lds-ellipsis3 {
          0% {
            transform: scale(1);
          }
          100% {
            transform: scale(0);
          }
        }
        @keyframes lds-ellipsis2 {
          0% {
            transform: translate(0, 0);
          }
          100% {
            transform: translate(19px, 0);
          }
        }

        .centered {
          position: fixed;
          top: 50%;
          left: 50%;
          /* bring your own prefixes */
          transform: translate(-50%, -50%);
        }

      </style>

      <div class="lds-ellipsis centered"><div></div><div></div><div></div><div></div></div>
    </div>

    {{-- Scripts --}}
    {{-- <script src="{{ mix('assets/js/manifest.js') }}"></script> --}}
    {{-- <script src="{{ mix('assets/js/vendor.js') }}"></script> --}}
    <script src="{{ mix('assets/js/app.js') }}"></script>
  </body>
</html>
