<table class="body" style="margin:0;padding:0;border:0;font-size:100%;vertical-align:baseline;font-size: 100%;">
  <div style="background: url('http://vnet.luo2888.cn/assets/images/mail-banner.jpg')no-repeat;background-size: cover;width: 85%;min-height: 425px;margin: 1em auto;">
  	 <div style="width: 90%;margin: 0 auto;padding: 0.5em 0em;text-align: center;">
  	 	<br>
  	 	<a style="text-decoration: none;font-size: 1.2em;color: #4882ce;font-weight: 600;display: block;margin: 0em 0em 1em 0em;" href="{{\App\Components\Helpers::systemConfig()['website_url']}}">{{\App\Components\Helpers::systemConfig()['website_name']}}</a>
  	 	<img style="max-width:100%;" src="http://vnet.luo2888.cn/assets/images/mail-design.png">
  	 	<br><br>
  	 	<p style="font-size: 0.8em;color: #000;line-height: 1.5em;width:80%;margin: 0.5em auto 0.5em;">
  	 		订单支付完成,您的服务已可使用。
  	 	</p>
  	 </div>
  	 <div style="width: 90%;margin: 0 auto;padding: 0.5em 0em;text-align: left;">
  	 	<p style="font-size: 0.8em;color: #000;line-height: 1.5em;width:80%;margin: 0.5em auto 0.5em;">订单编号：<b>{!! $content['order_sn'] !!}</b></p>
  	 	<p style="font-size: 0.8em;color: #000;line-height: 1.5em;width:80%;margin: 0.5em auto 0.5em;">购买商品：<b>{!! $content['goods_name'] !!}</b></p>
  	 	<p style="font-size: 0.8em;color: #000;line-height: 1.5em;width:80%;margin: 0.5em auto 0.5em;">优惠券：<b>{!! $content['coupon'] !!}</b></p>
  	 	<p style="font-size: 0.8em;color: #000;line-height: 1.5em;width:80%;margin: 0.5em auto 0.5em;">支付方式：<b>{!! $content['pay_way'] !!}</b></p>
  	 	<p style="font-size: 0.8em;color: #000;line-height: 1.5em;width:80%;margin: 0.5em auto 0.5em;">创建时间：<b>{!! $content['created_at'] !!}</b></p>
  	 	<p style="font-size: 0.8em;color: #000;line-height: 1.5em;width:80%;margin: 0.5em auto 0.5em;">到期时间：<b>{!! $content['expire_at'] !!}</b></p>
  	 	<p style="font-size: 0.8em;color: #000;line-height: 1.5em;width:80%;margin: 0.5em auto 0.5em;">实付款：<b>{!! $content['amount'] !!}元</b></p>
  	 </div>
  	 <div style="width: 90%;margin: 0 auto;padding: 0.5em 0em;text-align: center;">
  	 	<br>
  	 	<img style="max-width:100%;" src="http://vnet.luo2888.cn/assets/images/mail-design.png">
  	 	<br><br>
  	 	<div style="font-size: 0.8em;color: #000;line-height: 1.5em;width:80%;margin: 0.5em auto 0.5em;">
  	 	  <p>&copy;&nbsp;2017-2021&nbsp;<a href="http://www.luo2888.cn">Luo2888</a>.Inc</p>
  	 	</div>
  	 </div>
  </div>
</table>