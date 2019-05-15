<div class="row">
	<div class="col-md-3">
		<div class="rb-panel rb-bg-blue-light">
			<div class="inner">
				<h3><?=rb_db_count('','user_role');?></h3>
				<p>Roles</p>
			</div>
			<i class="fa fa-lock"></i>
		</div>
	</div>
	<div class="col-md-3">
		<div class="rb-panel rb-bg-green-light">
			<div class="inner">
				<h3><?=rb_db_count('','users');?></h3>
				<p>User</p>
			</div>
			<i class="fa fa-users"></i>
		</div>
	</div>
	<div class="col-md-3">
		<div class="rb-panel rb-bg-orange-light">
			<div class="inner">
				<h3><?=rb_db_group_count();?></h3>
				<p>Database</p>
			</div>
			<i class="fa fa-database"></i>
		</div>
	</div>
</div>