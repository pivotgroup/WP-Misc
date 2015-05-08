<?php
function bb_format_price_html( $amount, $per ){
	$amount_parts = explode( '.', $amount );
	$price = array(
		'dollars' => !empty( $amount_parts[0] ) ? $amount_parts[0] : false,
		'cents' => !empty( $amount_parts[1] ) ? $amount_parts[1] : false,
	);
	ob_start(); ?>
	<div class="price">
		<?php
		// no dollars, but cents
		if (empty( $price['dollars']) && !empty($price['cents'] )){ ?>
			<h1 class="cents">
				<span class="amount"><?= $price['cents']; ?></span>
				<sup class="cent-sign">&cent;</sup>
			</h1>
		<?php
		// dollars
		} else { ?>
			<h1 class="dollars">
				<sup class="dollar-sign">$</sup>
				<span class="amount"><?= $price['dollars']; ?></span>
				<?php if ( !empty( $price['cents'] ) ){ ?>
				<sup class="cent-amount"><?= $price['cents']; ?></sup>
				<?php } ?>
			</h1>
		<?php } ?>
		<?php if ( $per ){ ?>
		<div class="per"><?= $per; ?></div>
		<?php } ?>
	</div>
<?php return ob_get_clean();
}

/* ==== GENERAL CSS ============================================= */
.price {
	.cents, .per, .dollars {
		display: inline-block;
		position: relative;
		color: inherit;
	}
	.cents, .dollars {
		font-weight: 900;
		margin-right: 5px;
	}
	sup {
		font-size: .4em;
		margin-top: .75em;
	}
	.per {
		font-style: italic;
		font-weight: normal;
	}
	.symbol, sup {
		position: absolute;
		top: 0;
	}
	.cent-sign, .cent-amount {
		left: 100%;
	}
	.dollar-sign {
		right: 100%;
	}
}
