<?php include_once 'menu.php';?>
<p class="user">Hello, <a href="?ucp"><?php echo User::$username; ?></a> | <a href="?logout">Logout</a></p>
</div>		<!-- #header ends -->

<?php if (isset($_GET['id']) && is_numeric($_GET['id'])): ?>
    <div class="block">

        <div class="block_head">
            <div class="bheadl"></div>
            <div class="bheadr"></div>

            <h2>Edit Navigation</h2>
        </div>		<!-- .block_head ends -->


        <div class="block_content">
            <form method="post" action="?acp=navigation&id=<?php echo $_GET['id']; ?>">
                <p>
                    <label>Display:</label><br />
                    <input type="text" name="name" class="text medium error" value="<?php echo $edit_nav['name']; ?>"/>
                </p>

                <p>
                    <label>Link:</label><br />
                    <input type="text" name="link" class="text medium error" value="<?php echo $edit_nav['link']; ?>"/>
                </p>
                <p><label>Page Type:</label> <br />
                    <select name="loggedin" class="styled">
                        <?php
                        if ($edit_nav['isIN'] == 0) {
                            echo '<option value="0">Standard</option>                                 
                                    <option value="1">Logged Out</option>                                                
                                    <option value="2">Logged in</option>';
                        } elseif ($edit_nav['isIN'] == 1) {
                            echo '<option value="1">Logged Out</option>
                                    <option value="0">Standard</option>                                             
                                    <option value="2">Logged in</option>';
                        } else {
                            echo '<option value="2">Logged in</option>
                                    <option value="0">Standard</option>
                                    <option value="1">Logged Out</option> ';
                        }
                        ?>	
                    </select></p>
                <p><label>After Link:</label> <br />
                    <?php $i = 0; ?>
                    <?php $count = count($navigation); ?>
                    <select name="after" class="styled">
                        <option value="0">None</option>
                        <?php foreach ($navigation as $n): ?>
                            <?php $i++; ?>
                            <?php if ($i != $edit_nav['id']): ?>
                                <option value="<?php echo $n['id']; ?>" <?php if ($edit_nav['id'] - 1 == $i) echo 'selected="selected"'; ?>><?php echo $n['name']; ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>					
                    </select></p>
                    <p><label>Page Content</label>(Udfyld kun hvis der er tekst i forvejen) <br />
                        <textarea class="ckeditor" name="contentEditor"><?php echo urldecode($edit_nav['content']); ?></textarea>
                    </p>
                <p>
                    <input type="submit" name="edit" class="submit small" value="Save" />
                </p>
            </form>
        </div>		<!-- .block_content ends -->

        <div class="bendl"></div>
        <div class="bendr"></div>

    </div>
<?php else: ?>
    <div class="block">

        <div class="block_head">
            <div class="bheadl"></div>
            <div class="bheadr"></div>

            <h2>Add Navigation</h2>
        </div>		<!-- .block_head ends -->

        <div class="block_content">
            <form method="post" action="?acp=navigation">

                <p>
                    <label>Display:</label><br />
                    <input type="text" name="display" class="text medium error" value=""/>
                </p>

                <p>
                    <label>Link:</label><br />
                    <input type="text" name="link" class="text medium error" value=""/>
                </p>
                <p><label>Page Type:</label> <br />
                    <select name="loggedin" class="styled">
                        <option value="0">Standard</option>
                        <option value="1">Logged Out</option>                                                
                        <option value="2">Logged in</option>	
                    </select></p>
                <p><label>After Link:</label> <br />
                    <?php $i = 0; ?>
                    <?php $count = count($navigation); ?>
                    <select name="after" class="styled">
                        <?php foreach ($navigation as $n): ?>
                            <?php $i++; ?>
                            <option value="<?php echo $n['id']; ?>" <?php if ($count == $i) echo 'selected="selected"'; ?>><?php echo $n['name']; ?></option>
                        <?php endforeach; ?>					
                    </select></p>
                    <p><label>Page Content</label> <br />
                        <textarea class="ckeditor" name="contentEditor"></textarea>
                    </p>
                <p>
                    <input type="submit" class="submit small" name="add" value="Add" />
                </p>
            </form>
        </div>		<!-- .block_content ends -->

        <div class="bendl"></div>
        <div class="bendr"></div>

    </div>
<?php endif; ?>		<!-- .block ends -->

<div class="block">

    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>

        <h2>Edit Navigation</h2>
    </div>		<!-- .block_head ends -->


    <div class="block_content">
        <?php if (count($navigation) == 0): ?>
            <div class="message errormsg"><p>Could not find any results</p></div>
        <?php else: ?>
            <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <th>Display</th>
                    <th>Link</th>
                    <th>Action</th>
                </tr>

                <?php foreach ($navigation as $n): ?>
                    <tr>
                        <td><?php echo $n['name']; ?></td>
                        <td><?php echo $n['link']; ?></td>
                        <td><a href="?acp=navigation&id=<?php echo $n['id']; ?>">Edit</a> | <a href="?acp=navigation&delete=<?php echo $n['id']; ?>">Delete</a>
                    </tr>
                    <?php //dump($r);  ?>
                <?php endforeach; ?>

            </table>
        <?php endif; ?>
    </div>		<!-- .block_content ends -->

    <div class="bendl"></div>
    <div class="bendr"></div>

</div><!-- .block ends -->
<!-- .leftcol ends -->