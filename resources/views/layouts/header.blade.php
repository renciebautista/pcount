<header class="main-header">
	<nav class="navbar navbar-static-top">
	  	<div class="container">
			<div class="navbar-header">
				{!! link_to_route('dashboard.index','PCount', array(), ['class' => 'navbar-brand']) !!}
			  	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
					<i class="fa fa-bars"></i>
			  	</button>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse pull-left" id="navbar-collapse">
			  	<ul class="nav navbar-nav">
					<!-- <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li> -->
					<!-- <li><a href="#">Link</a></li> -->
					<li class="dropdown">
				  		<a href="#" class="dropdown-toggle" data-toggle="dropdown">File Maintenance <span class="caret"></span></a>
				  		<ul class="dropdown-menu" role="menu">
				  			
				  			<li>{!! link_to_route('division.index','Divisions') !!}</li>
				  			<li>{!! link_to_route('category.index','Categories') !!}</li>
				  			<li>{!! link_to_route('brand.index','Brands') !!}</li>
				  			
				  			<li>{!! link_to_route('customer.index','Customers') !!}</li>
				  			<li>{!! link_to_route('area.index','Areas') !!}</li>
				  			<li>{!! link_to_route('premise.index','Premises') !!}</li>
				  			<li>{!! link_to_route('store.index','Stores') !!}</li>
				  			<li>{!! link_to_route('sku.index','Skus') !!}</li>
				  		</ul>
					</li>
			  	</ul>
			</div><!-- /.navbar-collapse -->
	  	</div><!-- /.container-fluid -->
	</nav>
</header>