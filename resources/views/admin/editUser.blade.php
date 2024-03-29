@extends('admin.layouts')
@section('css')
    <link href="/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" style="padding-top:0;">
        <!-- BEGIN PAGE BASE CONTENT -->
        <div class="tab-pane active">
            <div class="portlet light bordered">
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <form action="{{url('admin/editUser')}}" method="post" class="form-horizontal" onsubmit="return do_submit();">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="portlet light bordered">
                                        <div class="portlet-title"  style="width:100%">
                                            <div class="caption" style="width:100%">
                                                <div class="row">
                                                    <span class="caption-subject font-dark bold uppercase col-md-4">账号信息</span>
                                                    <div class="text-right col-md-8" style="">
                                                        <button type="button" class="btn btn-sm btn-danger btn-outline" onclick="switchToUser()">切换身份</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="form-group">
                                                <label for="username" class="col-md-3 control-label">用户名</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" name="username" value="{{$user->username}}" id="username" autocomplete="off" autofocus required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="password" class="col-md-3 control-label">密码</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" name="password" value="" id="password" placeholder="不填则不变" autocomplete="off" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="level" class="col-md-3 control-label">级别</label>
                                                <div class="col-md-8">
                                                    <select class="form-control" name="level" id="level">
                                                        @if(!$level_list->isEmpty())
                                                            @foreach($level_list as $level)
                                                                <option value="{{$level->level}}" {{$user->level == $level->level ? 'selected' : ''}}>{{$level->level_name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="balance" class="col-md-3 control-label">余额</label>
                                                <div class="col-md-5">
                                                    <p class="form-control-static"> {{$user->balance}} </p>
                                                </div>
                                                <div class="col-md-3">
                                                    <div style="float:right;">
                                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#handle_user_balance">充值</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">有效期</label>
                                                <div class="col-md-8">
                                                    <div class="input-group input-large input-daterange">
                                                        <input type="text" class="form-control" name="enable_time" value="{{$user->enable_time}}" id="enable_time" autocomplete="off" />
                                                        <span class="input-group-addon"> 至 </span>
                                                        <input type="text" class="form-control" name="expire_time" value="{{$user->expire_time}}" id="expire_time" autocomplete="off" />
                                                    </div>
                                                    <span class="help-block"> 留空默认为一年 </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="status" class="col-md-3 control-label">账户状态</label>
                                                <div class="col-md-8">
                                                    <div class="mt-radio-inline">
                                                        <label class="mt-radio">
                                                            <input type="radio" name="status" value="1" {{$user->status == '1' ? 'checked' : ''}} /> 正常
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-radio">
                                                            <input type="radio" name="status" value="0" {{$user->status == '0' ? 'checked' : ''}} /> 未激活
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-radio">
                                                            <input type="radio" name="status" value="-1" {{$user->status == '-1' ? 'checked' : ''}} /> 禁用
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="is_admin" class="col-md-3 control-label">管理员</label>
                                                <div class="col-md-8">
                                                    <div class="mt-radio-inline">
                                                        <label class="mt-radio">
                                                            <input type="radio" name="is_admin" value="1" {{$user->is_admin == '1' ? 'checked' : ''}} /> 是
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-radio">
                                                            <input type="radio" name="is_admin" value="0" {{$user->is_admin == '0' ? 'checked' : ''}} /> 否
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
                                                            <option value="{{$label->id}}" @if(in_array($label->id, $user->labels)) selected @endif>{{$label->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <label for="remark" class="col-md-3 control-label">备注</label>
                                                <div class="col-md-8">
                                                    <textarea class="form-control" rows="3" name="remark" id="remark">{{$user->remark}}</textarea>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <label for="referral_uid" class="col-md-3 control-label">邀请人</label>
                                                <div class="col-md-8">
                                                    <p class="form-control-static"> {{empty($user->referral) ? '无邀请人' : $user->referral->username}} </p>
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
                                                        <input type="text" class="form-control" name="transfer_enable" value="{{$user->transfer_enable}}" id="transfer_enable" autocomplete="off" required>
                                                        <span class="input-group-addon">GB</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="enable" class="col-md-3 control-label">代理状态</label>
                                                <div class="col-md-8">
                                                    <div class="mt-radio-inline">
                                                        <label class="mt-radio">
                                                            <input type="radio" name="enable" value="1" {{$user->enable == '1' ? 'checked' : ''}}> 启用
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-radio">
                                                            <input type="radio" name="enable" value="0" {{$user->enable == '0' ? 'checked' : ''}}> 禁用
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
                                                        <input type="text" class="form-control" name="speed_limit_per_con" value="{{$user->speed_limit_per_con}}" id="speed_limit_per_con" autocomplete="off">
                                                        <span class="input-group-addon">Byte</span>
                                                    </div>
                                                    <span class="help-block"> 为 0 时不限速 </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="speed_limit_per_user" class="col-md-3 control-label">单用户限速</label>
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="speed_limit_per_user" value="{{$user->speed_limit_per_user}}" id="speed_limit_per_user" autocomplete="off">
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
                                                        <input class="form-control" type="text" name="vmess_id" value="{{$user->vmess_id}}" id="vmess_id" autocomplete="off" />
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

            <!-- 余额充值 -->
            <div id="handle_user_balance" class="modal fade" tabindex="-1" data-focus-on="input:first" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" style="width:300px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">充值</h4>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger" style="display: none;" id="msg"></div>
                            <!-- BEGIN FORM-->
                            <form action="#" method="post" class="form-horizontal">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label for="amount" class="col-md-4 control-label"> 充值金额 </label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="amount" id="amount" placeholder="填入负值则会扣余额" onkeydown="if(event.keyCode==13){return false;}">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- END FORM-->
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn dark btn-outline">关闭</button>
                            <button type="button" class="btn red btn-outline" onclick="return handleUserBalance();">充值</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE BASE CONTENT -->
    </div>
    <!-- END CONTENT BODY -->
@endsection
@section('script')
    <script src="/assets/global/plugins/laydate/laydate.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>

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

        // 切换用户身份
        function switchToUser() {
            $.ajax({
                'url': "{{url("/admin/switchToUser")}}",
                'data': {
                    'user_id': '{{$user->id}}',
                    '_token': '{{csrf_token()}}'
                },
                'dataType': "json",
                'type': "POST",
                success: function (ret) {
                    layer.msg(ret.message, {time: 1000}, function () {
                        if (ret.status == 'success') {
                            window.location.href = "/";
                        }
                    });
                }
            });
        }

        // ajax同步提交
        function do_submit() {
            var _token = '{{csrf_token()}}';
            var id = '{{Request::get('id')}}';
            var username = $('#username').val();
            var password = $('#password').val();
            var balance = $('#balance').val();
            var status = $("input:radio[name='status']:checked").val();
            var labels = $('#labels').val();
            var enable_time = $('#enable_time').val();
            var expire_time = $('#expire_time').val();
            var is_admin = $("input:radio[name='is_admin']:checked").val();
            var remark = $('#remark').val();
            var level = $("#level option:selected").val();
            var transfer_enable = $('#transfer_enable').val();
            var enable = $("input:radio[name='enable']:checked").val();
            var speed_limit_per_con = $('#speed_limit_per_con').val();
            var speed_limit_per_user = $('#speed_limit_per_user').val();
            var vmess_id = $('#vmess_id').val();

            $.ajax({
                type: "POST",
                url: "{{url('admin/editUser')}}",
                async: false,
                data: {
                    _token:_token,
                    id:id,
                    username: username,
                    password:password,
                    balance:balance,
                    status:status,
                    labels:labels,
                    enable_time:enable_time,
                    expire_time:expire_time,
                    is_admin:is_admin,
                    remark:remark,
                    level:level,
                    transfer_enable:transfer_enable,
                    enable:enable,
                    speed_limit_per_con:speed_limit_per_con,
                    speed_limit_per_user:speed_limit_per_user,
                    vmess_id: vmess_id
                },
                dataType: 'json',
                success: function (ret) {
                    if (ret.status == 'success') {
                        layer.confirm('更新成功，是否返回？', {icon: 1, title:'提示'}, function(index) {
                            window.location.href = '{{url('admin/userList?page=') . Request::get('page')}}';

                            layer.close(index);
                        });
                    } else {
                        layer.msg(ret.message, {time:1000});
                    }
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

        // 余额充值
        function handleUserBalance() {
            var amount = $("#amount").val();
            var reg = /^(\-?)\d+(\.\d+)?$/; //只可以是正负数字

            if (amount == '' || amount == 0 || !reg.test(amount)) {
                $("#msg").show().html("请输入充值金额");
                $("#name").focus();
                return false;
            }

            $.ajax({
                url:'{{url('admin/handleUserBalance')}}',
                type:"POST",
                data:{_token:'{{csrf_token()}}', user_id:'{{Request::get('id')}}', amount:amount},
                beforeSend:function(){
                    $("#msg").show().html("充值中...");
                },
                success:function(ret){
                    if (ret.status == 'fail') {
                        $("#msg").show().html(ret.message);
                        return false;
                    } else {
                        layer.msg(ret.message, {time:1000}, function() {
                            if (ret.status == 'success') {
                                $("#handle_user_balance").modal("hide");
                                window.location.reload();
                            }
                        });
                    }
                },
                error:function(){
                    $("#msg").show().html("请求错误，请重试");
                },
                complete:function(){}
            });
        }
    </script>
@endsection