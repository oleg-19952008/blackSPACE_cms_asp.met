<?php include_once 'menu.php'; ?>

<p class="user">Hello, <a href="?ucp"><?php echo User::$username; ?></a> | <a href="?logout">Logout</a></p>
</div>		<!-- #header ends -->
<style>
    .photo {
        width: 300px;
        text-align: center;
    }
    .photo .ui-widget-header {
        margin: 1em 0;
    }
    .map {
        width: 350px;
        height: 350px;
    }
    .ui-tooltip {
        max-width: 350px;
    }
    #trash h4 { line-height: 16px; margin: 0 0 0.4em; }
    #trash h4 .ui-icon { float: left; }
</style>
<?php if (isset($_GET['id']) && is_numeric($_GET['id'])): ?>
    <div class="block">

        <div class="block_head">
            <div class="bheadl"></div>
            <div class="bheadr"></div>

            <h2>Edit User: <?php echo $_GET['id']; ?></h2>
        </div>		<!-- .block_head ends -->


        <div class="block_content">
            <b style="color:<?php echo $color; ?>;font-size:120%;"><?php echo $message; ?></b>

            <script>
                $(function() {
                    $("#accordion").accordion({
                        heightStyle: "content"
                    });
                });
                var id = <?php echo $_GET['id']; ?>;
                $(function() {
                    $("#catalog").accordion();
                    $("#catalog li").draggable({
                        appendTo: "body",
                        helper: "clone",
                        activeClass: "ui-state-default",
                        hoverClass: "ui-state-default",
                        cursor: "move"
                    });
                    $("#cart ol").droppable({
                        activeClass: "ui-state-default",
                        hoverClass: "ui-state-hover",
                        accept: ":not(#delete)",
                        drop: function(event, ui) {
                            var lootid = ui.draggable.context.title;
                            var id = <?php echo $_GET['id']; ?>;
                            var uid = <?php echo $_GET['userid']; ?>;
                            var th = $(this);
                            $.ajax({
                                type: 'GET',
                                async: true,
                                url: "?acp=uitems&RestrictedApi&add=yes&lootid=" + lootid + "&pid=" + id +"&uid="+ uid,
                                success: function(data) {
                                    console.log(data);
                                    var obj = $.parseJSON(data);
                                    console.log(obj);
                                    if (obj.status === "true") {
                                        var li = "<li style='height: 20px;' id='delete' class='ui-state-default' data-loot='" + lootid + "' data-id='" + obj.id + "' title='" + obj.id + "' class='ui-sortable-handle'>" + ui.draggable.text() + "</li>";
                                        $(li).appendTo(th).draggable({
                                            cancel: "a.ui-icon", // clicking an icon won't initiate dragging
                                            revert: "invalid", // when not dropped, the item will revert back to its initial position
                                            containment: "document",
                                            cursor: "move"
                                        });
                                        ;
                                    } else {
                                        ui.draggable.data("draggable").originalPosition;
                                    }
                                }
                            });

                        }
                    }).children().draggable({
                        cancel: "a.ui-icon", // clicking an icon won't initiate dragging
                        revert: "invalid", // when not dropped, the item will revert back to its initial position
                        containment: "document",
                        cursor: "move"
                    });

    //                        $("ol li #delete").click(function(){
    //                            console.log(this);
    //                            alert("admin");
    //                        });
    //                         $("button").click(function(){
    //                            alert("admin");
    //                            });
                    $("#trash, .trash").droppable({
                        accept: "ol li",
                        activeClass: "ui-state-highlight",
                        drop: function(event, ui) {
                            var lootid = ui.draggable.context.title;
                            console.log(lootid);
                            var id = <?php echo $_GET['id']; ?>;
                            var uid = <?php echo $_GET['userid']; ?>;
                            $.ajax({
                                type: 'GET',
                                async: true,
                                url: "?acp=uitems&RestrictedApi&delete=yes&lootid=" + lootid + "&pid=" + id +"&uid="+ uid,
                                success: function(data) {
                                    console.log(data);
                                    var obj = $.parseJSON(data);
                                    if (obj.status === "true") {
                                         ui.draggable.remove();
                                    } else {
                                        ui.draggable.data("draggable").originalPosition;
                                    }
                                }
                            });
                            
                        }
                    });
                });


            </script>
            <?php
//                                print_r($all['ship']);
//                                exit;
            ?>
            <p>
            <div id="accordion">

                <?php
                $allRe = array();
                $hasRe = array();
                $allDesign = array();
                $reDesign = array();
                $allformation = array();
                $reformation = array();
                foreach ($kinds as $name => $kind):
                    ?>
                    <h3><?php echo $kind; ?></h3>
                    <div>
                        <div style="float:left; padding: 10px; min-height: 100px; min-width: 25%;">
                            <h1 class="ui-widget-header">All <?php echo $kind; ?>s</h1>
                            <div id="catalog">

                                <?php
                                echo '<ul>';
                                sort($all[$kind]);
                                foreach ($all[$kind] as $k => $v):
                                    if (strpos($v['lootId'], 'resource_ore') !== false):
                                        array_push($allRe, $v);
                                    elseif (strpos($v['lootId'], 'design') !== false):
                                        array_push($allDesign, $v);
                                    elseif (strpos($v['lootId'], 'drone_formation') !== false):
                                        array_push($allformation, $v);
                                    else:
                                        echo '<li class="ui-state-default" data-loot="' . $v["lootId"] . '" ´data-moveable="yes" title="' . $v["lootId"] . '">' . $v["name"] . '</li>';
                                    endif;
                                endforeach;
                                echo '</ul>';
                                ?>
                            </div>
                        </div>
                        <div id="cart" style="float:left;  padding: 10px; min-height: 100px; min-width: 40%;">
                            <h1 class="ui-widget-header">Users <?php echo $kind; ?>s</h1>
                            <div class="ui-widget-content">
                                <ol>
                                    <?php
                                    if (key_exists($kind, $uitems)) {
                                        foreach ($uitems[$kind] as $k => $v):
                                            if (strpos($v['lootId'], 'resource_ore') !== false):
                                                array_push($hasRe, $v);
                                            elseif (strpos($v['lootId'], 'design') !== false):
                                                array_push($reDesign, $v);
                                            elseif (strpos($v['lootId'], 'drone_formation') !== false):
                                                array_push($reformation, $v);
                                            else:
                                                echo '<li id="delete" style="height: 20px;" class="ui-state-default" data-q="' . $v["Q"] . '" data-id="' . $v["id"] . '" data-loot="' . $v["lootid"] . '" title="' . $v["id"] . '">' . $v["name"].'('.$v["id"].')(A:'.$v["Q"].')' . ' | '.$v["offitime"].'</li>';
                                            endif;
                                        endforeach;
                                    }
                                    ?>
                                </ol>
                            </div>
                        </div>
                        <div id="trash" style="float:left;  padding: 10px; min-height: 100px; min-width: 25%;">
                            <h4 class="ui-widget-header"><span class="ui-icon ui-icon-trash">Trash</span> Trash</h4>
                            <div class="ui-widget-content" style="min-height: 100px;">

                            </div>
                        </div>
                    </div>
                    <?php
                endforeach;
                ?>
                <h3>Designs</h3>
                <div>
                    <div style="float:left; padding: 10px; min-height: 100px; min-width: 45%;">
                        <h1 class="ui-widget-header">All Designs</h1>
                        <div id="catalog">
                            <?php
                            echo '<ul>';
                            sort($allDesign);
                            foreach ($allDesign as $k => $v):
                                echo '<li class="ui-state-default" data-loot="' . $v["lootId"] . '" ´data-moveable="yes" title="' . $v["lootId"] . '">' . $v["name"] . '</li>';
                            endforeach;
                            echo '</ul>';
                            ?>
                        </div>
                    </div>
                    <div id="cart" style="float:left;  padding: 10px; min-height: 100px; min-width: 45%;">
                        <h1 class="ui-widget-header">Users Designs</h1>
                        <div class="ui-widget-content">
                            <ol>
                                <?php
                                foreach ($reDesign as $k => $v):
                                      echo '<li id="delete" style="height: 20px;" class="ui-state-default" data-q="' . $v["Q"] . '" data-id="' . $v["id"] . '" data-loot="' . $v["lootid"] . '" title="' . $v["id"] . '">' . $v["name"].'('.$v["id"].')' . ' | '.$v["offitime"].'</li>';
                                endforeach;
                                ?>
                            </ol>
                        </div>
                    </div>
                    <div id="trash" style="float:left;  padding: 10px; min-height: 100px; min-width: 25%;">
                        <h4 class="ui-widget-header"><span class="ui-icon ui-icon-trash">Trash</span> Trash</h4>
                        <div class="ui-widget-content" style="min-height: 100px;">

                        </div>
                    </div>
                </div>
                <h3>Drone Formations</h3>
                <div>
                    <div style="float:left; padding: 10px; min-height: 100px; min-width: 40%;">
                        <h1 class="ui-widget-header">All Formation</h1>
                        <div id="catalog">
                            <?php
                            echo '<ul>';
                            sort($allformation);
                            foreach ($allformation as $k => $v):
                                echo '<li class="ui-state-default" data-loot="' . $v["lootId"] . '" ´data-moveable="yes" title="' . $v["lootId"] . '">' . $v["name"] . '</li>';
                            endforeach;
                            echo '</ul>';
                            ?>
                        </div>
                    </div>
                    <div id="cart" style="float:left;  padding: 10px; min-height: 100px; min-width: 45%;">
                        <h1 class="ui-widget-header">Users Formations</h1>
                        <div class="ui-widget-content">
                            <ol>
                                <?php
                                foreach ($reformation as $k => $v):
                                     echo '<li id="delete" style="height: 20px;" class="ui-state-default" data-q="' . $v["Q"] . '" data-id="' . $v["id"] . '" data-loot="' . $v["lootid"] . '" title="' . $v["id"] . '">' . $v["name"].'('.$v["id"].')' . ' | '.$v["offitime"].'</li>';
                                endforeach;
                                ?>
                            </ol>
                        </div>
                    </div>
                    <div id="trash" style="float:left;  padding: 10px; min-height: 100px; min-width: 25%;">
                        <h4 class="ui-widget-header"><span class="ui-icon ui-icon-trash">Trash</span> Trash</h4>
                        <div class="ui-widget-content" style="min-height: 100px;">

                        </div>
                    </div>
                </div>
                <h3>Resources</h3>
                <div>
                    <div style="float:left; padding: 10px; min-height: 100px; min-width: 40%;">
                        <h1 class="ui-widget-header">All Resources</h1>
                        <div id="catalog">
                            <?php
                            echo '<ul>';
                            sort($allRe);
                            foreach ($allRe as $k => $v):
                                echo '<li class="ui-state-default" data-loot="' . $v["lootId"] . '" ´data-moveable="yes" title="' . $v["lootId"] . '">' . $v["name"] . '</li>';
                            endforeach;
                            echo '</ul>';
                            ?>
                        </div>
                    </div>
                    <div id="cart" style="float:left;  padding: 10px; min-height: 100px; min-width: 40%;">
                        <h1 class="ui-widget-header">Users Resources</h1>
                        <div class="ui-widget-content">
                            <ol>
                                <?php
                                foreach ($hasRe as $k => $v):
                                     echo '<li id="delete" style="height: 20px;" class="ui-state-default" data-q="' . $v["Q"] . '" data-id="' . $v["id"] . '" data-loot="' . $v["lootid"] . '" title="' . $v["id"] . '">' . $v["name"].'('.$v["id"].')' . ' | '.$v["offitime"].'</li>';
                                endforeach;
                                ?>
                            </ol>
                        </div>
                    </div>
                    <div id="trash" style="float:left;  padding: 10px; min-height: 100px; min-width: 25%;">
                        <h4 class="ui-widget-header"><span class="ui-icon ui-icon-trash">Trash</span> Trash</h4>
                        <div class="ui-widget-content" style="min-height: 100px;">

                        </div>
                    </div>
                </div>
            </div>
            <p>

                <br /><br />

        </div>		<!-- .block_content ends -->

        <div class="bendl"></div>
        <div class="bendr"></div>
    </div>
<?php else: ?>
    <div class="block">

        <div class="block_head">
            <div class="bheadl"></div>
            <div class="bheadr"></div>

            <h2>Search for User</h2>
        </div>		<!-- .block_head ends -->

        <div class="block_content">
            <form method="get" action="?acp=uitems">
                <?php if ($message == 'You can manage your users here.'): ?>
                    <div class="message info"><p><?php echo $message; ?></p></div>
                <?php elseif ($message == 'Settings saved successfully'): ?>
                    <div class="message success"><p><?php echo $message; ?></p></div>
                <?php else: ?>
                    <div class="message errormsg"><p><?php echo $message; ?></p></div>
    <?php endif; ?>

                <p>
                    <input type="hidden" name="acp" value="uitems">
                    <label>Search for User where:</label>
                    <select class="styled" name="type">
                        <option value="playerID" <?php if ($type == 'playerID') echo 'selected="selected"'; ?>>Player ID</option>
                    </select></p>
-
                <p>
                    <label>is:</label> <br />
                    <input type="text" name="search" class="text medium error" value="<?php echo $search; ?>"/>
                </p>
                <br />

                <p>
                    <input type="submit" class="submit small" value="Search" />
                </p>
            </form>	
        </div>		<!-- .block_content ends -->

        <div class="bendl"></div>
        <div class="bendr"></div>

    </div>		<!-- .block ends -->

    <?php if ($search != ''): ?>
        <div class="block">

            <div class="block_head">
                <div class="bheadl"></div>
                <div class="bheadr"></div>

                <h2>Results</h2>
            </div>		<!-- .block_head ends -->


            <div class="block_content">
                <?php if (count($results) == 0): ?>
                    <div class="message errormsg"><p>Could not find any results</p></div>
        <?php else: ?>
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                        </tr>

            <?php foreach ($results as $r): ?>
                            <tr>
                                <td><a href="?acp=uitems&id=<?php echo $r['playerID']; ?>&userid=<?php echo $r['userID']; ?>"><?php echo $r['Name']; ?></a></td>
                                <td><?php echo $r['Email']; ?></td>
                            </tr>
                    <?php endforeach; ?>

                    </table>
        <?php endif; ?>
            </div>		<!-- .block_content ends -->

            <div class="bendl"></div>
            <div class="bendr"></div>

        </div>
    <?php endif; ?>
<?php endif; ?>	<!-- .block ends -->
<!-- .leftcol ends -->