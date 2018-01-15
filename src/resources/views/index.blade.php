@extends('request-catcher::layout.master')

@section('content')
    <style>
        pre {
            white-space: pre-wrap; /* css-3 */
            white-space: -moz-pre-wrap; /* Mozilla, since 1999 */
            white-space: -pre-wrap; /* Opera 4-6 */
            white-space: -o-pre-wrap; /* Opera 7 */
            word-wrap: break-word; /* Internet Explorer 5.5+ */
        }
    </style>

    @if(session()->has('message'))
        <div class="alert alert-{{session()->get('alert', 'info')}}">
            {{session('message')}}
        </div>
    @endif
    <table class="table table-striped table-hover" style="max-width: 100%">
        <thead>
        <tr>
            <th>ID</th>
            <th>Redirects</th>
            <th>Status</th>
            <th>URL</th>
            <th>Secure</th>
            <th>Locale</th>
            <th>Method</th>
            <th>Date</th>
            <th>Successful at</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($requests as $request)
            <tr>
                <td>{{$request->id}}</td>
                <td>{{$request->total_paths}}</td>
                <td>{{$request->status_code}}</td>
                <td>{{$request->url}}</td>
                <td>{{$request->is_secure ? 'Yes' : 'No'}}</td>
                <td>{{$request->locale}}</td>
                <td>{{$request->method}}</td>
                <td>{{$request->created_at->format('d-m-Y H:i:s')}}</td>
                <td>{{$request->successful_at ? $request->successful_at->format('d-m-Y H:i:s') : ''}}</td>
                <td>
                    <a class="btn btn-xs btn-info show-data" data-row-id="{{$request->id}}">Show Input/Headers</a>
                    <a href="{{route('request-catcher.requests.resend', $request->id)}}" class="btn btn-xs btn-success">Resend</a>
                    <a href="{{route('request-catcher.requests.show', $request->id)}}" class="btn btn-xs btn-info">Show details</a>
                </td>
            </tr>
            <tr class="hidden toggle" data-row-id="{{$request->id}}">
                <td colspan="10">
<pre>
@php
print_r($request->input);
@endphp
</pre>
                </td>
            </tr>
            <tr class="hidden toggle" data-row-id="{{$request->id}}">
                <td colspan="10">
<pre>
@php print_r($request->headers) @endphp
</pre>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="row">
        <div class="col-md-12 text-center">
            {{$requests->links()}}
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(function () {
            $('.show-data').click(function () {
                var id = $(this).data('row-id');

                $('tr[data-row-id="' + id + '"]').toggleClass('hidden')
            });
        });
    </script>
@endsection
