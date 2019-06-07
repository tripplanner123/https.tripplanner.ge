<?php 
exit();
require_once('../_plugins/tcpdf/tcpdf.php');


$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Trip Planner');
$pdf->SetTitle('Invoice #123');
$pdf->SetSubject('Invoice #123');
$pdf->SetKeywords('Invoice, trip, planner');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->SetFont('times', 'BI', 20);
$pdf->AddPage();


// set some text to print
$html = <<<EOD
<table border="0" cellpadding="0" cellspacing="0" class="maintable">
		<tr>
			<td align="center" colspan="2"><img src="https://tripplanner.ge/_website/img/header_logo.png" alt="logo" align="center" width="256" /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td align="left">
				<h2 style="margin:0; padding:0 0 10px 0; line-height: 28px; font-size: 22px; color: #2d7b52;">Giorgi Gvazava</h2>
				<p style="margin:0; padding:5px 0; font-size: 16px;"><strong>P/N:</strong> 01027034354</p>
				<p style="margin:0; padding:5px 0; font-size: 16px;"><strong>Address:</strong> Tbilisi, Varketili 3, I Micro, Flat 17, Room 36</p>
				<p style="margin:0; padding:5px 0; font-size: 16px;"><strong>Phone:</strong> 599623555</p>
				<p style="margin:0; padding:5px 0; font-size: 16px;"><strong>Email:</strong> giorgigvazava87@gmail.com</p>
			</td>
			<td align="right">
				<p style="margin:0; padding:5px 0; font-size: 16px;"><strong>Invoice #</strong> 25151656515</p>
				<p style="margin:0; padding:5px 0; font-size: 16px;"><strong>Date:</strong> 17/09/2018</p>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2"><h3 style="margin:0 0 15px 0; padding:0; font-size: 16px; ">On Going Tours</h3></td>
		</tr>
		<tr>
			<td colspan="2">

				<table border="1" cellpadding="5" cellspacing="0" width="100%">
					<tr style="background-color: #2d7b52">
						<th style="margin:0; padding:0; font-size: 14px; color: white;">Date</th>
						<th style="margin:0; padding:0; font-size: 14px; color: white;">Title</th>
						<th style="margin:0; padding:0; font-size: 14px; color: white;">Adults</th>
						<th style="margin:0; padding:0; font-size: 14px; color: white;">Children</th>
						<th style="margin:0; padding:0; font-size: 14px; color: white;">Price</th>
					</tr>
					<tr>
						<td style="margin:0; padding:0; line-height: 14px; font-size: 14px;">27/07/2018 - 28/07/2018</td>
						<td style="margin:0; padding:0; line-height: 14px; font-size: 14px;">Plan a one-day trip to the valley Dzama</td>
						<td style="margin:0; padding:0; line-height: 14px; font-size: 14px;">5</td>
						<td>
							<p style="margin:0; padding:0; line-height: 14px; font-size: 14px;"><strong>Children 0 - 5:</strong> 1</p>
							<p style="margin:0; padding:0; line-height: 14px; font-size: 14px;"><strong>Children 6 - 12:</strong> 1</p>
						</td>
						<td style="margin:0; padding:0; line-height: 14px; font-size: 14px;">125 GEL</td>
					</tr>
				</table>

			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2"><h3 style="margin:0 0 15px 0; padding:0; font-size: 16px; ">Planned tour</h3></td>
		</tr>
		<tr>
			<td colspan="2">
				<table border="1" cellpadding="5" cellspacing="0" width="100%">
					<tr style="background-color: #2d7b52">
						<th style="margin:0; padding:0; font-size: 14px; color: white;">Date</th>
						<th style="margin:0; padding:0; font-size: 14px; color: white;">Places</th>
						<th style="margin:0; padding:0; font-size: 14px; color: white;">Services</th>
						<th style="margin:0; padding:0; font-size: 14px; color: white;">Adults & Children</th>
						<th style="margin:0; padding:0; font-size: 14px; color: white;">Price</th>
					</tr>
					<tr>
						<td style="margin:0; padding:0; line-height: 14px; font-size: 14px;">27/07/2018 - 28/07/2018</td>
						<td style="margin:0; padding:0; line-height: 14px; font-size: 14px;">
							<p>Tbilisi &gt;&gt; Plan a one-day trip to the valley Dzama</p>
						</td>
						<td style="margin:0; padding:0; line-height: 14px; font-size: 14px;">
							<p><strong>Hotel:</strong> Hotel 3*</p>
							<p><strong>Cuisune:</strong> Georgian Cuisune x2</p>
							<p><strong>Guide:</strong> English-speaking guide</p>
							<p><strong>Transfer:</strong> Sedan</p>
						</td>
						<td>
							<p style="margin:0; padding:0; line-height: 14px; font-size: 14px;"><strong>Adults:</strong> 1</p>
							<p style="margin:0; padding:0; line-height: 14px; font-size: 14px;"><strong>Children 0 - 5:</strong> 1</p>
							<p style="margin:0; padding:0; line-height: 14px; font-size: 14px;"><strong>Children 6 - 12:</strong> 1</p>
						</td>
						<td style="margin:0; padding:0; line-height: 14px; font-size: 14px;">125 GEL</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2"><h3 style="margin:0 0 15px 0; padding:0; font-size: 16px; ">Transfers</h3></td>
		</tr>
		<tr>
			<td colspan="2">
				<table border="1" cellpadding="5" cellspacing="0" width="100%">
					<tr style="background-color: #2d7b52">
						<th style="margin:0; padding:0; font-size: 14px; color: white;">Date & Time</th>
						<th style="margin:0; padding:0; font-size: 14px; color: white;">From - To</th>
						<th style="margin:0; padding:0; font-size: 14px; color: white;">Transfer</th>
						<th style="margin:0; padding:0; font-size: 14px; color: white;">Adults & Children</th>
						<th style="margin:0; padding:0; font-size: 14px; color: white;">Price</th>
					</tr>
					<tr>
						<td style="margin:0; padding:0; line-height: 14px; font-size: 14px;">27/07/2018 20:25</td>
						<td style="margin:0; padding:0; line-height: 14px; font-size: 14px;">
							<p>Tbilisi international airport &gt;&gt; Poti international airport</p>
						</td>
						<td style="margin:0; padding:0; line-height: 14px; font-size: 14px;">
							Sedan
						</td>
						<td>
							<p style="margin:0; padding:0; line-height: 14px; font-size: 14px;"><strong>Adults:</strong> 1</p>
							<p style="margin:0; padding:0; line-height: 14px; font-size: 14px;"><strong>Children 0 - 5:</strong> 1</p>
							<p style="margin:0; padding:0; line-height: 14px; font-size: 14px;"><strong>Children 6 - 12:</strong> 1</p>
						</td>
						<td style="margin:0; padding:0; line-height: 14px; font-size: 14px;">125 GEL</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2">
				<table border="1" cellpadding="5" cellspacing="0" width="100%">
					<tr>
						<td colspan="2">
							<h3 style="margin:0 0 15px 0; padding:0; font-size: 16px; ">Bank Requisites</h3>
						</td>
					</tr>
					<tr style="margin:0; padding:0; font-size: 14px;">
						<td><strong>Bank: </strong></td>
						<td>Bank Of Georgia</td>
					</tr>
					<tr style="margin:0; padding:0; font-size: 14px;">
						<td><strong>Bank Code #: </strong></td>
						<td>BAGAGE22</td>
					</tr>
					<tr style="margin:0; padding:0; font-size: 14px;">
						<td><strong>Acount Number #: </strong></td>
						<td>GE71BG0000000766323200GEL</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Total price</td>
			<td>559 GEL</td>
		</tr>
</table>
EOD;

$pdf->writeHTML($html, true, false, true, false, '');
$fileName = md5('sha1'.time()).".pdf";

$extention = substr($fileName, -3);
if($extention != "pdf"){
	header("Location: https://tripplanner.ge/"); 
}
$pdf->Output(__DIR__ ."/".$fileName, 'F');

header("Location: https://tripplanner.ge/invoice/".$fileName); 

//============================================================+
// END OF FILE
//============================================================+