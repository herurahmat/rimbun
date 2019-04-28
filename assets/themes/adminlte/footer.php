</div>        
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <span>Powered by</span>
        <a href="http://facebook.com/heru.rahmat">RIMBUN ENGINE</a>
    </div>
    <?=rb_system_footer();?>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
   
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        
        <!-- /.control-sidebar-menu -->

        
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<?php
echo cdn_bootstrap3_js();
?>
<script src="<?=rb_path_themes();?>adminlte/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?=rb_path_themes();?>adminlte/plugins/fastclick/fastclick.js"></script>
<script src="<?=rb_path_themes();?>adminlte/dist/js/adminlte.min.js"></script>
<script src="<?=rb_path_themes();?>adminlte/dist/js/skin.js"></script>
<?php
echo rb_core_footer();
?>
</body>
</html>