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
    <tr>
        <td>{{$request->id}}</td>
        <td>{{$request->total_paths}}</td>
        <td>{{$request->status_code}}</td>
        <td>{{$request->url}}</td>
        <td>{{$request->is_secure ? 'Yes' : 'No'}}</td>
        <td>{{$request->locale}}</td>
        <td>{{$request->method}}</td>
        <td>{{$request->created_at->format('d-m-Y H:i:s')}}</td>
        <td>
            {{$request->successful_at ? $request->successful_at->format('d-m-Y H:i:s') : ''}}
        </td>
        <td>
            <a class="btn btn-xs btn-info show-data" data-row-id="{{$request->id}}">Show Input/Headers</a>
            @if($resend)
            <a href="{{route('request-catcher.requests.resend', $request->id)}}" class="btn btn-xs btn-success">Resend</a>
            @endif
            @if($show)
                <a href="{{route('request-catcher.requests.show', $request->id)}}" class="btn btn-xs btn-info">Show details</a>
            @endif
        </td>
    </tr>
    <tr class="hidden toggle" data-row-id="{{$request->id}}">
        <td colspan="{{$colspan ?? 10}}">
<pre>
@php
    print_r($request->input);
@endphp
</pre>
        </td>
    </tr>
    <tr class="hidden toggle" data-row-id="{{$request->id}}">
        <td colspan="{{$colspan ?? 10}}">
<pre>
@php print_r($request->headers) @endphp
</pre>
        </td>
    </tr>
    </tbody>
</table>