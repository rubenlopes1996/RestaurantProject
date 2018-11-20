<template>
	<body data-spy="scroll" data-target=".navbar" data-offset="50">
		<div id="Welcome">
			<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
				<ol class="carousel-indicators">
					<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
					<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
					<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
				</ol>
				<div class="carousel-inner">
					<div class="carousel-item active">
						<img class="d-block w-100 img-fluid img-slider" src="images/slider1.jpg" alt="First slide">
						<div class="carousel-caption">
	
						</div>
					</div>
					<div class="carousel-item">
						<img class="d-block w-100 img-fluid img-slider" src="images/slider2.jpg" alt="Second slide">
						<div class="carousel-caption">
	
						</div>
					</div>
					<div class="carousel-item">
						<img class="d-block w-100 img-fluid img-slider" src="images/slider3.jpg" alt="Third slide">
						<div class="carousel-caption">
	
						</div>
					</div>
				</div>
				<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
		</div>
		<div class="row footer bg-light">
			<div class="col">
				<p class="text-center">About Us</p>
			</div>
	
		</div>
	</body>
</template>

<script>
	
</script>

<style>
	
	.nav-item {
		padding-right: 12px;
		padding-left: 12px;
	}
	
	.flag {
		max-height: 20px;
		max-width: 20px;
		margin-top: 10px;
	}
	
	.nav-link.active {
		background-color: lightgrey !important;
	}
	
	.reserve-container {
		position: relative;
	}
	
	.card-body {
		-webkit-transition: all 1s ease;
		/* Safari and Chrome */
		-moz-transition: all 1s ease;
		/* Firefox */
		-o-transition: all 1s ease;
		/* IE 9 */
		-ms-transition: all 1s ease;
		/* Opera */
		transition: all 1s ease;
	}
	
	.card-body:hover {
		-webkit-transform: scale(1.05);
		-moz-transform: scale(1.05);
		-o-transform: scale(1.05);
		-ms-transform: scale(1.05);
		transform: scale(1.05);
	}
	
	.reserve-text {
		position: absolute;
		top: 40%;
		left: 50%;
		transform: translate(-50%, -50%);
	}
	
	.image-reserve {
		opacity: 0.4;
		max-height: 750px;
	}
	
	.carousel-caption {
		top: 40%;
	}
	
	.img-slider {
		min-height: 320px;
	}
	
	.navMenu {
		padding-top: 75px;
		padding-bottom: 20px;
	}
	
	.card-img-top {
		height: 200px;
	}
	
	.map {
		height: 320px;
	}
	
	@media screen and (max-width: 1920px) {
		.only-mobile {
			visibility: hidden;
		}
	}
	
	@media screen and (max-width: 506px) {
		.only-mobile {
			visibility: visible;
		}
	}
	
	.footer {
		margin-bottom: 30px;
		margin-top: 30px;
		padding-top: 20px;
	}
	
	.social-icon {
		font-size: 28;
	}
	
	footer {
		position: fixed;
		bottom: 0px;
		padding-top: 20px;
	}
</style>

