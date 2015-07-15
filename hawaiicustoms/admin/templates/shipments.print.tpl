<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=%%GLOBAL_CharacterSet%%" />
	<script type="text/javascript" src="../javascript/jquery.js"></script>
	<style type="text/css" media="screen">
		body {
			margin: 0;
		}

		#ShipmentSelect {
			background: #efefef;
			font-weight: bold;
			font-size: 14px;
			position: fixed;
			top: 0;
			width: 100%;
			border-bottom: 1px solid #555;
		}

		#PackingSlips {
			margin: 10px;
		}

		#PackingSlips.WithShipmentSelect {
			margin-top: 50px;
		}
	</style>

	<style type="text/css" media="print">
		#ShipmentSelect {
			display: none;
		}
	</style>
</head>
<body>
	%%GLOBAL_ShipmentSelect%%

	<div id="PackingSlips" class="%%GLOBAL_PackingSlipsClass%%">
		%%GLOBAL_PackingSlips%%
	</div>

<!--	<script type="text/javascript">window.setTimeout("window.print();", 1000);</script> -->
</body>
</html>