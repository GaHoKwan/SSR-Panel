@extends('admin.layouts')
@section('css')
    <link href="/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" style="padding-top:0;">
        <!-- BEGIN PAGE BASE CONTENT -->
        <div class="tab-pane">
            <div class="portlet light bordered">
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <form action="{{url('admin/addUser')}}" method="post" class="form-horizontal" onsubmit="return do_submit();">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="portlet light bordered">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <span class="caption-subject font-dark bold uppercase">账号信息</span>
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="form-group">
                                                <label for="username" class="col-md-3 control-label">用户名</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" name="username" id="username" placeholder="" autocomplete="off" autofocus required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="password" class="col-md-3 control-label">密码</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" name="password" value="" id="password" placeholder="留空则自动生成随机密码" autocomplete="off" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="balance" class="col-md-3 control-label">级别</label>
                                                <div class="col-md-8">
                                                    <select class="form-control" name="level" id="level">
                                                        @if(!$level_list->isEmpty())
                                                            @foreach($level_list as $ele)
                                                                <option value="{{$ele->level}}">{{$ele->level_name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">有效期</label>
                                                <div class="col-md-8">
                                                    <div class="input-group input-large input-daterange">
                                                        <input type="text" class="form-control" name="enable_time" id="enable_time" autocomplete="off" />
                                                        <span class="input-group-addon"> 至 </span>
                                                        <input type="text" class="form-control" name="expire_time" id="expire_time" autocomplete="off" />
                                                    </div>
                                                    <span class="help-block"> 留空默认为一年 </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="status" class="col-md-3 control-label">账户状态</label>
                                                <div class="col-md-8">
                                                    <div class="mt-radio-inline">
                                                        <label class="mt-radio">
                                                            <input type="radio" name="status" value="1" checked /> 正常
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-radio">
                                                            <input type="radio" name="status" value="0" /> 未激活
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-radio">
                                                            <input type="radio" name="status" value="-1" /> 禁用
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <label for="labels" class="col-md-3 control-label">标签</label>
                                                <div class="col-md-8">
                                                    <select id="labels" class="form-control select2-multiple" name="labels[]" multiple>
                                                        @foreach($label_list as $label)
                                                            <option value="{{$label->id}}" {{in_array($label->id, $initial_labels) ? 'selected' : ''}}>{{$label->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <label for="remark" class="col-md-3 control-label">备注</label>
                                                <div class="col-md-8">
                                                    <textarea class="form-control" rows="3" name="remark" id="remark"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="portlet light bordered">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <span class="caption-subject font-dark bold">代理信息</span>
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="form-group">
                                                <label for="transfer_enable" class="col-md-3 control-label">可用流量</label>
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="transfer_enable" value="1024" id="transfer_enable" autocomplete="off" required>
                                                        <span class="input-group-addon">GB</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="enable" class="col-md-3 control-label">代理状态</label>
                                                <div class="col-md-8">
                                                    <div class="mt-radio-inline">
                                                        <label class="mt-radio">
                                                            <input type="radio" name="enable" value="1" checked /> 启用
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-radio">
                                                            <input type="radio" name="enable" value="0" /> 禁用
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <label for="speed_limit_per_con" class="col-md-3 control-label">单连接限速</label>
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="speed_limit_per_con" value="10737418240" id="speed_limit_per_con" autocomplete="off" />
                                                        <span class="input-group-addon">Byte</span>
                                                    </div>
                                                    <span class="help-block"> 为 0 时不限速 </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="speed_limit_per_user" class="col-md-3 control-label">单用户限速</label>
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="speed_limit_per_user" value="10737418240" id="speed_limit_per_user" autocomplete="off" />
                                                        <span class="input-group-addon">Byte</span>
                                                    </div>
                                                    <span class="help-block"> 为 0 时不限速 </span>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <label for="vmess_id" class="col-md-3 control-label">VMess UUID</label>
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <input class="form-control" type="text" name="vmess_id" value="{{createGuid()}}" id="vmess_id" autocomplete="off" />
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-success" type="button" onclick="makeVmessId()"> <i class="fa fa-refresh"></i> </button>
                                                        </span>
                                                    </div>
                                                    <span class="help-block"> V2Ray的账户ID </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn green">提 交</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
        <!-- END PAGE BASE CONTENT -->
    </div>
    <!-- END CONTENT BODY -->
@endsection
@section('script')
    <script src="/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/laydate/laydate.js" type="text/javascript"></script>

    <script type="text/javascript">
        // 用户标签选择器
        $('#labels').select2({
            theme: 'bootstrap',
            placeholder: '设置后则可见相同标签的节点',
            allowClear: true
        });

        // 有效期-开始
        laydate.render({
            elem: '#enable_time'
        });

        // 有效期-结束
        laydate.render({
            elem: '#expire_time'
        });

        // ajax同步提交
        function do_submit() {
            var _token = '{{csrf_token()}}';
            var username = $('#username').val();
            var password = $('#password').val();
            var status = $("input:radio[name='status']:checked").val();
            var labels = $('#labels').val();
            var enable_time = $('#enable_time').val();
            var expire_time = $('#expire_time').val();
            var remark = $('#remark').val();
            var level = $("#level option:selected").val();
            var transfer_enable = $('#transfer_enable').val();
            var enable = $("input:radio[name='enable']:checked").val();
            var speed_limit_per_con = $('#speed_limit_per_con').val();
            var speed_limit_per_user = $('#speed_limit_per_user').val();
            var vmess_id = $('#vmess_id').val();

            $.ajax({
                type: "POST",
                url: "{{url('admin/addUser')}}",
                async: false,
                data: {
                    _token:_token,
                    username: username,
                    password:password,
                    status:status,
                    labels:labels,
                    enable_time:enable_time,
                    expire_time:expire_time,
                    remark:remark,
                    level:level,
                    transfer_enable:transfer_enable,
                    enable:enable,
                    speed_limit_per_con:speed_limit_per_con,
                    speed_limit_per_user:speed_limit_per_user,
                    vmess_id:vmess_id
                },
                dataType: 'json',
                success: function (ret) {
                    layer.msg(ret.message, {time:1000}, function() {
                        if (ret.status == 'success') {
                            window.location.href = '{{url('admin/userList')}}';
                        }
                    });
                }
            });

            return false;
        }

        // 生成随机VmessId
        function makeVmessId() {
            $.get("{{url('makeVmessId')}}",  function(ret) {
                $("#vmess_id").val(ret);
            });
        }
    </script>
@endsection