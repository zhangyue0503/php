@extends('/backyard/backyard')
@section('content')
<div class="container">
    <div class="row row-offcanvas row-offcanvas-right">
        <div class="col-xs-12 col-sm-9">
            <p clas="pull-right visible-xs">
                <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
            </p>
            <h3>修改笔记信息</h3>
            <input type="hidden" id="domain" value="http://7u2r8g.com1.z0.glb.clouddn.com/">
            <input type="hidden" id="uptoken_url" value="/admin.php/uptoken">
            <form class="form-horizontal col-sm-10" role="form" action="/web/notechange/{{$id}}" method="post">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">笔记标题</label>
                    <div class="col-sm-10">
                        <input type="text" name="title" class="form-control" id="inputEmail3" placeholder="text" value="{{$title}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">笔记类别</label>
                    <div class="col-sm-10">
                        <select name="cid">
                            <?php
                            foreach($attributes['cglist'] as $vo){
                                if($vo['id']==$cid){
                                    echo "<option value='{$vo['id']}' selected>{$vo['name']}</option>";
                                }else{
                                    echo "<option value='{$vo['id']}'>{$vo['name']}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">笔记内容</label>
                    <div class="col-sm-10">
                        <textarea cols="50" rows="10" name="content" value="{{$content}}"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" class="btn btn-default" value="更新"/>
                    </div>
                </div>
            </form>
        </div>
        @include('backyard.include.sidebar')
    </div>
</div>
@endsection