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
            <div id="remote_modal" class="modal fade in" tabindex="-1" role="dialog" style="display: block;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #657580;">
                            <a href="?acp=booking" class="close" data-dismiss="modal" aria-hidden="true">&times;</a>
                            <h4 class="modal-title"><i class="icon-calendar2"></i>Edit Booking with ID : <?php echo $_GET['id']; ?></h4>
                        </div>
                        <div class="modal-body with-padding">
                            <div class="modal-body with-padding">

                                <form method="POST" action="?acp=booking">

                                    <div class="form-group">
                                        <label class="col-sm-12 control-label" >Instructor </label>
                                        <div class="col-sm-10">
                                            <?php
                                            if (User::$isAdmin == TRUE):
                                                ?>
                                                <select name="who" name="instructor"  class="form-control">
                                                    <option value="<?php echo $edit[0]['employee_id']; ?>"><?php echo $edit[0]['Full_name']; ?></option>
                                                    <?php
                                                    foreach ($instructors as $instr):
                                                        echo '<option value="' . $instr['id'] . '">' . $instr['Full_name'] . '</option>';
                                                    endforeach;
                                                    ?>
                                                </select>
                                                <?php
                                            else:
                                                ?>
                                                <input type="text" name="instructor" class="form-control" readonly="readonly" value="<?php echo $edit[0]['Full_name']; ?>">
                                            <?php
                                            endif;
                                            ?>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label" style="margin-top: 10px;">Sessions Start: </label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="datetime-local" name="start" value="<?php echo $edit[0]['start']; ?>">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label" style="margin-top: 10px;">Sessions ends: </label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="datetime-local" name="ending" value="<?php echo $edit[0]['ends']; ?>">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-md-10" style="margin-top: 10px;">
                                        <label>Title</label>
                                        <input type="text" class="form-control" name="title" value="<?php echo $edit[0]['title']; ?>">
                                    </div>
                                    <input type="hidden" value="<?php echo $_GET['id']; ?>" name="id">
                                    <br>
                                    <div style="margin-bottom: 10px; margin-top: 10px; margin-left: 15px; position: relative; float: left;">
                                        <input type="submit" value="Edit Booking" name="edit" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">

                            </div>
                        </div>
                    </div>
                </div>
            </div>		<!-- .block_content ends -->

            <div class="bendl"></div>
            <div class="bendr"></div>

        </div>
        <?php
    elseif (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['tool'] == "delete"):
        if (isset($_GET['confirm']) && $_GET['confirm'] == 1):
            ?>
            <div class="block">

                <div class="block_head">
                    <div class="bheadl"></div>
                    <div class="bheadr"></div>

                    <h2>Deleting Booking Session</h2>
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

                    <h2>Delete Booking</h2>
                </div>		<!-- .block_head ends -->
                <div class="block_content">
                    <div class="alert alert-success fade in block-inner" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <i class="icon-checkmark-circle"></i> You have successful deleted: <?php echo $_GET['id']; ?>. You will be redirected in a few seconds... </div>
                    <div id="remote_modal" class="modal fade in" tabindex="-1" role="dialog" style="display: block;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header" style="background-color: #657580;">
                                    <a href="?acp=booking" class="close" data-dismiss="modal" aria-hidden="true">&times;</a>
                                    <h4 class="modal-title"><i class="icon-calendar2"></i>Delete Booking with ID : <?php echo $_GET['id']; ?></h4>
                                </div>
                                <div class="modal-body with-padding centerDelete">
                                    <div > <button class="btn btn-primary btn-block run-second" role="button"">Delete</button></div>
                                    <div> <a href="?acp=booking" class="btn btn-primary" role="button"">Cancel</a></div>
                                </div>
                                <div class="modal-footer">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>		<!-- .block_content ends -->

                <div class="bendl"></div>
                <div class="bendr"></div>

            </div>
            <div class="overlay" ><div class="opacity"></div><i class="icon-spinner3 spin"></i></div>
            <script type="text/javascript">
                $('.run-second').click(function() {
                    $('#remote_modal').fadeOut("fast");
                    $('.overlay').fadeIn("slow");
                    $.ajax({
                        type: 'POST',
                        url: "?acp=booking&action=delete&id=<?php echo $_GET['id']; ?>",
                        dataType: "text",
                        success: function() {
                            $('.overlay').delay(800).fadeOut("slow");
                            $('.alert-success').delay(800).fadeIn("slov");
                            setTimeout(function() {
                                window.location.href = "?acp=booking"
                            }, 5000);
                        }
                    });
                });
            </script>
        <?php
        endif;
    else:
        ?>
        <div class="block">

            <div class="block_head">
                <div class="bheadl"></div>
                <div class="bheadr"></div>
                <h2 class="panel-title"><i class="icon-calendar2"></i> Booking System</h2>
            </div>		<!-- .block_head ends -->

            <div class="block_content" style="min-height: 400px;">
                <div class="dropdown" style="list-style: none;"> <button class="btn btn-primary" data-toggle="modal" role="button" data-target="#remote_modal">New Booking</button></div>

                <br />
                <div class="tab-pane active fade in" id="all-tasks">
                    <div class="panel panel-default">

                        <div class="datatable-tasks">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Session Description</th>
                                        <th>Session Instructor</th>
                                        <th class="task-date-added">Start</th>
                                        <th class="task-date-added">Ending</th>
                                        <th class="task-tools text-center">Tools</th>
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
                                            <td class="task-desc"><a href=""><?php echo $event['title']; ?></a> <span> Session Number: <?php echo $event['id']; ?></span></td>
                                            <td><?php echo $event['Full_name']; ?></td>
                                            <td><?php echo $startDate[2] . "/" . $startDate[1] . "/" . $startDate[0]; ?></td>
                                            <td><?php echo $endDate[2] . "/" . $endDate[1] . "/" . $endDate[0]; ?></td>
                                            <td class="text-center"><div class="btn-group">
                                                    <button type="button" class="btn btn-icon btn-success dropdown-toggle" data-toggle="dropdown"><i class="icon-cog4"></i></button>
                                                    <ul class="dropdown-menu icons-right dropdown-menu-right">
                                                        <li><a href="?acp=booking&id=<?php echo $event['id']; ?>&tool=edit"><i class="icon-quill2"></i> Edit Session</a></li>
                                                        <li><a href="?acp=booking&id=<?php echo $event['id']; ?>&tool=delete"><i class="icon-share2"></i> Delete</a></li>
                                                    </ul>
                                                </div></td>
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
                            <h4 class="modal-title"><i class="icon-calendar2"></i>New booking</h4>
                        </div>
                        <div class="modal-body with-padding">

                            <form method="POST" action="?acp=booking">

                                <div class="form-group">
                                    <label class="col-sm-12 control-label" >Instructor </label>
                                    <div class="col-sm-10">
                                        <?php
                                        if (User::$isAdmin == TRUE):
                                            ?>
                                            <select name="who" name="instructor"  class="form-control">
                                                <option>Instructors..</option>
                                                <?php
                                                foreach ($instructors as $instr):
                                                    echo '<option value="' . $instr['id'] . '">' . $instr['Full_name'] . '</option>';
                                                endforeach;
                                                ?>
                                            </select>
                                            <?php
                                        else:
                                            ?>
                                            <input type="text" name="instructor" class="form-control" readonly="readonly" value="<?php echo User::$Full_name; ?>">
                                        <?php
                                        endif;
                                        ?>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12 control-label" style="margin-top: 10px;">Sessions Start: </label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="datetime-local" name="start">
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label class="col-sm-12 control-label" style="margin-top: 10px;">Sessions ends: </label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="datetime-local" name="ending">
                                    </div>
                                </div>
                                <br>
                                <div class="col-md-10" style="margin-top: 10px;">
                                    <label>Type</label>
                                    <select name="title"  class="form-control">
                                         <?php
                                                foreach ($types as $type):
                                                    echo '<option value="' . $type['name'] . '">' . $type['name'] . '</option>';
                                                endforeach;
                                                ?>
                                    </select>
                                </div>
                                <br>
                                <div style="margin-bottom: 10px; margin-top: 10px; margin-left: 15px; position: relative; float: left;">
                                    <input type="submit" value="Book Session" name="add" class="btn btn-primary">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>