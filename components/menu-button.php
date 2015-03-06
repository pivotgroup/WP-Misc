/* ==== MENU BUTTON 1 ============================================= */
<a class="menu-button">
	<span class="open-text">Menu</span>
	<span class="close-text">Close</span>
	<div class="menu-icon">
		<span class="top"></span>
		<span class="middle"></span>
		<span class="bottom"></span>
	</div>
</a>

// scss
.menu-button {
	.open-text,
	.close-text {
		padding-left: 5px;
	}
	.close-text {
		display: none;
	}
	&.active {
		.open-text {
			display: none;
		}
		.close-text {
			display: inline-block;
		}
	}
}
.menu-icon {
	cursor: pointer;
	margin: 0 auto;
	position: relative;
	width: 24px;
	height: 16px;
	display: inline-block;
	> * {
		backface-visibility: hidden;
		position: absolute;
		left: 0;
		border-top: 3px solid #fff;
		border-top-color: inherit;
		width: 100%;
		transition: 0.55s;
	}
	> .top {
		top: 0;
	}
	> .middle {
		top: 50%;
		margin-top: -1px;
	}
	> .bottom {
		top: 14px;
		margin-bottom: -1px;
	}
	.close-text {
		display: none;
	}
	.menu-button.active &,
	&.active {
		>.top,
		>.bottom {
			backface-visibility: hidden;
			@include transition( .5s ease all);
		}
		>.top {
			top: 7px;
			-moz-transform: rotate(50deg);
			-webkit-transform: rotate(50deg);
			-o-transform: rotate(50deg);
			-ms-transform: rotate(50deg);
			transform: rotate(50deg);
		}
		> .middle {
			opacity: 0;
		}
		> .bottom {
			top: 7px;
			-moz-transform: rotate(-410deg);
			-webkit-transform: rotate(-410deg);
			-o-transform: rotate(-410deg);
			-ms-transform: rotate(-410deg);
			transform: rotate(-410deg);
		}
	}
}

// js
toggling.init( $('header.site nav .menu-button'), $('header.site nav .menu' ) )

/* ==== MENU BUTTON 2 ============================================= */
// html
<div class="menu-icon">
	<span></span>
	<span></span>
	<span></span>
	<span></span>
</div>

// scss
.menu-icon {
	position: relative;
	cursor: pointer;
	width: 32px;
	height: 24px;
	> span {
		display: block;
		position: absolute;
		height: 4px;
		width: 100%;
		background: $darkGray;
		border-radius: 4px;
		opacity: 1;
		left: 0;
		@include transition( all .3s ease );
		&:nth-child(1){
  			top: 0px;
		}
		&:nth-child(2),
		&:nth-child(3){
			top: 10px;
		}
		&:nth-child(4){
  			top: 20px;
		}
	}
	&.active {
		> span {
			background: $blue;
			&:nth-child(1){
				top: 10px;
				width: 0%;
				left: 50%;
			}
			&:nth-child(2) {
				-webkit-transform: rotate(-45deg);
				-moz-transform: rotate(-45deg);
				-o-transform: rotate(-45deg);
				transform: rotate(-45deg);
			}
			&:nth-child(3){
				-webkit-transform: rotate(45deg);
				-moz-transform: rotate(45deg);
				-o-transform: rotate(45deg);
				transform: rotate(45deg);
			}
			&:nth-child(4){
				top: 10px;
				width: 0%;
				left: 50%;
			}
		}
	}
}

// js
toggling.init( $('header.site nav .menu-button'), $('header.site nav .menu' ) )
