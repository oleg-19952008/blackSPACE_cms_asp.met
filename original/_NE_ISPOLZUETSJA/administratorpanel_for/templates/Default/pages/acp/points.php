<?php
if (isset($_GET['action']) && $_GET['action'] == "delete"):
    Subpage::DeleteBooking($_GET['id']);
endif;
?>
<?php include_once 'menu.php'; ?>
<link href="templates/Default/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="templates/Default/css/londinium-theme.min.css" rel="stylesheet" type="text/css">
<link href="templates/Default/css/styles.min.css" rel="stylesheet" type="text/css">
<link href="templates/Default/css/icons.min.css" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
<script type="text/javascript" src="templates/Default/js/plugins/charts/sparkline.min.js"></script>
<script type="text/javascript" src="templates/Default/js/plugins/forms/uniform.min.js"></script>
<script type="text/javascript" src="templates/Default/js/plugins/forms/select2.min.js"></script>
<script type="text/javascript" src="templates/Default/js/plugins/forms/inputmask.js"></script>
<script type="text/javascript" src="templates/Default/js/plugins/forms/autosize.js"></script>
<script type="text/javascript" src="templates/Default/js/plugins/forms/inputlimit.min.js"></script>
<script type="text/javascript" src="templates/Default/js/plugins/forms/listbox.js"></script>
<script type="text/javascript" src="templates/Default/js/plugins/forms/multiselect.js"></script>
<script type="text/javascript" src="templates/Default/js/plugins/forms/validate.min.js"></script>
<script type="text/javascript" src="templates/Default/js/plugins/forms/tags.min.js"></script>
<script type="text/javascript" src="templates/Default/js/plugins/forms/switch.min.js"></script>
<script type="text/javascript" src="templates/Default/js/plugins/forms/uploader/plupload.full.min.js"></script>
<script type="text/javascript" src="templates/Default/js/plugins/forms/uploader/plupload.queue.min.js"></script>
<script type="text/javascript" src="templates/Default/js/plugins/forms/wysihtml5/wysihtml5.min.js"></script>
<script type="text/javascript" src="templates/Default/js/plugins/forms/wysihtml5/toolbar.js"></script>
<script type="text/javascript" src="templates/Default/js/plugins/interface/daterangepicker.js"></script>
<script type="text/javascript" src="templates/Default/js/plugins/interface/fancybox.min.js"></script>
<script type="text/javascript" src="templates/Default/js/plugins/interface/moment.js"></script>
<script type="text/javascript" src="templates/Default/js/plugins/interface/jgrowl.min.js"></script>
<script type="text/javascript" src="templates/Default/js/plugins/interface/datatables.min.js"></script>
<script type="text/javascript" src="templates/Default/js/plugins/interface/colorpicker.js"></script>
<script type="text/javascript" src="templates/Default/js/plugins/interface/fullcalendar.min.js"></script>
<script type="text/javascript" src="templates/Default/js/plugins/interface/timepicker.min.js"></script>
<script type="text/javascript" src="templates/Default/js/plugins/interface/collapsible.min.js"></script>
<script type="text/javascript" src="templates/Default/js/bootstrap.min.js"></script>
<script type="text/javascript" src="templates/Default/js/application.js"></script>
<p class="user">Hello, <a href="?ucp"><?php echo User::$username; ?></a> | <a href="?logout">Logout</a></p>
</div>		<!-- #header ends -->
<?php
if (isset($_POST['add']) && $_POST['add'] == "Book Session") {
    if (Subpage::bookSession($_POST)):
        ?>
        <script type="text/javascript">
            window.location.reload(true);
        </script>
        <?php
    endif;
}elseif(isset($_POST['edit']) && $_POST['edit'] == "Edit Booking"){
    if (Subpage::editBooking($_POST)):
        ?>
        <script type="text/javascript">
            window.location.reload(true);
        </script>
        <?php
    endif;
}
?>
<?php
if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['tool'] == "edit"):
    ?>
    <div class="block">

        <div class="block_head">
            <div class="bheadl"></div>
            <div class="bheadr"></div>
            <h2>Edit Booking</h2>
        </div>		<!-- .block_head ends -->


        <div class="block_content">
            
            </div>		<!-- .block_content ends -->

            <div class="bendl"></div>
            <div class="bendr"></div>

        </div>
        <?php
    else:
        ?>
        <div class="block">

            <div class="block_head">
                <div class="bheadl"></div>
                <div class="bheadr"></div>
                <h2 class="panel-title"><i class="icon-calendar2"></i>Point System</h2>
            </div>		<!-- .block_head ends -->

            <div class="block_content" style="min-height: 400px;">
                <br />
                <div class="tab-pane active fade in" id="all-tasks">
                    <div class="panel panel-default">

                        <div class="datatable-tasks">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Session Name</th>
                                        <th>Session Instructor</th>
                                        <th class="task-date-added">Start</th>
                                        <th class="task-date-added">Ending</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($events as $event):
                                        $start = explode("T", $event['start']);
                                        $startDate = explode("-", $start[0]);
                                        $end = explode("T", $event['ends']);
                                        $endDate = explode("-", $end[0]);
                                        ?>
                                        <tr>
                                            <td class="task-desc"> <div class="dropdown" style="list-style: none;"> <button class="btn btn-primary" data-toggle="modal" role="button" data-id="<?php echo $event['id']; ?>" data-target="#remote_modal">Edit Points</button></div><span>Edit points for members in: <?php echo $event['title']; ?>, ID: <?php echo $event['id']; ?></span></td>
                                            <td><?php echo $event['Full_name']; ?></td>
                                            <td><?php echo $startDate[2] . "/" . $startDate[1] . "/" . $startDate[0]; ?></td>
                                            <td><?php echo $endDate[2] . "/" . $endDate[1] . "/" . $endDate[0]; ?></td>
                                            
                                        </tr>
                                        <?php
                                    endforeach;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

            <div class="bendl"></div>
            <div class="bendr"></div>
            <div id="remote_modal" class="modal fade " tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #657580;">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title"><i class="icon-plus-circle"></i>Edit points on team:    <b id="systemId"> 23 </b></h4>
                        </div>
                        <div class="modal-body with-padding">
                            
                        </div>
                        <div class="modal-footer">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
                $('button[role="button"]').click(function() {
                $(".modal-body").html(""); 
                    var id = $(this).attr("data-id");
                    $.ajax({
                        type: 'GET',
                        async: false,
                        url: "./?RestrictedApi&BookSystemID="+id,
                        success: function(teamData) {
                            var obj = jQuery.parseJSON(teamData);
                            if(!jQuery.isEmptyObject(obj)){
                            $("#systemId").html(id);
                            jQuery.each( obj, function( i, val ) {
//                                console.log(val);
                                $(".modal-body").append('<br /><div data-user="'+val.id+'"><div class="col-sm-6"><input type="text" class="form-control" readonly="readonly" value="'+val.Full_name+'"></div><div class="col-sm-2"><input type="text" class="form-control" data-que="1" readonly="readonly" value="'+val.points+'"></div><div class="text-left"><a data-take="3" data-user="'+val.id+'" class="btn btn-danger" style="width: 80px;"><input data-name="count" type="hidden" value="'+val.points+'" ><i class="icon-minus"></i> Take</a> <a id="give-points" data-user="'+val.id+'" data-give="3" class="btn btn-info" style="width: 80px;"><input data-name="count" type="hidden" value="'+val.points+'" ><i class="icon-plus"></i>Give</a></div></div>');
                              });
                              }
                           }
                         });
                           
                });
                $(document).on('click', 'a[data-take="3"]', function(){  
					var userid = $(this).attr('data-user');
                    var curr = $("div[data-user='"+userid+"']").find("input[data-que='1']").val();
                    var min = $("div[data-user='"+userid+"']").find("input[data-name='count']").val();
                    var pos = parseInt(curr);
                    var sdo = pos-5;
                    $("div[data-user='"+userid+"']").find("input[data-que='1']").val(sdo);
                    $.ajax({
                        type: 'GET',
                        async: false,
                        url: "./?RestrictedApi&BrookePointAdd="+userid+"&minus=1&amount=5",
                        success: function() {
                            
                           }
                         });
                    
                    
                });
                $(document).on('click', 'a[data-give="3"]', function(){ 
                    var userid = $(this).attr('data-user');
                    var curr = $("div[data-user='"+userid+"']").find("input[data-que='1']").val();
                    var pos = parseInt(curr)+5;
                    $("div[data-user='"+userid+"']").find("input[data-que='1']").val(pos);
                     $.ajax({
                        type: 'GET',
                        async: false,
                        url: "./?RestrictedApi&BrookePointAdd="+userid+"&minus=0&amount=5",
                        success: function() {
                            
                           }
                         });
                });
                            
            </script>
    <?php endif; ?>