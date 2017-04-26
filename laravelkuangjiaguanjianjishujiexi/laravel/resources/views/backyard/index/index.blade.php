@extends('/backyard/backyard')
@section('content')
    <div class="container">
        <div class="row row-offcanvas row-offcanvas-right">
            <div class="col-xs-12 col-sm-9">
                <p class="pull-right visible-xs">
                    <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
                </p>
                <div class="jumbotron">
                    <h1>思维笔记</h1>
                    <p>思维笔记，记录你灵魂的变化。</p>
                </div>
            </div>
            @include('backyard.include.sidebar')
        </div>
    </div>
@endsection