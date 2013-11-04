<div class="header" style="z-index: 9999;position: fixed;width: 100%;">

	<div class="navbar">
	    <div class="navbar-inner">
	      <div class="container">
	        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
	          <span class="icon-bar"></span>
	          <span class="icon-bar"></span>
	          <span class="icon-bar"></span>
	        </a>
	        <a class="brand" href="#" style="padding:8px;">Do Plus</a>
	        
	        <? $url = uri_string();?>

		        <div class="nav-collapse">
		          <ul class="nav">
		          	<li <?if(strrpos($url, "seller_manage") > 0){echo " class='active' ";}?>><a href="<?=base_url()?>admin/seller_manage">Bayiler</a></li>
		            <li <?if(strrpos($url, "user_manage") > 0){echo " class='active' ";}?>><a href="<?=base_url()?>admin/user_manage">Kullanıcılar</a></li>
		            <li <?if(strrpos($url, "product_manage") > 0){echo " class='active' ";}?>><a href="<?=base_url()?>admin/product_manage">Ürünler</a></li>
		            <li <?if(strrpos($url, "support_manage") > 0){echo " class='active' ";}?>><a href="<?=base_url()?>admin/support_manage">Destek</a></li>
		            <li <?if(strrpos($url, "video_manage") > 0){echo " class='active' ";}?>><a href="<?=base_url()?>admin/video_manage">Videolar</a></li>
		            <li <?if(strrpos($url, "blog_manage") > 0){echo " class='active' ";}?>><a href="<?=base_url()?>admin/blog_manage">Blog</a></li>
		            <li <?if(strrpos($url, "slider_manage") > 0){echo " class='active' ";}?>><a href="<?=base_url()?>admin/slider_manage">Slider</a></li>
		            <li <?if(strrpos($url, "hediye_katalogu") > 0){echo " class='active' ";}?>><a href="<?=base_url()?>admin/hediye_katalogu">Hediye Kataloğu</a></li>
		          </ul>
		          
		          <ul class="nav pull-right">
		            <li class="divider-vertical"></li>
		            <li class="dropdown">
		              <a href="<?=base_url()?>admin/logout">Çıkış Yap</a>
		            </li>
		          </ul>
		        </div>
		      </div>

	    </div>
	</div>
	
</div>
<div style="width:100%; float:left; height:50px;">

</div>