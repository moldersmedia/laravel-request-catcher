<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">

    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" rel="home" href="{{route('request-catcher.requests.index')}}">Request Catcher</a>
    </div>

    <div class="collapse navbar-collapse">

        <ul class="nav navbar-nav">
            {{--<li><a href="#">Link</a></li>--}}
            {{--<li><a href="#">Link</a></li>--}}
            {{--<li><a href="#">Link</a></li>--}}
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Actions <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="{{route('request-catcher.requests.delete-all')}}">Delete log</a></li>
                    {{--<li><a href="#">Another action</a></li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li><a href="#">Separated link</a></li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li><a href="#">One more separated link</a></li>--}}
                </ul>
            </li>
        </ul>
        {{--<button type="button" class="btn btn-default navbar-btn">Button</button>--}}
        {{--<div class="col-sm-3 col-md-3 pull-right">--}}
            {{--<div class="navbar-text">Text</div>--}}
            {{--<form class="navbar-form" role="search">--}}
                {{--<div class="input-group">--}}
                    {{--<input type="text" class="form-control" placeholder="Search" name="srch-term" id="srch-term">--}}
                    {{--<div class="input-group-btn">--}}
                        {{--<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</form>--}}
        {{--</div>--}}

    </div>
</div>