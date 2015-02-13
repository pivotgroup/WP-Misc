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
