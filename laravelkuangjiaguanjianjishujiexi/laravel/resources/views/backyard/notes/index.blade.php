@extends('/backyard/backyard')
@section('content')
    <div class="container">
        <div class="row row-offcanvas row-offcanvas-right">
            <div class="col-xs-12 col-sm-9">
                <p class="pull-right visible-xs">
                    <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
                </p>
                <h3>笔记列表</h3>
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>ID号</th>
                        <th>标题</th>
                        <th>类别</th>
                        <th>发布时间</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($attributes['recordsList'] as $vo){
                        echo "<tr>";
                        echo "<td>{$vo['id']}</td>";
                        echo "<td>{$vo['title']}</td>";
                        echo "<td>{$vo['cid']}</td>";
                        echo "<td>".date("Y-m-d",$vo['addtime'])."</td>";
                        echo "<td>".(($vo['state']==1)?"启用":"禁用")."</td>";
                        echo "<td>
<a href=\"/web/noteshow/{$vo['id']}\"><span class=\"glyphicon glyphicon-search\" title=\"详情\"></span></a>&nbsp;&nbsp;
<a href=\"/web/noteedit/{$vo['id']}\"><span class=\"glyphicon glyphicon-search\" title=\"编辑\"></span></a>&nbsp;&nbsp;
<a href=\"/web/deletenote/{$vo['id']}\"><span class=\"glyphicon glyphicon-search\" title=\"删除\"></span></a>&nbsp;&nbsp;
</td>";
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            @include('backyard.include.sidebar')
        </div>
    </div>
@endsection