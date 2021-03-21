@extends('admin.layouts')
@section('css')
    <link href="/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" style="padding-top:0;">
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE BASE CONTENT -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="note note-info">
                            <p><strong>注意：</strong> 添加节点后自动生成的<code>ID</code>，即为该节点后端时nodeid的值</p>
                            <p>中转节点需要自行配置服务器端口转发，TCP阻断检测无效，务必填写域名； </p>
                            <p>NAT节点需要配置DDNS，TCP阻断检测无效，务必填写域名； </p>
                        </div>
                    </div>
                </div>
                <div class="portlet light bordered">
                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        <form action="{{url('admin/editNode')}}" method="post" class="form-horizontal" onsubmit="return do_submit();">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="portlet light bordered">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <span class="caption-subject font-dark bold uppercase">基础信息</span>
                                                </div>
                                            </div>
                                            <div class="portlet-body">
                                                <div class="form-group">
                                                    <label for="is_transit" class="col-md-3 control-label">中转</label>
                                                    <div class="col-md-8">
                                                        <div class="mt-radio-inline">
                                                            <label class="mt-radio">
                                                                <input type="radio" name="is_transit" value="1" {{$node->is_transit == '1' ? 'checked' : ''}}> 是
                                                                <span></span>
                                                            </label>
                                                            <label class="mt-radio">
                                                                <input type="radio" name="is_transit" value="0" {{$node->is_transit == '0' ? 'checked' : ''}}> 否
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="is_nat" class="col-md-3 control-label">NAT</label>
                                                    <div class="col-md-8">
                                                        <div class="mt-radio-inline">
                                                            <label class="mt-radio">
                                                                <input type="radio" name="is_nat" value="1" {{$node->is_nat == '1' ? 'checked' : ''}}> 是
                                                                <span></span>
                                                            </label>
                                                            <label class="mt-radio">
                                                                <input type="radio" name="is_nat" value="0" {{$node->is_nat == '0' ? 'checked' : ''}}> 否
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="name" class="col-md-3 control-label"> 节点名称 </label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" name="name" value="{{$node->name}}" id="name" placeholder="" autofocus required>
                                                        <input type="hidden" name="id" value="{{$node->id}}">
                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="server" class="col-md-3 control-label"> 域名 </label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" name="server" value="{{$node->server}}" id="server" placeholder="服务器域名地址，填则优先取域名地址">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="ip" class="col-md-3 control-label"> IPv4地址 </label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" name="ip" value="{{$node->ip}}" id="ip" placeholder="服务器IPv4地址" {{$node->is_nat ? 'readonly=readonly' : ''}} required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="ipv6" class="col-md-3 control-label"> IPv6地址 </label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" name="ipv6" value="{{$node->ipv6}}" id="ipv6" placeholder="服务器IPv6地址，填写则用户可见，域名无效" {{$node->is_nat ? 'readonly=readonly' : ''}}>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="ssh_port" class="col-md-3 control-label"> SSH端口 </label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" name="ssh_port" value="{{$node->ssh_port}}" id="ssh_port" placeholder="服务器SSH端口" required>
                                                        <span class="help-block">请务必正确填写此值，否则TCP阻断检测可能误报</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="traffic_rate" class="col-md-3 control-label"> 流量比例 </label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" name="traffic_rate" value="{{$node->traffic_rate}}" value="1.0" id="traffic_rate" placeholder="" required>
                                                        <span class="help-block"> 举例：0.1用100M结算10M，5用100M结算500M </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="labels" class="col-md-3 control-label">标签</label>
                                                    <div class="col-md-8">
                                                        <select id="labels" class="form-control select2-multiple" name="labels[]" multiple>
                                                            @foreach($label_list as $label)
                                                                <option value="{{$label->id}}" @if(in_array($label->id, $node->labels)) selected @endif>{{$label->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="group_id" class="col-md-3 control-label"> 所属分组 </label>
                                                    <div class="col-md-8">
                                                        <select class="form-control" name="group_id" id="group_id">
                                                            <option value="0">请选择</option>
                                                            @if(!$group_list->isEmpty())
                                                                @foreach($group_list as $group)
                                                                    <option value="{{$group->id}}" {{$node->group_id == $group->id ? 'selected' : ''}}>{{$group->name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="country_code" class="col-md-3 control-label"> 国家/地区 </label>
                                                    <div class="col-md-8">
                                                        <select class="form-control" name="country_code" id="country_code">
                                                            <option value="">请选择</option>
                                                            @if(!$country_list->isEmpty())
                                                                @foreach($country_list as $country)
                                                                    <option value="{{$country->country_code}}" {{$node->country_code == $country->country_code ? 'selected' : ''}}>{{$country->country_code}} - {{$country->country_name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="desc" class="col-md-3 control-label"> 描述 </label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" name="desc" value="{{$node->desc}}" id="desc" placeholder="简单描述">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sort" class="col-md-3 control-label">排序</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" name="sort" value="{{$node->sort}}" id="sort" placeholder="">
                                                        <span class="help-block"> 值越大排越前 </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="status" class="col-md-3 control-label">状态</label>
                                                    <div class="col-md-8">
                                                        <div class="mt-radio-inline">
                                                            <label class="mt-radio">
                                                                <input type="radio" name="status" value="1" {{$node->status == '1' ? 'checked' : ''}}> 正常
                                                                <span></span>
                                                            </label>
                                                            <label class="mt-radio">
                                                                <input type="radio" name="status" value="0" {{$node->status == '0' ? 'checked' : ''}}> 维护
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="portlet light bordered">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <span class="caption-subject font-dark bold">扩展信息</span>
                                                </div>
                                            </div>
                                            <div class="portlet-body">
                                                <!-- V2ray 设置 -->
                                                <div class="v2ray-setting">
                                                    <div class="form-group">
                                                        <label for="is_subscribe" class="col-md-3 control-label">订阅</label>
                                                        <div class="col-md-8">
                                                            <div class="mt-radio-inline">
                                                                <label class="mt-radio">
                                                                    <input type="radio" name="is_subscribe" value="1" {{$node->is_subscribe ? 'checked' : ''}}> 允许
                                                                    <span></span>
                                                                </label>
                                                                <label class="mt-radio">
                                                                    <input type="radio" name="is_subscribe" value="0" {{!$node->is_subscribe ? 'checked' : ''}}> 不允许
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="is_tcp_check" class="col-md-3 control-label">TCP阻断检测</label>
                                                        <div class="col-md-8">
                                                            <div class="mt-radio-inline">
                                                                <label class="mt-radio">
                                                                    <input type="radio" name="is_tcp_check" value="1" {{$node->is_tcp_check == '1' ? 'checked' : ''}}> 开启
                                                                    <span></span>
                                                                </label>
                                                                <label class="mt-radio">
                                                                    <input type="radio" name="is_tcp_check" value="0" {{$node->is_tcp_check == '0' ? 'checked' : ''}}> 关闭
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                            <span class="help-block"> 每30~60分钟随机进行TCP阻断检测 </span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="v2_alter_id" class="col-md-3 control-label">额外ID</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" name="v2_alter_id" value="{{$node->v2_alter_id}}" id="v2_alter_id" placeholder="16">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="v2_port" class="col-md-3 control-label">端口</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" name="v2_port" value="{{$node->v2_port}}" id="v2_port" placeholder="10087">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="v2_method" class="col-md-3 control-label">加密方式</label>
                                                        <div class="col-md-8">
                                                            <select class="form-control" name="v2_method" id="v2_method">
                                                                <option value="none" @if($node->v2_method == 'none') selected @endif>none</option>
                                                                <option value="aes-128-cfb" @if($node->v2_method == 'aes-128-cfb') selected @endif>aes-128-cfb</option>
                                                                <option value="aes-128-gcm" @if($node->v2_method == 'aes-128-gcm') selected @endif>aes-128-gcm</option>
                                                                <option value="chacha20-poly1305" @if($node->v2_method == 'chacha20-poly1305') selected @endif>chacha20-poly1305</option>
                                                            </select>
                                                            <span class="help-block"> 使用WebSocket传输协议时不要使用none </span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="v2_net" class="col-md-3 control-label">传输协议</label>
                                                        <div class="col-md-8">
                                                            <select class="form-control" name="v2_net" id="v2_net">
                                                                <option value="tcp" @if($node->v2_net == 'tcp') selected @endif>TCP</option>
                                                                <option value="kcp" @if($node->v2_net == 'kcp') selected @endif>mKCP（kcp）</option>
                                                                <option value="ws" @if($node->v2_net == 'ws') selected @endif>WebSocket（ws）</option>
                                                                <option value="h2" @if($node->v2_net == 'h2') selected @endif>HTTP/2（h2）</option>
                                                            </select>
                                                            <span class="help-block"> 使用WebSocket传输协议时请启用TLS </span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="v2_type" class="col-md-3 control-label">伪装类型</label>
                                                        <div class="col-md-8">
                                                            <select class="form-control" name="v2_type" id="v2_type">
                                                                <option value="none" @if($node->v2_type == 'none') selected @endif>无伪装</option>
                                                                <option value="http" @if($node->v2_type == 'http') selected @endif>HTTP数据流</option>
                                                                <option value="srtp" @if($node->v2_type == 'srtp') selected @endif>视频通话数据 (SRTP)</option>
                                                                <option value="utp" @if($node->v2_type == 'utp') selected @endif>BT下载数据 (uTP)</option>
                                                                <option value="wechat-video" @if($node->v2_type == 'wechat-video') selected @endif>微信视频通话</option>
                                                                <option value="dtls" @if($node->v2_type == 'dtls') selected @endif>DTLS1.2数据包</option>
                                                                <option value="wireguard" @if($node->v2_type == 'wireguard') selected @endif>WireGuard数据包</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="v2_host" class="col-md-3 control-label">伪装域名</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" name="v2_host" value="{{$node->v2_host}}" id="v2_host">
                                                            <span class="help-block"> 伪装类型为http时多个伪装域名逗号隔开，使用WebSocket传输协议时只允许单个 </span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="v2_path" class="col-md-3 control-label">ws/h2路径</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" name="v2_path" value="{{$node->v2_path}}" id="v2_path">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="v2_tls" class="col-md-3 control-label">TLS</label>
                                                        <div class="col-md-8">
                                                            <div class="mt-radio-inline">
                                                                <label class="mt-radio">
                                                                    <input type="radio" name="v2_tls" value="1" @if($node->v2_tls == 1) checked @endif> 是
                                                                    <span></span>
                                                                </label>
                                                                <label class="mt-radio">
                                                                    <input type="radio" name="v2_tls" value="0" @if($node->v2_tls == 0) checked @endif> 否
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="v2_insider_port" class="col-md-3 control-label">内部端口</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" name="v2_insider_port" value="{{$node->v2_insider_port}}" id="v2_insider_port" placeholder="10550">
                                                            <span class="help-block"> 内部监听，当端口为0时启用，仅支持<a href="https://github.com/rico93/pay-v2ray-sspanel-v3-mod_Uim-plugin/" target="_blank">rico93版</a> </span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="v2_outsider_port" class="col-md-3 control-label">内部端口</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" name="v2_outsider_port" value="{{$node->v2_outsider_port}}" id="v2_outsider_port" placeholder="443">
                                                            <span class="help-block"> 外部覆盖，当端口为0时启用，仅支持<a href="https://github.com/rico93/pay-v2ray-sspanel-v3-mod_Uim-plugin/" target="_blank">rico93版</a> </span>
                                                        </div>
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
                <!-- END PAGE BASE CONTENT -->
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
@endsection
@section('script')
    <script src="/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>

    <script type="text/javascript">
        // 用户标签选择器
        $('#labels').select2({
            theme: 'bootstrap',
            placeholder: '设置后则可见相同标签的节点',
            allowClear: true,
            width:'100%'
        });

        // ajax同步提交
        function do_submit() {
            var _token = '{{csrf_token()}}';
            var id = '{{Request::get('id')}}';
            var name = $('#name').val();
            var labels = $("#labels").val();
            var group_id = $("#group_id option:selected").val();
            var country_code = $("#country_code option:selected").val();
            var server = $('#server').val();
            var ip = $('#ip').val();
            var ipv6 = $('#ipv6').val();
            var desc = $('#desc').val();
            var traffic_rate = $('#traffic_rate').val();
            var is_subscribe = $("input:radio[name='is_subscribe']:checked").val();
            var is_nat = $("input:radio[name='is_nat']:checked").val();
            var is_transit = $("input:radio[name='is_transit']:checked").val();
            var ssh_port = $('#ssh_port').val();
            var sort = $('#sort').val();
            var status = $("input:radio[name='status']:checked").val();
            var is_tcp_check = $("input:radio[name='is_tcp_check']:checked").val();

            var v2_alter_id = $('#v2_alter_id').val();
            var v2_port = $('#v2_port').val();
            var v2_method = $("#v2_method option:selected").val();
            var v2_net = $('#v2_net').val();
            var v2_type = $('#v2_type').val();
            var v2_host = $('#v2_host').val();
            var v2_path = $('#v2_path').val();
            var v2_tls = $("input:radio[name='v2_tls']:checked").val();
            var v2_insider_port = $('#v2_insider_port').val();
            var v2_outsider_port = $('#v2_outsider_port').val();

            $.ajax({
                type: "POST",
                url: "{{url('admin/editNode')}}",
                async: false,
                data: {
                    _token:_token,
                    id: id,
                    name: name,
                    labels: labels,
                    group_id: group_id,
                    country_code: country_code,
                    server: server,
                    ip: ip,
                    ipv6: ipv6,
                    desc: desc,
                    traffic_rate: traffic_rate,
                    is_subscribe: is_subscribe,
                    is_nat: is_nat,
                    is_transit: is_transit,
                    ssh_port: ssh_port,
                    sort: sort,
                    status: status,
                    is_tcp_check: is_tcp_check,
                    v2_alter_id: v2_alter_id,
                    v2_port: v2_port,
                    v2_method: v2_method,
                    v2_net: v2_net,
                    v2_type: v2_type,
                    v2_host: v2_host,
                    v2_path: v2_path,
                    v2_tls: v2_tls,
                    v2_insider_port: v2_insider_port,
                    v2_outsider_port: v2_outsider_port
                },
                dataType: 'json',
                success: function (ret) {
                    layer.msg(ret.message, {time:1000}, function() {
                        if (ret.status == 'success') {
                            window.location.href = '{{url('admin/nodeList?page=') . Request::get('page')}}';
                        }
                    });
                }
            });

            return false;
        }

        // 设置是否为NAT
        $("input:radio[name='is_nat']").on('change', function() {
            var is_nat = parseInt($(this).val());

            if (is_nat === 1) {
                $("#ip").val("").attr("readonly", "readonly");
                $("#ipv6").val("").attr("readonly", "readonly");
                $("#server").attr("required", "required");
            } else {
                $("#ip").val("").removeAttr("readonly");
                $("#ipv6").val("").removeAttr("readonly");
                $("#server").removeAttr("required");
            }
        });

    </script>
@endsection