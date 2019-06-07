<?php defined('DIR') OR exit; ?>
    <div id="title" class="fix">
        <div class="icon"><img src="_tripadmin/img/table.png" width="16" height="16" alt="" /></div>			
        <div class="name">Check</div>
    </div>	
    <div id="box">
        <div id="part">
            <div id="top" class="fix">1
            </div>	
            <div id="news">
                <table border="1" width="960">
            	<tr>
                <td width="60">Username</td>
                <td width="60">Firstname</td>
                <td width="80">Lastname</td>
                <td width="60">Date</td>
                <td width="60" style="background-color:#CCC;">Product ID</td>
                <td width="30">Quan</td>
                <td width="30">Price</td>
                <td width="100">Mobile</td>
                <td width="">Delivery</td>
                </tr>
                </table>
                <hr>
           	
            <?php
            $select = mysql_query("SELECT * FROM sold WHERE sold=1 ORDER BY id DESC");
			$nums = mysql_num_rows($select);
			while($row = mysql_fetch_array($select))
			{
				$title = $row['id'];
				$select2 = mysql_query("SELECT * FROM catalogs WHERE id='".$row['product_id']."' AND  language = '" . l() . "'");
									while($r = mysql_fetch_array($select2))
									{
										
				$sid = $row['session_id'];
				$select3 = mysql_query("SELECT * FROM site_users WHERE id='".$row['session_id']."'");
									while($s = mysql_fetch_array($select3))
									{
			?>
           		<table border="1" width="960">
				<tr height="30">
                <td width="60"><?php echo $s['username'];?></td>
                <td width="60"><?php echo $row['firstname'];?></td>
                <td width="80"><?php echo $row['lastname'];?></td>
                <td width="60"><?php echo $row['date'];?></td>
                <td width="60" style="background-color:#CCC;"><?php echo $r['pid']?></td>
                <td width="30"><?php echo $row['quentity']?></td>
                <td width="30"><?php echo $r['price']?></td>
                <td width="100"><?php echo $row['mobile']?></td>
                <td width="">
				<?php if($row['dhl']!=''){?>
				<?php echo $row['dhl'];?>
                <?php } else {?>
                <?php echo $row['address'].'/'.$row['address_street'].'/'.$row['address_number']?>
                <?php }?>
                </td>
                </tr>
           		</table>
            <?php
									}
									}
			}
			?>
            </div>				
        </div>
    </div>
