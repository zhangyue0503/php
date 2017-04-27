@extends('/backyard/backyard')
@section('content')
<div class="container">
    <div class="row row-offcanvas row-offcanvas-right">
        <div class="col-xs-12 col-sm-9">
            <p class="pull-right visible-xs">
                <button type="button" class="btn btn-primary btx-xs" data-toggle="offcanvas">Toggle nav</button>
            </p>
            <h3>笔记类别添加</h3>
            <input type="hidden" id="domain" value="http://7u2r8g.com1.z0.glb.clouddn.com/">
            <input type="hidden" id="uptoken_url" value="/admin.php/uptoken">
            <form class="form-horizontal col-sm-10" role="form" action="/web/categoryadd" method="post">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">类别名称</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" id="inputEmail3" placeholder="text">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" class="btn btn-default" value="添加"/>
                    </div>
                </div>
            </form>
        </div>
        @include('backyard.include.sidebar')
    </div>
</div>
@endsection