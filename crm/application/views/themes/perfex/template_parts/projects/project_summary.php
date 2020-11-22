<?php defined('BASEPATH') or exit('No direct script access allowed');
$where = ('concat(\',\',clientid,\',\') like \'%,' . get_client_user_id().',%\'');
//print_r($project_statuses);die();
foreach($project_statuses as $status){ ?>
	<div class="col-md-2 list-status projects-status">
		<a href="<?php echo site_url('clients/projects/'.$status['id']); ?>" class="<?php if(isset($list_statuses) && in_array($status['id'], $list_statuses)){echo 'active';} ?>">
			<?php $where2 = $where.' and status='.($status['id'])." "; 

			?>
			<h3 class="bold"><?php 
			echo total_rows(db_prefix().'projects',$where2);
			//print_r($where);die(); 
			?></h3>
			<span style="color:<?php echo $status['color']; ?>">
				<?php echo $status['name']; ?>
			</a>
		</div>
	<?php } ?>
