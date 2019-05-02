<?php
echo cdn_datatables();
?>
<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">Add Configuration</div>
			</div>
			<div class="panel-body">
				<?php
				echo validation_errors();
				echo form_open($url."add",array());
				?>
				
					<div class="form-group required">
						<label class="ctl">Meta Key</label>
						<input type="text" name="mk" id="mk" class="form-control " required="" placeholder="Meta Key" value="<?=set_value('mk');?>"/>
					</div>
					<div class="form-group">
						<label>Meta Value</label>
						<textarea name="mv" id="mv" class="form-control " placeholder="Meta Value"><?=set_value('mv');?></textarea>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-flat">Add Item</button>
					</div>
				
				<?php
				echo form_close();
				?>
			</div>
		</div>
	</div>
	<div class="col-md-8">
		
		<div class="table-responsive">
			<table class="table table-bordered datatable-render">
				<thead>
					<th>Meta Key</th>
					<th>Meta Value</th>
					<th></th>
				</thead>
				<tbody>
					<?php
					$options=$this->system_model->options_data(array('is_sistem'=>0));
					if(!empty($options))
					{
						foreach($options as $row)
						{
							$ID=$row->ID;
							$aksi=rb_simple_action($url,$ID,'Config',TRUE);
							?>
							<tr>
								<td><?=$row->meta_key;?></td>
								<td><?=$row->meta_value;?></td>
								<td><?=$aksi;?></td>
							</tr>
							<?php
						}
					}
					?>
				</tbody>
			</table>
		</div>
		
	</div>
</div>