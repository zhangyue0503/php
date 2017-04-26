@extends('/backyard/backyard')
@section('content')
    <div class="container">
        <div class="row row-offcanvas row-offcanvas-right">
            <div class="col-xs-12 col-sm-9">
                <p class="pull-right visible-xs">
                    <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
                </p>
                <h3>会员信息列表</h3>
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>ID号</th>
                        <th>账号</th>
                        <th>注册时间</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach($attributes['userList'] as $vo){
                            echo "<tr>";
                            echo "<td>{$vo['id']}</td>";
                            echo "<td>{$vo['username']}</td>";
                            echo "<td>".date("Y-m-d",$vo['addtime'])."</td>";
                            echo "<td>".(($vo['state']==1)?"启用":"禁用")."</td>";
                            echo "<td><a href=\"/backyard/userInfo?uid={$vo['id']}\"><span class=\"glyphicon glyphicon-search\" title=\"详情\"></span></a>&nbsp;&nbsp;</td>";
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
