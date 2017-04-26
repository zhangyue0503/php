@extends('/backyard/backyard')
@section('content')
    <div class="container">
        <div class="row row-offcanvas row-offcanvas-right">
            <div class="col-xs-12 col-sm-9">
                <p class="pull-right visible-xs">
                    <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
                </p>
                <h3>笔记类别信息列表</h3>
                <button type="button" class="btn btn-primary" data-toggle="offcanvas" onclick="windows.location='/web/categoryadd'">添加分类</button>
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>ID号</th>
                        <th>类别名称</th>
                        <th>笔记数量</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($attributes['catList'] as $vo){
                        echo "<tr>";
                        echo "<td>{$vo['id']}</td>";
                        echo "<td>{$vo['name']}</td>";
                        echo "<td>{$vo['count']}</td>";
                        echo "<td><button type=\"button\" class=\"btn btn-primary\" onclick=\"window.location='/web/noteslist/{$vo['id']}'\">浏览笔记</button> </td>";
                        echo "<td><button type=\"button\" class=\"btn btn-primary\" onclick=\"window.location='/web/deletecat/{$vo['id']}'\">删除分类</button> </td>";
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection