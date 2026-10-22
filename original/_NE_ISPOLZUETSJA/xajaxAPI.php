<?php
require './KERNEL-DOCMS/Init.php';
$Users->checkSession();
$factory->setId($Users->DataRow['ID'], $Users->DataRow['playerID']);
$techs = $factory->getTimes();
$rank = $base->GetRank($Users->DataRow['ID'], $Users->DataRow['playerID']);
$mRy = $rnk->getMyRanking($Users->DataRow['playerID']);
$myRanking = $mRy[0];
$clan->setId($Users->DataRow['ID'], $Users->DataRow['playerID']);
$clanid = $clan->getMyClan($Users->DataRow['playerID']);
if (isset($_POST['xjxfun']) && $_POST['xjxfun'] == "pilotSheet") {
    header("Content-Type:text/xml");
    if (strpos($_POST['xjxargs'][0], 'SshowProfilePage') !== false) {
        ?>
        <xjx><cmd cmd="as" id="pageContent" prop="innerHTML"><![CDATA[S<form id="profileStuff"><input type="hidden" name="reloadToken" value="d4f2d4192eed0c0840407b6bdc26e974">
                    <input name="friendRequestCount" type="hidden" value="0"/>
                </form>
                <div id="pageControl">
                    <div id="ppLeft">
                        <div id="ppLeftTop">
                            <div id="ppLeftTopImage" class=" resizeProfileImage">
                                <img class="profilePic" src="http://do-usr-strg.bpcdn.net/Darkorbit/ProfilePics/Avatar/Default/avatar.jpg"/>
                            </div>
                            <div id="ppLeftTopName" class="profileTitleFont">Name
                                <br/><span class="profilePageFont"><?php echo $Users->DataRow['Name']; ?></span><br/>
                            </div>
                        </div>
                        <div id="ppHorSep1" class="ppHorizontalSeparator"></div>
                        <div id="ppLeftMiddle">
                            <div id="ppLeftMiddleTitle" class="profileTitleFont">Player stats</div>
                            <div class="scroll-pane" style="height: 75px; width: 180px;">
                                <table cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td class="profilePageFont profilePageFontTitle" style="width: 38%"  title="User since:">User since:</td>
                                        <td class="profilePageFont" style="width: 62%">01-05-2013</td>
                                    </tr>
                                    <tr>
                                        <td class="profilePageFont userInfo_right profilePageFontTitle"
                                            style="width: 41%"  title="Rank:">Rank:</td>
                                        <td class="profilePageFont" style="width: 59%;">
                                            <div style="padding-left: 22px; width:100px; background-image: url(./do_img/global/ranks/rank_<?php echo $rank['rank']; ?>.png?__cv=d0d033082e6f5947dab73f9be6f13300); background-repeat: no-repeat;position:relative; left: -10px;height: 16px;margin-top: 4px;"
                                                 title="<?php echo $rank['name']; ?>">
                                                <nobr><?php echo $rank['name']; ?></nobr>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="profilePageFont profilePageFontTitle" style="width: 38%"  title="Ranking:">Ranking:</td>
                                        <td class="profilePageFont" style="width: 62%"><?php echo number_format($myRanking['overallRank']); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div id="ppHorSep2" class="ppHorizontalSeparator"></div>
                        <div id="ppLeftBottom">
                            <div id="ppLeftTopBottomTitle" class="profileTitleFont">Clan stats</div>
                            <table cellpadding="0" cellspacing="0" style="width: 100%">
                                <tr>
                                    <td class="profilePageFont"><?php
                                        if ($clanid == 0): echo "Not available";
                                        else: echo $clan->getClanName($clanid);
                                        endif;
                                        ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div id="ppVerSep1" class="ppVerticalSeparator"></div>

                    <div id="ppMiddle">
                        <div id="ppMiddleTop">
                            <div id="ppMiddleTitle" class="profileTitleFont">Player info</div>
                            <div style="width: 290px; height: 110px;" class="scroll-pane">
                                <table cellpadding="0" cellspacing="0" border="0">
                                    <tr>
                                        <td class="profilePageFont profilePageFontTitle minDistance">Country:</td>
                                        <td class="profilePageFont maxDistance">No info provided</td>
                                    </tr>
                                    <tr>
                                        <td class="profilePageFont profilePageFontTitle minDistance"
                                            style="width: 25%">City:</td>
                                        <td class="profilePageFont maxDistance">No info provided</td>
                                    </tr>
                                    <tr>
                                        <td class="profilePageFont profilePageFontTitle">Age:</td>
                                        <td class="profilePageFont maxDistance">No info provided</td>
                                    </tr>
                                    <tr>
                                        <td class="profilePageFont profilePageFontTitle minDistance">Gender:</td>
                                        <td class="profilePageFont maxDistance">No info provided</td>
                                    </tr>
                                    <tr>
                                        <td class="profilePageFont profilePageFontTitle minDistance">Interests:</td>
                                        <td class="profilePageFont maxDistance">No info provided</td>
                                    </tr>
                                    <tr>
                                        <td class="profilePageFont profilePageFontTitle minDistance">Contact:</td>
                                    </tr>
                                </table>
                            </div>
                            <form id="statsMessForm"><input type="hidden" name="reloadToken" value="a7ad029b3d669113489f3bdfa3d6f63e">
                                <input id="statsMessDiv" name="statsMess" type="hidden" value="">
                            </form>
                            <div id="ppMiddleStatus">
                                <div id="ppLeftMiddleStatusTitle" class="profileTitleFont">Status</div>
                                <div class="statMessTextarea">
                                    <form id="statusMessageForm" name="statusMessageForm" action="imgUpload.php" method="POST" enctype="multipart/form-data" target="uploadTarget"><input type="hidden" name="reloadToken" value="a7ad029b3d669113489f3bdfa3d6f63e">
                                        <input id="changeStatusMessage" type="hidden" name="changeStatusMessage" value="no">
                                        <textarea id="statusTextbox" name="statusMessage" cols="31" rows="3"
                                                  value="" onKeyDown="misc.limitTextSize(this, 175);"
                                                  onKeyUp="misc.limitTextSize(this, 175);"></textarea>
                                    </form>
                                </div>
                                <br/>
                            </div>
                            <div id="ppMiddleStatusEdit">
                                <div id="editStatsSuccessMess"
                                     class="editStats editStatsMessSuccess hideStatus">Changes accepted</div>
                                <div id="editStatsFailedMess"
                                     class="editStats editStatsMessFailed hideStatus">No changes made</div>
                            </div>
                            <div class="profileLinks profileLinksMiddle profileLinksHeight"
                                 onclick="pilotSheet.upLoadStatusMessage();">
                                Save</div>
                            <div id="ppHorSepBig" class="ppHorizontalSeparatorBig"></div>

                            <div id="ppMiddleTopEdit">
                                <div class="profileLinksMiddle profileEditButton profileEditButtonEffects"
                                     onclick="pilotSheet.handleProfileEditForm('pageControl', 'pageContent', 'pageContent', 'show')">
                                    <div class="profileEditButtonLabel">EDIT PROFILE</div></div>
                                <div id="editStatsSuccessProfile"
                                     class="editStats hideStatus editStatsSuccessProfile">Changes accepted</div>
                                <div id="editStatsFailedProfile"
                                     class="editStats hideStatus editStatsFailedProfile">No changes made</div>
                            </div>

                           
                        </div>
                    </div>
                    <div id="ppVerSep2" class="ppVerticalSeparator"></div>
                    <div id="ppRight">
                        <div class="station<?php echo ($Users->DataRow['factionId'] === '1') ? 'Mars' : (($Users->DataRow['factionId'] === '2') ? 'Earth' : 'Venus'); ?>"></div>
                    </div>

                    <script>
                        jQuery(document).ready(function() {
                            inviteIncentives.initialiseScrollBar();


                        });
                    </script>

                </div>
                </div>
                ]]></cmd><cmd cmd="js"><![CDATA[SpilotSheet.hideInviteButton("hide")]]></cmd><cmd cmd="js"><![CDATA[SpilotSheet.ajaxLoader("hide")]]></cmd><cmd cmd="js">Smisc.initialiseScrollBar()</cmd></xjx>
        <?php
    } else {
        ?>
        <xjx><cmd cmd="as" id="pageContent" prop="innerHTML"><![CDATA[S<div id="pilotSheet" class="skilltree_font pilotSheet">
                    <div id="infobar">

                        <div id="logfiles">
                            <strong>
                                LOG-DISKS:
                                <span id="logFileUpdated">19</span>
                                /
                                REQUIRED:
                                <span id="requiredForNextPoints">30</span>
                            </strong>
                        </div>
                        <div id="arrow_logfile_0"></div>

                        <div id="researchpoints_container">
                            <div id="researchPoints_button_0">
                                <span class="font_inactive"><strong>EXCHANGE</strong></span>
                            </div>
                            <div id="researchPoints_arrow_0"></div>
                            <div id="researchPoints_view">
                                <strong>Pilot points: <span id="researchpoints">0</span></strong>
                            </div>
                        </div>


                    </div>


                    <br class="clearMe" />

                    <div id="researchPoints_teaser">
                        <div id="researchPoints_teaser_image_static"><img src="./do_img/global/pilotSheet/skill/researchpoints_available.jpg?__cv=c3e2ccf36218712294f986178a7b8a00" width="168" height="108"></div>
                    </div>

                    <div id="directlink_logfiles" onclick="do_redirect('indexInternal.es?action=internalDock&tpl=internalDockSpecials')">
                        <div>Buy log-disks with Uridium</div>
                    </div>
                    <div id="skillTreeHorScrollable">
                        <div class="skillContainerAll" id="skillContainer">
                            <div class="scrollBackground">
                                <div class="skillContainer" style="float:left; text-align: left">
                                    <div id="skill_1" class="skill"
                                         >
                                        <div class="skill_effect_inactive noCursor                 customTooltip type_skillTree loadType_normal id_skill_1_info inner_skillTreeHorScrollable  outer_profilePage top_120 left_300">
                                            <div class="skillPoints
                                                 skilltree_font_fail_skillPoints
                                                 ">
                                                0/5
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="skillContainer" style="float:left; text-align: left">
                                    <div id="skill_2" class="skill"
                                         >
                                        <div class="skill_effect noCursor                 customTooltip type_skillTree loadType_normal id_skill_2_info inner_skillTreeHorScrollable  outer_profilePage top_120 left_300">
                                            <div class="skillPoints
                                                 skilltree_font_fail_skillPoints
                                                 ">
                                                0/5
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="skillContainer" style="float:left; text-align: left">
                                    <div id="skill_4" class="skill"
                                         >
                                        <div class="skill_effect_inactive noCursor                 customTooltip type_skillTree loadType_normal id_skill_4_info inner_skillTreeHorScrollable  outer_profilePage top_120 left_300">
                                            <div class="skillPoints
                                                 skilltree_font_fail_skillPoints
                                                 ">
                                                0/5
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="skillContainer" style="float:left; text-align: left">
                                    <div id="skill_5a" class="skill"
                                         >
                                        <div class="skill_effect noCursor                 customTooltip type_skillTree loadType_normal id_skill_5a_info inner_skillTreeHorScrollable  outer_profilePage top_120 left_300">
                                            <div class="skillPoints
                                                 skilltree_font_fail_skillPoints
                                                 ">
                                                0/2
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="skillContainer" style="float:left; text-align: left">
                                    <div id="skill_5b" class="skill"
                                         >
                                        <div class="skill_effect_inactive noCursor                 customTooltip type_skillTree loadType_normal id_skill_5b_info inner_skillTreeHorScrollable  outer_profilePage top_120 left_300">
                                            <div class="skillPoints
                                                 skilltree_font_fail_skillPoints
                                                 ">
                                                0/3
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="skillContainer" style="float:left; text-align: left">
                                    <div id="skill_6" class="skill"
                                         >
                                        <div class="skill_effect_inactive noCursor                 customTooltip type_skillTree loadType_normal id_skill_6_info inner_skillTreeHorScrollable  outer_profilePage top_120 left_300">
                                            <div class="skillPoints
                                                 skilltree_font_fail_skillPoints
                                                 ">
                                                0/5
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="skillContainer" style="float:left; text-align: left">
                                    <div id="skill_8" class="skill"
                                         >
                                        <div class="skill_effect_inactive noCursor                 customTooltip type_skillTree loadType_normal id_skill_8_info inner_skillTreeHorScrollable  outer_profilePage top_120 left_300">
                                            <div class="skillPoints
                                                 skilltree_font_fail_skillPoints
                                                 ">
                                                0/5
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="skillContainer" style="float:left; text-align: left">
                                    <div id="skill_9" class="skill"
                                         >
                                        <div class="skill_effect_inactive noCursor                 customTooltip type_skillTree loadType_normal id_skill_9_info inner_skillTreeHorScrollable  outer_profilePage top_120 left_300">
                                            <div class="skillPoints
                                                 skilltree_font_fail_skillPoints
                                                 ">
                                                0/5
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="skillContainer" style="float:left; text-align: left">
                                    <div id="skill_11" class="skill"
                                         >
                                        <div class="skill_effect_inactive noCursor                 customTooltip type_skillTree loadType_normal id_skill_11_info inner_skillTreeHorScrollable  outer_profilePage top_120 left_300">
                                            <div class="skillPoints
                                                 skilltree_font_fail_skillPoints
                                                 ">
                                                0/5
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="skillContainer" style="float:left; text-align: left">
                                    <div id="skill_13" class="skill"
                                         >
                                        <div class="skill_effect_inactive noCursor                 customTooltip type_skillTree loadType_normal id_skill_13_info inner_skillTreeHorScrollable  outer_profilePage top_120 left_300">
                                            <div class="skillPoints
                                                 skilltree_font_fail_skillPoints
                                                 ">
                                                0/5
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="skillContainer" style="float:left; text-align: left">
                                    <div id="skill_14" class="skill"
                                         >
                                        <div class="skill_effect_inactive noCursor                 customTooltip type_skillTree loadType_normal id_skill_14_info inner_skillTreeHorScrollable  outer_profilePage top_120 left_300">
                                            <div class="skillPoints
                                                 skilltree_font_fail_skillPoints
                                                 ">
                                                0/5
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="skillContainer" style="float:left; text-align: left">
                                    <div id="skill_15" class="skill"
                                         >
                                        <div class="skill_effect_inactive noCursor                 customTooltip type_skillTree loadType_normal id_skill_15_info inner_skillTreeHorScrollable  outer_profilePage top_120 left_300">
                                            <div class="skillPoints
                                                 skilltree_font_fail_skillPoints
                                                 ">
                                                0/5
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="skillContainer" style="float:left; text-align: left">
                                    <div id="skill_16a" class="skill"
                                         >
                                        <div class="skill_effect_inactive noCursor                 customTooltip type_skillTree loadType_normal id_skill_16a_info inner_skillTreeHorScrollable  outer_profilePage top_120 left_300">
                                            <div class="skillPoints
                                                 skilltree_font_fail_skillPoints
                                                 ">
                                                0/2
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="skillContainer" style="float:left; text-align: left">
                                    <div id="skill_16b" class="skill"
                                         >
                                        <div class="skill_effect_inactive noCursor                 customTooltip type_skillTree loadType_normal id_skill_16b_info inner_skillTreeHorScrollable  outer_profilePage top_120 left_300">
                                            <div class="skillPoints
                                                 skilltree_font_fail_skillPoints
                                                 ">
                                                0/3
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="skillContainer" style="float:left; text-align: left">
                                    <div id="skill_17" class="skill"
                                         >
                                        <div class="skill_effect_inactive noCursor                 customTooltip type_skillTree loadType_normal id_skill_17_info inner_skillTreeHorScrollable  outer_profilePage top_120 left_300">
                                            <div class="skillPoints
                                                 skilltree_font_fail_skillPoints
                                                 ">
                                                0/5
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="skillContainer" style="float:left; text-align: left">
                                    <div id="skill_18a" class="skill"
                                         >
                                        <div class="skill_effect noCursor                 customTooltip type_skillTree loadType_normal id_skill_18a_info inner_skillTreeHorScrollable  outer_profilePage top_120 left_300">
                                            <div class="skillPoints
                                                 skilltree_font_fail_skillPoints
                                                 ">
                                                0/2
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="skillContainer" style="float:left; text-align: left">
                                    <div id="skill_18b" class="skill"
                                         >
                                        <div class="skill_effect_inactive noCursor                 customTooltip type_skillTree loadType_normal id_skill_18b_info inner_skillTreeHorScrollable  outer_profilePage top_120 left_300">
                                            <div class="skillPoints
                                                 skilltree_font_fail_skillPoints
                                                 ">
                                                0/3
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="skillContainer" style="float:left; text-align: left">
                                    <div id="skill_19" class="skill"
                                         >
                                        <div class="skill_effect_inactive noCursor                 customTooltip type_skillTree loadType_normal id_skill_19_info inner_skillTreeHorScrollable  outer_profilePage top_120 left_300">
                                            <div class="skillPoints
                                                 skilltree_font_fail_skillPoints
                                                 ">
                                                0/5
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="skillContainer" style="float:left; text-align: left">
                                    <div id="skill_20" class="skill"
                                         >
                                        <div class="skill_effect_inactive noCursor                 customTooltip type_skillTree loadType_normal id_skill_20_info inner_skillTreeHorScrollable  outer_profilePage top_120 left_300">
                                            <div class="skillPoints
                                                 skilltree_font_fail_skillPoints
                                                 ">
                                                0/5
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="skillContainer" style="float:left; text-align: left">
                                    <div id="skill_21a" class="skill"
                                         >
                                        <div class="skill_effect_inactive noCursor                 customTooltip type_skillTree loadType_normal id_skill_21a_info inner_skillTreeHorScrollable  outer_profilePage top_120 left_300">
                                            <div class="skillPoints
                                                 skilltree_font_fail_skillPoints
                                                 ">
                                                0/2
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="skillContainer" style="float:left; text-align: left">
                                    <div id="skill_21b" class="skill"
                                         >
                                        <div class="skill_effect_inactive noCursor                 customTooltip type_skillTree loadType_normal id_skill_21b_info inner_skillTreeHorScrollable  outer_profilePage top_120 left_300">
                                            <div class="skillPoints
                                                 skilltree_font_fail_skillPoints
                                                 ">
                                                0/3
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="skillContainer" style="float:left; text-align: left">
                                    <div id="skill_22a" class="skill"
                                         >
                                        <div class="skill_effect_inactive noCursor                 customTooltip type_skillTree loadType_normal id_skill_22a_info inner_skillTreeHorScrollable  outer_profilePage top_120 left_300">
                                            <div class="skillPoints
                                                 skilltree_font_fail_skillPoints
                                                 ">
                                                0/2
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="skillContainer" style="float:left; text-align: left">
                                    <div id="skill_22b" class="skill"
                                         >
                                        <div class="skill_effect_inactive noCursor                 customTooltip type_skillTree loadType_normal id_skill_22b_info inner_skillTreeHorScrollable  outer_profilePage top_120 left_300">
                                            <div class="skillPoints
                                                 skilltree_font_fail_skillPoints
                                                 ">
                                                0/3
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="skillContainer" style="float:left; text-align: left">
                                    <div id="skill_23a" class="skill"
                                         >
                                        <div class="skill_effect_inactive noCursor                 customTooltip type_skillTree loadType_normal id_skill_23a_info inner_skillTreeHorScrollable  outer_profilePage top_120 left_300">
                                            <div class="skillPoints
                                                 skilltree_font_fail_skillPoints
                                                 ">
                                                0/2
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="skillContainer" style="float:left; text-align: left">
                                    <div id="skill_23b" class="skill"
                                         >
                                        <div class="skill_effect_inactive noCursor                 customTooltip type_skillTree loadType_normal id_skill_23b_info inner_skillTreeHorScrollable  outer_profilePage top_120 left_300">
                                            <div class="skillPoints
                                                 skilltree_font_fail_skillPoints
                                                 ">
                                                0/3
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="researchPointUsage">
                        <strong>Pilot points used: 0/50</strong>
                    </div>

                    <div id="skillResetButtonContainer">
                    </div>
                </div>
                <div id="skill_tooltip_container">
                    <div id="skill_1_info" class="skill_tooltip" style="display: none;">
                        <div class="tooltip_header"></div>
                        <div class="tooltip_content skilltree_font">
                            <strong>Name:</strong> <strong class="skilltree_font_info">Explosives </strong>
                            <div class="tooltip_seperator"></div>
                            Level: <span class="skilltree_font_info">0/5</span><br />
                            Next level:<br />
                            <span class="skilltree_font_info">
                                Increases the radius of mine explosions by 4%<br />
                            </span>
                            <div class="tooltip_seperator"></div>

                            Prerequisites for next level:<br /><br />
                            <table id="resources" class="skilltree_font_info">
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Pilot points:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Credits:</td>
                                    <td><span class="skilltree_font_info">10,000</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Seprom:</td>
                                    <td><span class="skilltree_font_info">0</span></td>
                                </tr>
                            </table>





                            <br />
                            <span class="skilltree_font_info skilltree_font_fail">1 PP required in any of the following:</span><br />
                            <br />
                            <div id="skill_small_5a" class="skill_small"></div><div class="skill_small_name">Detonation I</div>
                            <div id="skill_small_2" class="skill_small"></div><div class="skill_small_name">Tactics</div>
                            <div id="skill_small_18a" class="skill_small"></div><div class="skill_small_name">Ship hull I</div>


                            <br class="clearMe" /><br />


                        </div>
                        <div class="tooltip_footer skilltree_font">Click here to learn this skill</div>

                    </div>
                    <div id="skill_2_info" class="skill_tooltip" style="display: none;">
                        <div class="tooltip_header"></div>
                        <div class="tooltip_content skilltree_font">
                            <strong>Name:</strong> <strong class="skilltree_font_info">Tactics</strong>
                            <div class="tooltip_seperator"></div>
                            Level: <span class="skilltree_font_info">0/5</span><br />
                            Next level:<br />
                            <span class="skilltree_font_info">
                                Receive 2% more EP for each alien kill<br />
                            </span>
                            <div class="tooltip_seperator"></div>

                            Prerequisites for next level:<br /><br />
                            <table id="resources" class="skilltree_font_info">
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Pilot points:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Credits:</td>
                                    <td><span class="skilltree_font_info">10,000</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Seprom:</td>
                                    <td><span class="skilltree_font_info">0</span></td>
                                </tr>
                            </table>

                        </div>
                        <div class="tooltip_footer skilltree_font">Click here to learn this skill</div>

                    </div>
                    <div id="skill_4_info" class="skill_tooltip" style="display: none;">
                        <div class="tooltip_header"></div>
                        <div class="tooltip_content skilltree_font">
                            <strong>Name:</strong> <strong class="skilltree_font_info">Logistics</strong>
                            <div class="tooltip_seperator"></div>
                            Level: <span class="skilltree_font_info">0/5</span><br />
                            Next level:<br />
                            <span class="skilltree_font_info">
                                Expands your cargo bay by 4%<br />
                            </span>
                            <div class="tooltip_seperator"></div>

                            Prerequisites for next level:<br /><br />
                            <table id="resources" class="skilltree_font_info">
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Pilot points:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Credits:</td>
                                    <td><span class="skilltree_font_info">10,000</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Seprom:</td>
                                    <td><span class="skilltree_font_info">0</span></td>
                                </tr>
                            </table>





                            <br />
                            <span class="skilltree_font_info skilltree_font_fail">1 PP required in any of the following:</span><br />
                            <br />
                            <div id="skill_small_5a" class="skill_small"></div><div class="skill_small_name">Detonation I</div>
                            <div id="skill_small_2" class="skill_small"></div><div class="skill_small_name">Tactics</div>
                            <div id="skill_small_18a" class="skill_small"></div><div class="skill_small_name">Ship hull I</div>


                            <br class="clearMe" /><br />


                        </div>
                        <div class="tooltip_footer skilltree_font">Click here to learn this skill</div>

                    </div>
                    <div id="skill_5a_info" class="skill_tooltip" style="display: none;">
                        <div class="tooltip_header"></div>
                        <div class="tooltip_content skilltree_font">
                            <strong>Name:</strong> <strong class="skilltree_font_info">Detonation I</strong>
                            <div class="tooltip_seperator"></div>
                            Level: <span class="skilltree_font_info">0/2</span><br />
                            Next level:<br />
                            <span class="skilltree_font_info">
                                Makes your mines cause 7% more damage<br />
                            </span>
                            <div class="tooltip_seperator"></div>

                            Prerequisites for next level:<br /><br />
                            <table id="resources" class="skilltree_font_info">
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Pilot points:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Credits:</td>
                                    <td><span class="skilltree_font_info">10,000</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Seprom:</td>
                                    <td><span class="skilltree_font_info">0</span></td>
                                </tr>
                            </table>

                        </div>
                        <div class="tooltip_footer skilltree_font">Click here to learn this skill</div>

                    </div>
                    <div id="skill_5b_info" class="skill_tooltip" style="display: none;">
                        <div class="tooltip_header"></div>
                        <div class="tooltip_content skilltree_font">
                            <strong>Name:</strong> <strong class="skilltree_font_info">Detonation II</strong>
                            <div class="tooltip_seperator"></div>
                            Level: <span class="skilltree_font_info">0/3</span><br />
                            Next level:<br />
                            <span class="skilltree_font_info">
                                Makes your mines cause 21% more damage<br />
                            </span>
                            <div class="tooltip_seperator"></div>

                            Prerequisites for next level:<br /><br />
                            <table id="resources" class="skilltree_font_info">
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Pilot points:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Credits:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1,000,000</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Seprom:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1,000</span></td>
                                </tr>
                            </table>





                            <br />
                            <span class="skilltree_font_info skilltree_font_fail">3 PP required in any of the following:</span><br />
                            <br />
                            <div id="skill_small_11" class="skill_small"></div><div class="skill_small_name">Alien hunter</div>
                            <div id="skill_small_14" class="skill_small"></div><div class="skill_small_name">Tractor beam I</div>


                            <br class="clearMe" /><br />




                            <br />
                            <span class="skilltree_font_info skilltree_font_fail">2 PP required in:</span><br />
                            <br />
                            <div id="skill_small_5a" class="skill_small"></div><div class="skill_small_name">Detonation I</div>


                            <br class="clearMe" /><br />


                        </div>
                        <div class="tooltip_footer skilltree_font">Click here to learn this skill</div>

                    </div>
                    <div id="skill_6_info" class="skill_tooltip" style="display: none;">
                        <div class="tooltip_header"></div>
                        <div class="tooltip_content skilltree_font">
                            <strong>Name:</strong> <strong class="skilltree_font_info">Rocket fusion</strong>
                            <div class="tooltip_seperator"></div>
                            Level: <span class="skilltree_font_info">0/5</span><br />
                            Next level:<br />
                            <span class="skilltree_font_info">
                                Makes your rockets cause 2% more damage<br />
                            </span>
                            <div class="tooltip_seperator"></div>

                            Prerequisites for next level:<br /><br />
                            <table id="resources" class="skilltree_font_info">
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Pilot points:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Credits:</td>
                                    <td><span class="skilltree_font_info">100,000</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Seprom:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">100</span></td>
                                </tr>
                            </table>





                            <br />
                            <span class="skilltree_font_info skilltree_font_fail">2 PP required in any of the following:</span><br />
                            <br />
                            <div id="skill_small_22a" class="skill_small"></div><div class="skill_small_name">Bounty Hunter I</div>
                            <div id="skill_small_23a" class="skill_small"></div><div class="skill_small_name">Luck I</div>
                            <div id="skill_small_18b" class="skill_small"></div><div class="skill_small_name">Ship hull II</div>


                            <br class="clearMe" /><br />


                        </div>
                        <div class="tooltip_footer skilltree_font">Click here to learn this skill</div>

                    </div>
                    <div id="skill_8_info" class="skill_tooltip" style="display: none;">
                        <div class="tooltip_header"></div>
                        <div class="tooltip_content skilltree_font">
                            <strong>Name:</strong> <strong class="skilltree_font_info">Shield mechanics</strong>
                            <div class="tooltip_seperator"></div>
                            Level: <span class="skilltree_font_info">0/5</span><br />
                            Next level:<br />
                            <span class="skilltree_font_info">
                                Lets your shields withstand 2% more damage<br />
                            </span>
                            <div class="tooltip_seperator"></div>

                            Prerequisites for next level:<br /><br />
                            <table id="resources" class="skilltree_font_info">
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Pilot points:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Credits:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1,000,000</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Seprom:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1,000</span></td>
                                </tr>
                            </table>





                            <br />
                            <span class="skilltree_font_info skilltree_font_fail">3 PP required in:</span><br />
                            <br />
                            <div id="skill_small_18b" class="skill_small"></div><div class="skill_small_name">Ship hull II</div>


                            <br class="clearMe" /><br />


                        </div>
                        <div class="tooltip_footer skilltree_font">Click here to learn this skill</div>

                    </div>
                    <div id="skill_9_info" class="skill_tooltip" style="display: none;">
                        <div class="tooltip_header"></div>
                        <div class="tooltip_content skilltree_font">
                            <strong>Name:</strong> <strong class="skilltree_font_info">Greed</strong>
                            <div class="tooltip_seperator"></div>
                            Level: <span class="skilltree_font_info">0/5</span><br />
                            Next level:<br />
                            <span class="skilltree_font_info">
                                Receive 4% more Credits for alien kills<br />
                            </span>
                            <div class="tooltip_seperator"></div>

                            Prerequisites for next level:<br /><br />
                            <table id="resources" class="skilltree_font_info">
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Pilot points:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Credits:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1,000,000</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Seprom:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1,000</span></td>
                                </tr>
                            </table>





                            <br />
                            <span class="skilltree_font_info skilltree_font_fail">3 PP required in any of the following:</span><br />
                            <br />
                            <div id="skill_small_11" class="skill_small"></div><div class="skill_small_name">Alien hunter</div>
                            <div id="skill_small_14" class="skill_small"></div><div class="skill_small_name">Tractor beam I</div>


                            <br class="clearMe" /><br />


                        </div>
                        <div class="tooltip_footer skilltree_font">Click here to learn this skill</div>

                    </div>
                    <div id="skill_11_info" class="skill_tooltip" style="display: none;">
                        <div class="tooltip_header"></div>
                        <div class="tooltip_content skilltree_font">
                            <strong>Name:</strong> <strong class="skilltree_font_info">Alien hunter</strong>
                            <div class="tooltip_seperator"></div>
                            Level: <span class="skilltree_font_info">0/5</span><br />
                            Next level:<br />
                            <span class="skilltree_font_info">
                                Makes your lasers cause 2% more damage against aliens<br />
                            </span>
                            <div class="tooltip_seperator"></div>

                            Prerequisites for next level:<br /><br />
                            <table id="resources" class="skilltree_font_info">
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Pilot points:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Credits:</td>
                                    <td><span class="skilltree_font_info">100,000</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Seprom:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">100</span></td>
                                </tr>
                            </table>





                            <br />
                            <span class="skilltree_font_info skilltree_font_fail">2 PP required in each of the following:</span><br />
                            <br />
                            <div id="skill_small_6" class="skill_small"></div><div class="skill_small_name">Rocket fusion</div>
                            <div id="skill_small_21a" class="skill_small"></div><div class="skill_small_name">Cruelty I</div>


                            <br class="clearMe" /><br />


                        </div>
                        <div class="tooltip_footer skilltree_font">Click here to learn this skill</div>

                    </div>
                    <div id="skill_13_info" class="skill_tooltip" style="display: none;">
                        <div class="tooltip_header"></div>
                        <div class="tooltip_content skilltree_font">
                            <strong>Name:</strong> <strong class="skilltree_font_info">Engineering</strong>
                            <div class="tooltip_seperator"></div>
                            Level: <span class="skilltree_font_info">0/5</span><br />
                            Next level:<br />
                            <span class="skilltree_font_info">
                                Lets your repair bots repair 5% more HP per second<br />
                            </span>
                            <div class="tooltip_seperator"></div>

                            Prerequisites for next level:<br /><br />
                            <table id="resources" class="skilltree_font_info">
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Pilot points:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Credits:</td>
                                    <td><span class="skilltree_font_info">10,000</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Seprom:</td>
                                    <td><span class="skilltree_font_info">0</span></td>
                                </tr>
                            </table>





                            <br />
                            <span class="skilltree_font_info skilltree_font_fail">1 PP required in any of the following:</span><br />
                            <br />
                            <div id="skill_small_5a" class="skill_small"></div><div class="skill_small_name">Detonation I</div>
                            <div id="skill_small_2" class="skill_small"></div><div class="skill_small_name">Tactics</div>
                            <div id="skill_small_18a" class="skill_small"></div><div class="skill_small_name">Ship hull I</div>


                            <br class="clearMe" /><br />


                        </div>
                        <div class="tooltip_footer skilltree_font">Click here to learn this skill</div>

                    </div>
                    <div id="skill_14_info" class="skill_tooltip" style="display: none;">
                        <div class="tooltip_header"></div>
                        <div class="tooltip_content skilltree_font">
                            <strong>Name:</strong> <strong class="skilltree_font_info">Tractor beam I</strong>
                            <div class="tooltip_seperator"></div>
                            Level: <span class="skilltree_font_info">0/5</span><br />
                            Next level:<br />
                            <span class="skilltree_font_info">
                                Increases cargo box loot by 1%<br />
                            </span>
                            <div class="tooltip_seperator"></div>

                            Prerequisites for next level:<br /><br />
                            <table id="resources" class="skilltree_font_info">
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Pilot points:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Credits:</td>
                                    <td><span class="skilltree_font_info">100,000</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Seprom:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">100</span></td>
                                </tr>
                            </table>





                            <br />
                            <span class="skilltree_font_info skilltree_font_fail">2 PP required in any of the following:</span><br />
                            <br />
                            <div id="skill_small_6" class="skill_small"></div><div class="skill_small_name">Rocket fusion</div>
                            <div id="skill_small_21a" class="skill_small"></div><div class="skill_small_name">Cruelty I</div>
                            <div id="skill_small_18b" class="skill_small"></div><div class="skill_small_name">Ship hull II</div>


                            <br class="clearMe" /><br />


                        </div>
                        <div class="tooltip_footer skilltree_font">Click here to learn this skill</div>

                    </div>
                    <div id="skill_15_info" class="skill_tooltip" style="display: none;">
                        <div class="tooltip_header"></div>
                        <div class="tooltip_content skilltree_font">
                            <strong>Name:</strong> <strong class="skilltree_font_info">Tractor beam II</strong>
                            <div class="tooltip_seperator"></div>
                            Level: <span class="skilltree_font_info">0/5</span><br />
                            Next level:<br />
                            <span class="skilltree_font_info">
                                Increases bonus box loot by 2%<br />
                            </span>
                            <div class="tooltip_seperator"></div>

                            Prerequisites for next level:<br /><br />
                            <table id="resources" class="skilltree_font_info">
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Pilot points:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Credits:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1,000,000</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Seprom:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1,000</span></td>
                                </tr>
                            </table>





                            <br />
                            <span class="skilltree_font_info skilltree_font_fail">5 PP required in any of the following:</span><br />
                            <br />
                            <div id="skill_small_5b" class="skill_small"></div><div class="skill_small_name">Detonation II</div>
                            <div id="skill_small_9" class="skill_small"></div><div class="skill_small_name">Greed</div>
                            <div id="skill_small_8" class="skill_small"></div><div class="skill_small_name">Shield mechanics</div>


                            <br class="clearMe" /><br />


                        </div>
                        <div class="tooltip_footer skilltree_font">Click here to learn this skill</div>

                    </div>
                    <div id="skill_16a_info" class="skill_tooltip" style="display: none;">
                        <div class="tooltip_header"></div>
                        <div class="tooltip_content skilltree_font">
                            <strong>Name:</strong> <strong class="skilltree_font_info">Evasive maneuvers I</strong>
                            <div class="tooltip_seperator"></div>
                            Level: <span class="skilltree_font_info">0/2</span><br />
                            Next level:<br />
                            <span class="skilltree_font_info">
                                Reduces the probability of an enemy hit by 2%<br />
                            </span>
                            <div class="tooltip_seperator"></div>

                            Prerequisites for next level:<br /><br />
                            <table id="resources" class="skilltree_font_info">
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Pilot points:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Credits:</td>
                                    <td><span class="skilltree_font_info">100,000</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Seprom:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">100</span></td>
                                </tr>
                            </table>





                            <br />
                            <span class="skilltree_font_info skilltree_font_fail">2 PP required in any of the following:</span><br />
                            <br />
                            <div id="skill_small_20" class="skill_small"></div><div class="skill_small_name">Heat-seeking missiles</div>
                            <div id="skill_small_17" class="skill_small"></div><div class="skill_small_name">Shield engineering</div>


                            <br class="clearMe" /><br />


                        </div>
                        <div class="tooltip_footer skilltree_font">Click here to learn this skill</div>

                    </div>
                    <div id="skill_16b_info" class="skill_tooltip" style="display: none;">
                        <div class="tooltip_header"></div>
                        <div class="tooltip_content skilltree_font">
                            <strong>Name:</strong> <strong class="skilltree_font_info">Evasive maneuvers II</strong>
                            <div class="tooltip_seperator"></div>
                            Level: <span class="skilltree_font_info">0/3</span><br />
                            Next level:<br />
                            <span class="skilltree_font_info">
                                Reduces the probability of an enemy hit by 6%<br />
                            </span>
                            <div class="tooltip_seperator"></div>

                            Prerequisites for next level:<br /><br />
                            <table id="resources" class="skilltree_font_info">
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Pilot points:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Credits:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1,000,000</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Seprom:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1,000</span></td>
                                </tr>
                            </table>





                            <br />
                            <span class="skilltree_font_info skilltree_font_fail">3 PP required in:</span><br />
                            <br />
                            <div id="skill_small_8" class="skill_small"></div><div class="skill_small_name">Shield mechanics</div>


                            <br class="clearMe" /><br />




                            <br />
                            <span class="skilltree_font_info skilltree_font_fail">2 PP required in:</span><br />
                            <br />
                            <div id="skill_small_16a" class="skill_small"></div><div class="skill_small_name">Evasive maneuvers I</div>


                            <br class="clearMe" /><br />


                        </div>
                        <div class="tooltip_footer skilltree_font">Click here to learn this skill</div>

                    </div>
                    <div id="skill_17_info" class="skill_tooltip" style="display: none;">
                        <div class="tooltip_header"></div>
                        <div class="tooltip_content skilltree_font">
                            <strong>Name:</strong> <strong class="skilltree_font_info">Shield engineering</strong>
                            <div class="tooltip_seperator"></div>
                            Level: <span class="skilltree_font_info">0/5</span><br />
                            Next level:<br />
                            <span class="skilltree_font_info">
                                Increases your shield strength by 4%<br />
                            </span>
                            <div class="tooltip_seperator"></div>

                            Prerequisites for next level:<br /><br />
                            <table id="resources" class="skilltree_font_info">
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Pilot points:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Credits:</td>
                                    <td><span class="skilltree_font_info">10,000</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Seprom:</td>
                                    <td><span class="skilltree_font_info">0</span></td>
                                </tr>
                            </table>





                            <br />
                            <span class="skilltree_font_info skilltree_font_fail">1 PP required in any of the following:</span><br />
                            <br />
                            <div id="skill_small_1" class="skill_small"></div><div class="skill_small_name">Explosives </div>
                            <div id="skill_small_4" class="skill_small"></div><div class="skill_small_name">Logistics</div>
                            <div id="skill_small_13" class="skill_small"></div><div class="skill_small_name">Engineering</div>


                            <br class="clearMe" /><br />


                        </div>
                        <div class="tooltip_footer skilltree_font">Click here to learn this skill</div>

                    </div>
                    <div id="skill_18a_info" class="skill_tooltip" style="display: none;">
                        <div class="tooltip_header"></div>
                        <div class="tooltip_content skilltree_font">
                            <strong>Name:</strong> <strong class="skilltree_font_info">Ship hull I</strong>
                            <div class="tooltip_seperator"></div>
                            Level: <span class="skilltree_font_info">0/2</span><br />
                            Next level:<br />
                            <span class="skilltree_font_info">
                                Increases your HP by 5000<br />
                            </span>
                            <div class="tooltip_seperator"></div>

                            Prerequisites for next level:<br /><br />
                            <table id="resources" class="skilltree_font_info">
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Pilot points:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Credits:</td>
                                    <td><span class="skilltree_font_info">10,000</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Seprom:</td>
                                    <td><span class="skilltree_font_info">0</span></td>
                                </tr>
                            </table>

                        </div>
                        <div class="tooltip_footer skilltree_font">Click here to learn this skill</div>

                    </div>
                    <div id="skill_18b_info" class="skill_tooltip" style="display: none;">
                        <div class="tooltip_header"></div>
                        <div class="tooltip_content skilltree_font">
                            <strong>Name:</strong> <strong class="skilltree_font_info">Ship hull II</strong>
                            <div class="tooltip_seperator"></div>
                            Level: <span class="skilltree_font_info">0/3</span><br />
                            Next level:<br />
                            <span class="skilltree_font_info">
                                Increases your HP by 15000<br />
                            </span>
                            <div class="tooltip_seperator"></div>

                            Prerequisites for next level:<br /><br />
                            <table id="resources" class="skilltree_font_info">
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Pilot points:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Credits:</td>
                                    <td><span class="skilltree_font_info">100,000</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Seprom:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">100</span></td>
                                </tr>
                            </table>





                            <br />
                            <span class="skilltree_font_info skilltree_font_fail">2 PP required in any of the following:</span><br />
                            <br />
                            <div id="skill_small_22a" class="skill_small"></div><div class="skill_small_name">Bounty Hunter I</div>
                            <div id="skill_small_23a" class="skill_small"></div><div class="skill_small_name">Luck I</div>
                            <div id="skill_small_16a" class="skill_small"></div><div class="skill_small_name">Evasive maneuvers I</div>


                            <br />
                            <span class="skilltree_font_info skilltree_font_fail">2 PP required in:</span><br />
                            <br />
                            <div id="skill_small_18a" class="skill_small"></div><div class="skill_small_name">Ship hull I</div>


                            <br class="clearMe" /><br />


                        </div>
                        <div class="tooltip_footer skilltree_font">Click here to learn this skill</div>

                    </div>
                    <div id="skill_19_info" class="skill_tooltip" style="display: none;">
                        <div class="tooltip_header"></div>
                        <div class="tooltip_content skilltree_font">
                            <strong>Name:</strong> <strong class="skilltree_font_info">Electro-optics</strong>
                            <div class="tooltip_seperator"></div>
                            Level: <span class="skilltree_font_info">0/5</span><br />
                            Next level:<br />
                            <span class="skilltree_font_info">
                                Increases hit probability of lasers by 2%<br />
                            </span>
                            <div class="tooltip_seperator"></div>

                            Prerequisites for next level:<br /><br />
                            <table id="resources" class="skilltree_font_info">
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Pilot points:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Credits:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1,000,000</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Seprom:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1,000</span></td>
                                </tr>
                            </table>





                            <br />
                            <span class="skilltree_font_info skilltree_font_fail">5 PP required in any of the following:</span><br />
                            <br />
                            <div id="skill_small_5b" class="skill_small"></div><div class="skill_small_name">Detonation II</div>
                            <div id="skill_small_9" class="skill_small"></div><div class="skill_small_name">Greed</div>
                            <div id="skill_small_8" class="skill_small"></div><div class="skill_small_name">Shield mechanics</div>


                            <br class="clearMe" /><br />


                        </div>
                        <div class="tooltip_footer skilltree_font">Click here to learn this skill</div>

                    </div>
                    <div id="skill_20_info" class="skill_tooltip" style="display: none;">
                        <div class="tooltip_header"></div>
                        <div class="tooltip_content skilltree_font">
                            <strong>Name:</strong> <strong class="skilltree_font_info">Heat-seeking missiles</strong>
                            <div class="tooltip_seperator"></div>
                            Level: <span class="skilltree_font_info">0/5</span><br />
                            Next level:<br />
                            <span class="skilltree_font_info">
                                Increases hit probability of your rockets by 1%<br />
                            </span>
                            <div class="tooltip_seperator"></div>

                            Prerequisites for next level:<br /><br />
                            <table id="resources" class="skilltree_font_info">
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Pilot points:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Credits:</td>
                                    <td><span class="skilltree_font_info">10,000</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Seprom:</td>
                                    <td><span class="skilltree_font_info">0</span></td>
                                </tr>
                            </table>





                            <br />
                            <span class="skilltree_font_info skilltree_font_fail">1 PP required in any of the following:</span><br />
                            <br />
                            <div id="skill_small_1" class="skill_small"></div><div class="skill_small_name">Explosives </div>
                            <div id="skill_small_4" class="skill_small"></div><div class="skill_small_name">Logistics</div>
                            <div id="skill_small_13" class="skill_small"></div><div class="skill_small_name">Engineering</div>


                            <br class="clearMe" /><br />


                        </div>
                        <div class="tooltip_footer skilltree_font">Click here to learn this skill</div>

                    </div>
                    <div id="skill_21a_info" class="skill_tooltip" style="display: none;">
                        <div class="tooltip_header"></div>
                        <div class="tooltip_content skilltree_font">
                            <strong>Name:</strong> <strong class="skilltree_font_info">Cruelty I</strong>
                            <div class="tooltip_seperator"></div>
                            Level: <span class="skilltree_font_info">0/2</span><br />
                            Next level:<br />
                            <span class="skilltree_font_info">
                                Gives you 4% more honor points<br />
                            </span>
                            <div class="tooltip_seperator"></div>

                            Prerequisites for next level:<br /><br />
                            <table id="resources" class="skilltree_font_info">
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Pilot points:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Credits:</td>
                                    <td><span class="skilltree_font_info">100,000</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Seprom:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">100</span></td>
                                </tr>
                            </table>





                            <br />
                            <span class="skilltree_font_info skilltree_font_fail">2 PP required in any of the following:</span><br />
                            <br />
                            <div id="skill_small_22a" class="skill_small"></div><div class="skill_small_name">Bounty Hunter I</div>
                            <div id="skill_small_23a" class="skill_small"></div><div class="skill_small_name">Luck I</div>
                            <div id="skill_small_16a" class="skill_small"></div><div class="skill_small_name">Evasive maneuvers I</div>


                            <br class="clearMe" /><br />


                        </div>
                        <div class="tooltip_footer skilltree_font">Click here to learn this skill</div>

                    </div>
                    <div id="skill_21b_info" class="skill_tooltip" style="display: none;">
                        <div class="tooltip_header"></div>
                        <div class="tooltip_content skilltree_font">
                            <strong>Name:</strong> <strong class="skilltree_font_info">Cruelty II</strong>
                            <div class="tooltip_seperator"></div>
                            Level: <span class="skilltree_font_info">0/3</span><br />
                            Next level:<br />
                            <span class="skilltree_font_info">
                                Gives you 12% more honor points<br />
                            </span>
                            <div class="tooltip_seperator"></div>

                            Prerequisites for next level:<br /><br />
                            <table id="resources" class="skilltree_font_info">
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Pilot points:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Credits:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1,000,000</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Seprom:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1,000</span></td>
                                </tr>
                            </table>





                            <br />
                            <span class="skilltree_font_info skilltree_font_fail">3 PP required in any of the following:</span><br />
                            <br />
                            <div id="skill_small_19" class="skill_small"></div><div class="skill_small_name">Electro-optics</div>
                            <div id="skill_small_15" class="skill_small"></div><div class="skill_small_name">Tractor beam II</div>


                            <br class="clearMe" /><br />




                            <br />
                            <span class="skilltree_font_info skilltree_font_fail">2 PP required in:</span><br />
                            <br />
                            <div id="skill_small_21a" class="skill_small"></div><div class="skill_small_name">Cruelty I</div>


                            <br class="clearMe" /><br />


                        </div>
                        <div class="tooltip_footer skilltree_font">Click here to learn this skill</div>

                    </div>
                    <div id="skill_22a_info" class="skill_tooltip" style="display: none;">
                        <div class="tooltip_header"></div>
                        <div class="tooltip_content skilltree_font">
                            <strong>Name:</strong> <strong class="skilltree_font_info">Bounty Hunter I</strong>
                            <div class="tooltip_seperator"></div>
                            Level: <span class="skilltree_font_info">0/2</span><br />
                            Next level:<br />
                            <span class="skilltree_font_info">
                                Makes your lasers cause 2% more damage in PvP battles<br />
                            </span>
                            <div class="tooltip_seperator"></div>

                            Prerequisites for next level:<br /><br />
                            <table id="resources" class="skilltree_font_info">
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Pilot points:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Credits:</td>
                                    <td><span class="skilltree_font_info">100,000</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Seprom:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">100</span></td>
                                </tr>
                            </table>





                            <br />
                            <span class="skilltree_font_info skilltree_font_fail">2 PP required in any of the following:</span><br />
                            <br />
                            <div id="skill_small_20" class="skill_small"></div><div class="skill_small_name">Heat-seeking missiles</div>
                            <div id="skill_small_17" class="skill_small"></div><div class="skill_small_name">Shield engineering</div>


                            <br class="clearMe" /><br />


                        </div>
                        <div class="tooltip_footer skilltree_font">Click here to learn this skill</div>

                    </div>
                    <div id="skill_22b_info" class="skill_tooltip" style="display: none;">
                        <div class="tooltip_header"></div>
                        <div class="tooltip_content skilltree_font">
                            <strong>Name:</strong> <strong class="skilltree_font_info">Bounty Hunter II</strong>
                            <div class="tooltip_seperator"></div>
                            Level: <span class="skilltree_font_info">0/3</span><br />
                            Next level:<br />
                            <span class="skilltree_font_info">
                                Makes your lasers cause 6% more damage in PvP battles<br />
                            </span>
                            <div class="tooltip_seperator"></div>

                            Prerequisites for next level:<br /><br />
                            <table id="resources" class="skilltree_font_info">
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Pilot points:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Credits:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1,000,000</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Seprom:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1,000</span></td>
                                </tr>
                            </table>





                            <br />
                            <span class="skilltree_font_info skilltree_font_fail">3 PP required in any of the following:</span><br />
                            <br />
                            <div id="skill_small_19" class="skill_small"></div><div class="skill_small_name">Electro-optics</div>
                            <div id="skill_small_15" class="skill_small"></div><div class="skill_small_name">Tractor beam II</div>


                            <br class="clearMe" /><br />




                            <br />
                            <span class="skilltree_font_info skilltree_font_fail">2 PP required in:</span><br />
                            <br />
                            <div id="skill_small_22a" class="skill_small"></div><div class="skill_small_name">Bounty Hunter I</div>


                            <br class="clearMe" /><br />


                        </div>
                        <div class="tooltip_footer skilltree_font">Click here to learn this skill</div>

                    </div>
                    <div id="skill_23a_info" class="skill_tooltip" style="display: none;">
                        <div class="tooltip_header"></div>
                        <div class="tooltip_content skilltree_font">
                            <strong>Name:</strong> <strong class="skilltree_font_info">Luck I</strong>
                            <div class="tooltip_seperator"></div>
                            Level: <span class="skilltree_font_info">0/2</span><br />
                            Next level:<br />
                            <span class="skilltree_font_info">
                                Gives you 2% more bonus-box Uridium<br />
                            </span>
                            <div class="tooltip_seperator"></div>

                            Prerequisites for next level:<br /><br />
                            <table id="resources" class="skilltree_font_info">
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Pilot points:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Credits:</td>
                                    <td><span class="skilltree_font_info">100,000</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Seprom:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">100</span></td>
                                </tr>
                            </table>





                            <br />
                            <span class="skilltree_font_info skilltree_font_fail">2 PP required in:</span><br />
                            <br />
                            <div id="skill_small_4" class="skill_small"></div><div class="skill_small_name">Logistics</div>


                            <br class="clearMe" /><br />


                        </div>
                        <div class="tooltip_footer skilltree_font">Click here to learn this skill</div>

                    </div>
                    <div id="skill_23b_info" class="skill_tooltip" style="display: none;">
                        <div class="tooltip_header"></div>
                        <div class="tooltip_content skilltree_font">
                            <strong>Name:</strong> <strong class="skilltree_font_info">Luck II</strong>
                            <div class="tooltip_seperator"></div>
                            Level: <span class="skilltree_font_info">0/3</span><br />
                            Next level:<br />
                            <span class="skilltree_font_info">
                                Gives you 6% more bonus-box Uridium<br />
                            </span>
                            <div class="tooltip_seperator"></div>

                            Prerequisites for next level:<br /><br />
                            <table id="resources" class="skilltree_font_info">
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Pilot points:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Credits:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1,000,000</span></td>
                                </tr>
                                <tr>
                                    <td class="firstRow"><img src="./do_img/global/pilotSheet/skill/bulletPoint.gif?__cv=d39c783db907f7e7d0f2216ce56e8f00" width="2" height="2"></td>
                                    <td>Seprom:</td>
                                    <td><span class="skilltree_font_info skilltree_font_fail">1,000</span></td>
                                </tr>
                            </table>





                            <br />
                            <span class="skilltree_font_info skilltree_font_fail">3 PP required in each of the following:</span><br />
                            <br />
                            <div id="skill_small_22b" class="skill_small"></div><div class="skill_small_name">Bounty Hunter II</div>
                            <div id="skill_small_16b" class="skill_small"></div><div class="skill_small_name">Evasive maneuvers II</div>


                            <br class="clearMe" /><br />




                            <br />
                            <span class="skilltree_font_info skilltree_font_fail">2 PP required in:</span><br />
                            <br />
                            <div id="skill_small_23a" class="skill_small"></div><div class="skill_small_name">Luck I</div>


                            <br class="clearMe" /><br />


                        </div>
                        <div class="tooltip_footer skilltree_font">Click here to learn this skill</div>

                    </div>
                </div>
                ]]></cmd><cmd cmd="js"><![CDATA[SpilotSheet.hideInviteButton("hide")]]></cmd><cmd cmd="js">Stooltip.init()</cmd><cmd cmd="js">SpilotSheet.setSkilltreeScrollbar()</cmd><cmd cmd="js"><![CDATA[SpilotSheet.ajaxLoader("hide")]]></cmd></xjx><?php
    }
} elseif (isset($_POST['xjxfun']) && $_POST['xjxfun'] == "achievement") {
    header("Content-Type:text/xml");
    ?><xjx><cmd cmd="as" id="pageContent" prop="innerHTML"><![CDATA[S
            <!-- styles needed by jScrollPane - include in your own sites -->
            <link type="text/css" href="./css/jQuery/jquery.jscrollpane.css?__cv=9af65d2e9c92153b72e7289186102900" rel="stylesheet" media="all" />
            <link type="text/css" href="./css/cdn/scrollbar_dark.css?__cv=8af340facca91a2ee1e24bd860a3da00" rel="stylesheet" media="all"/>

            <style type="text/css" id="page-css">

                /* Styles specific to this particular page */

                #scroll-pane-content {
                    width: 553px;
                    height: 314px;
                    text-align: left;
                    /*padding: 0px 20px 40px 20px;*/
                }
                *+html #scroll-pane-content {
                    margin-left: 0px;
                }

                /* Styles specific to this particular page */
                .scroll-pane, .scroll-pane-arrows {
                    width: 553px;
                    height: 314px;
                    overflow: auto;
                    position: relative;
                }

                .horizontal-only {
                    height: auto;
                    max-height: 314px;
                }


            </style>

            <script type="text/javascript" src="./js/jQuery/jquery.jscrollpane.min.js?__cv=749ff03bc8608038b7d8692587f88f00"></script>
            <script type="text/javascript" id="sourcecode">

                        jQuery = jQuery.noConflict(true);
                        jQuery(function()
                        {
                            jQuery('.scroll-pane').jScrollPane({showArrows: true, autoReinitialise: true});
                        });


            </script>

            <div id="achievementContentPane">
                <div id="achievementContentTop">
                    <div id="achievementScoreLabel"><img src="do_img/global/text_tf.esg?l=en&s=10&t=label_achievement_score&f=eurostyle_tmed&color=yellow&bgcolor=grey" /></div>
                    <div id="achievementScore">660</div>
                    <div id="userPic"><img width="47" height="50" src="http://do-usr-strg.bpcdn.net/Darkorbit/ProfilePics/Avatar/5/255/651627097acbdd240cd11b9f86108fa0.gif" alt=""></div>
                    <div id="achievementCurrentTitleLabel">Selected title: Credit billionaire</div>
                    <div id="achievementCurrentTitleValue">
                    </div>

                    <div id="achievementProgressLabelContainer">
                        <div id="achievementProgressLabel">
                            <img src="do_img/global/text_tf.esg?l=en&s=10&t=label_achievement_progress&f=eurostyle_tmed&color=white&bgcolor=grey" />
                        </div>
                        <div id="achievementProgressFinished">660 / 9,950</div>
                    </div>

                    <div id="achievementProgressContainer">
                        <div id="achievementProgressValue" style="width:7%"></div>
                    </div>
                    <div id="achievementProgressValuePercent">7%</div>
                </div>

                <div id="achievementContentLeft" class="scroll-pane">
                    <ul id="achievementNavMain">
                        <li id="achievement_showOverview" class="selectedCategory" onclick="xajax_achievement('showOverview')"><div class="achivementCategoryLabel" onclick="achievement.selectedCategory('achievement_showOverview');">Overview</div></li>
                        <li id="achievement_showMyAchievements" onclick="xajax_achievement('showMyAchievements')"><div class="achivementCategoryLabel" onclick="achievement.selectedCategory('achievement_showMyAchievements');">My Achievements</div></li>
                        <li id="achievement_showTitles" onclick="xajax_achievement('showTitles')"><div class="achivementCategoryLabel" onclick="achievement.selectedCategory('achievement_showTitles');">Title</div></li>
                        <li id="achievement_showGeneral" onclick="xajax_achievement('showGeneral')"><div class="achivementCategoryLabel" onclick="achievement.selectedCategory('achievement_showGeneral');">Overall Achievements</div></li>
                        <li id="achievement_showAbility" onclick="xajax_achievement('showAbility')"><div class="achivementCategoryLabel" onclick="achievement.selectedCategory('achievement_showAbility');">Ability Achievements</div></li>
                        <li id="achievement_activity"><div class="achivementCategoryLabel">Activity Achievements</div></li>
                        <ul id="achievementNavSub">
                            <li id="achievement_activity_showDestroy" onclick="xajax_achievement('showDestroy')"><div class="achivementCategoryLabel" onclick="achievement.selectedCategory('achievement_activity_showDestroy');">Destruction</div></li>
                            <li id="achievement_activity_showCollect" onclick="xajax_achievement('showCollect')"><div class="achivementCategoryLabel" onclick="achievement.selectedCategory('achievement_activity_showCollect');">Collection</div></li>
                            <li id="achievement_activity_showQuest" onclick="xajax_achievement('showQuest')"><div class="achivementCategoryLabel" onclick="achievement.selectedCategory('achievement_activity_showQuest');">Mission</div></li>
                            <li id="achievement_activity_showDiscover" onclick="xajax_achievement('showDiscover')"><div class="achivementCategoryLabel" onclick="achievement.selectedCategory('achievement_activity_showDiscover');">Discover</div></li>
                            <li id="achievement_activity_showFactory" onclick="xajax_achievement('showFactory')"><div class="achivementCategoryLabel" onclick="achievement.selectedCategory('achievement_activity_showFactory');">Factory</div></li>
                            <li id="achievement_activity_showPet" onclick="xajax_achievement('showPet')"><div class="achivementCategoryLabel" onclick="achievement.selectedCategory('achievement_activity_showPet');">P.E.T.</div></li>
                            <li id="achievement_activity_showDrone" onclick="xajax_achievement('showDrone')"><div class="achivementCategoryLabel" onclick="achievement.selectedCategory('achievement_activity_showDrone');"><span title="Drones">Drones</span></div></li>
                            <li id="achievement_activity_showMisc" onclick="xajax_achievement('showMisc')"><div class="achivementCategoryLabel" onclick="achievement.selectedCategory('achievement_activity_showMisc');"><span title="Diverse">Diverse</span></div>
                            </li>
                        </ul>
                        <li id="achievement_showPvp" onclick="xajax_achievement('showPvp')"><div class="achivementCategoryLabel" onclick="achievement.selectedCategory('achievement_showPvp');">PvP Achievements</li>
                        <li id="achievement_event"><div class="achivementCategoryLabel">Events</li>
                        <ul id="achievementNavSub">
                            <li id="achievement_event_showEvent_Winter_2011" onclick="xajax_achievement('showEvent_Winter_2011')"><div class="achivementCategoryLabel" onclick="achievement.selectedCategory('achievement_event_showEvent_Winter_2011');">Winter 2011</li>
                            <li id="achievement_event_showEvent_Winter_2012" onclick="xajax_achievement('showEvent_Winter_2012')"><div class="achivementCategoryLabel" onclick="achievement.selectedCategory('achievement_event_showEvent_Winter_2012');">Winter 2012</li>
                            <li id="achievement_event_showEvent_Winter_2013" onclick="xajax_achievement('showEvent_Winter_2013')"><div class="achivementCategoryLabel" onclick="achievement.selectedCategory('achievement_event_showEvent_Winter_2013');">Winter 2013</li>
                            <li id="achievement_event_showEvent_Springfight_2012" onclick="xajax_achievement('showEvent_Spring_2012')"><div class="achivementCategoryLabel" onclick="achievement.selectedCategory('achievement_event_showEvent_Springfight_2012');">Spring Fight 2012</li>
                            <li id="achievement_event_showEvent_SolarClash_2012" onclick="xajax_achievement('showEvent_SolarClash_2012')"><div class="achivementCategoryLabel" onclick="achievement.selectedCategory('achievement_event_showEvent_SolarClash_2012');">Solar Clash 2012</li>
                            <li id="achievement_event_showEvent_Summer_2013" onclick="xajax_achievement('showEvent_Summer_2013')"><div class="achivementCategoryLabel" onclick="achievement.selectedCategory('achievement_event_showEvent_Summer_2013');">Conflict Rising 2013</li>
                            <li id="achievement_event_showEvent_Halloween_2013" onclick="xajax_achievement('showEvent_Halloween_2013')"><div class="achivementCategoryLabel" onclick="achievement.selectedCategory('achievement_event_showEvent_Halloween_2013');">Halloween 2013</li>
                            <li id="achievement_event_showEvent_Springfight_2014" onclick="xajax_achievement('showEvent_Springfight_2014')"><div class="achivementCategoryLabel" onclick="achievement.selectedCategory('achievement_event_showEvent_Springfight_2014');">Battle for Influence 2014</li>
                            <li id="achievement_event_showEvent_Summer_2014" onclick="xajax_achievement('showEvent_Summer_2014')"><div class="achivementCategoryLabel" onclick="achievement.selectedCategory('achievement_event_showEvent_Summer_2014');">Domination Event 2014</li>
                        </ul>
                        <li id="achievement_showSocial" onclick="xajax_achievement('showSocial')"><div class="achivementCategoryLabel" onclick="achievement.selectedCategory('achievement_showSocial');">Social Achievements</li>
                    </ul>
                    <br />
                </div>
                <div id="achievementContentRight">
                    <div class="scroll-pane"></div>
                </div>
            </div>

            ]]></cmd><cmd cmd="as" id="achievementContentRight" prop="innerHTML"><![CDATA[S<div id="overviewRecentAchievements">
                <div id="overviewRecentAchievementsLabel" style="background-image:url(/do_img/global/text_tf.esg?l=en&s=10&t=label_achievement_recent&f=eurostyle_tmed&color=yellow&bgcolor=grey);height:13px;background-repeat: no-repeat;margin:5px 0 0 5px;"></div>
                <div id="overviewRecentAchievementsBorder">
                    <div id="achievement_event_summer2014_dominator_5" style="width:63px; height:63px; background-image: url(./do_img/global/achievements/achievement_event_summer2014_dominator_5_63x63.png?__cv=67c5965c517cd81fbd08743bd6ca2e00); background-repeat: no-repeat;" class="recentAchievements"
                         onmouseover="showAchievementTooltip('general', 'achievement_event_summer2014_dominator_5');"
                         onmouseout ="hideAchievementTooltip('achievement_event_summer2014_dominator_5');">
                        <img style="margin-left: -6px; margin-top: -6px;" src="./do_img/global/achievements/achievement_title_icon_63x63.png?__cv=9cd010b4ed75aa554a0ddbab6e2b3f00">
                    </div>

                    <div id="tooltip_achievement_event_summer2014_dominator_5" class="achievement_overview_tooltip">
                        <div class="achievement_icon_tooltip" style="background-image: url(./do_img/global/achievements/achievement_event_summer2014_dominator_5_63x63.png?__cv=67c5965c517cd81fbd08743bd6ca2e00);">
                            <img src="./do_img/global/achievements/achievement_title_icon_63x63.png?__cv=9cd010b4ed75aa554a0ddbab6e2b3f00">
                        </div>
                        <div style="float: left;">
                            <div class="tooltipHeader">Dominator</div>
                            <div class="tooltipContent">Your Company earned 9 Domination Points (at which time you must be on map 4-1, 4-2, 4-3, or 4-4 in order to earn this Achievement!)</div>
                        </div>
                    </div>
                    <div id="achievement_lasershots_1" style="width:63px; height:63px; background-image: url(./do_img/global/achievements/achievement_lasershots_1_63x63.png?__cv=9232baa3eb14f2a9449d73ff798f6300); background-repeat: no-repeat;" class="recentAchievements"
                         onmouseover="showAchievementTooltip('general', 'achievement_lasershots_1');"
                         onmouseout ="hideAchievementTooltip('achievement_lasershots_1');">
                    </div>

                    <div id="tooltip_achievement_lasershots_1" class="achievement_overview_tooltip">
                        <div class="achievement_icon_tooltip" style="background-image: url(./do_img/global/achievements/achievement_lasershots_1_63x63.png?__cv=9232baa3eb14f2a9449d73ff798f6300);">
                        </div>
                        <div style="float: left;">
                            <div class="tooltipHeader">Light in the darkness</div>
                            <div class="tooltipContent">Fire 50.000 laser shots.</div>
                        </div>
                    </div>
                    <div id="achievement_collect_credits_3" style="width:63px; height:63px; background-image: url(./do_img/global/achievements/achievement_collect_credits_3_63x63.png?__cv=2ae81d591a4f22b2fcc98bb7a56fee00); background-repeat: no-repeat;" class="recentAchievements"
                         onmouseover="showAchievementTooltip('general', 'achievement_collect_credits_3');"
                         onmouseout ="hideAchievementTooltip('achievement_collect_credits_3');">
                        <img style="margin-left: -6px; margin-top: -6px;" src="./do_img/global/achievements/achievement_title_icon_63x63.png?__cv=9cd010b4ed75aa554a0ddbab6e2b3f00">
                    </div>

                    <div id="tooltip_achievement_collect_credits_3" class="achievement_overview_tooltip">
                        <div class="achievement_icon_tooltip" style="background-image: url(./do_img/global/achievements/achievement_collect_credits_3_63x63.png?__cv=2ae81d591a4f22b2fcc98bb7a56fee00);">
                            <img src="./do_img/global/achievements/achievement_title_icon_63x63.png?__cv=9cd010b4ed75aa554a0ddbab6e2b3f00">
                        </div>
                        <div style="float: left;">
                            <div class="tooltipHeader">Credit billionaire</div>
                            <div class="tooltipContent">Collect 7.500.000 Credits.</div>
                        </div>
                    </div>
                    <div id="achievement_rocketshots_2" style="width:63px; height:63px; background-image: url(./do_img/global/achievements/achievement_rocketshots_2_63x63.png?__cv=422533c20eaeb436899e29203dca8400); background-repeat: no-repeat;" class="recentAchievements"
                         onmouseover="showAchievementTooltip('general', 'achievement_rocketshots_2');"
                         onmouseout ="hideAchievementTooltip('achievement_rocketshots_2');">
                    </div>

                    <div id="tooltip_achievement_rocketshots_2" class="achievement_overview_tooltip">
                        <div class="achievement_icon_tooltip" style="background-image: url(./do_img/global/achievements/achievement_rocketshots_2_63x63.png?__cv=422533c20eaeb436899e29203dca8400);">
                        </div>
                        <div style="float: left;">
                            <div class="tooltipHeader">Death by rocket!</div>
                            <div class="tooltipContent">Fire 2.000 rockets.</div>
                        </div>
                    </div>
                    <div id="achievement_destroy_aliens_2" style="width:63px; height:63px; background-image: url(./do_img/global/achievements/achievement_destroy_aliens_2_63x63.png?__cv=3b75793ad31fd2b41f85a7daeb3eaf00); background-repeat: no-repeat;" class="recentAchievements"
                         onmouseover="showAchievementTooltip('general', 'achievement_destroy_aliens_2');"
                         onmouseout ="hideAchievementTooltip('achievement_destroy_aliens_2');">
                    </div>

                    <div id="tooltip_achievement_destroy_aliens_2" class="achievement_overview_tooltip">
                        <div class="achievement_icon_tooltip" style="background-image: url(./do_img/global/achievements/achievement_destroy_aliens_2_63x63.png?__cv=3b75793ad31fd2b41f85a7daeb3eaf00);">
                        </div>
                        <div style="float: left;">
                            <div class="tooltipHeader">Kaboom!</div>
                            <div class="tooltipContent">Destroy 250 aliens.</div>
                        </div>
                    </div>
                    <div id="achievement_player-cloaked_2" style="width:63px; height:63px; background-image: url(./do_img/global/achievements/achievement_player-cloaked_2_63x63.png?__cv=d91a40c095d6d483344394d01e926b00); background-repeat: no-repeat;" class="recentAchievements"
                         onmouseover="showAchievementTooltip('general', 'achievement_player-cloaked_2');"
                         onmouseout ="hideAchievementTooltip('achievement_player-cloaked_2');">
                    </div>

                    <div id="tooltip_achievement_player-cloaked_2" class="achievement_overview_tooltip">
                        <div class="achievement_icon_tooltip" style="background-image: url(./do_img/global/achievements/achievement_player-cloaked_2_63x63.png?__cv=d91a40c095d6d483344394d01e926b00);">
                        </div>
                        <div style="float: left;">
                            <div class="tooltipHeader">Ninja</div>
                            <div class="tooltipContent">You're cloaked for 300 minutes.</div>
                        </div>
                    </div>
                    <div id="achievement_playerlevel_2" style="width:63px; height:63px; background-image: url(./do_img/global/achievements/achievement_playerlevel_2_63x63.png?__cv=1c129ddf4e2d40f5b49430dc08291200); background-repeat: no-repeat;" class="recentAchievements"
                         onmouseover="showAchievementTooltip('general', 'achievement_playerlevel_2');"
                         onmouseout ="hideAchievementTooltip('achievement_playerlevel_2');">
                    </div>

                    <div id="tooltip_achievement_playerlevel_2" class="achievement_overview_tooltip">
                        <div class="achievement_icon_tooltip" style="background-image: url(./do_img/global/achievements/achievement_playerlevel_2_63x63.png?__cv=1c129ddf4e2d40f5b49430dc08291200);">
                        </div>
                        <div style="float: left;">
                            <div class="tooltipHeader">Space pilot</div>
                            <div class="tooltipContent">Reach level 10.</div>
                        </div>
                    </div>
                    <div id="achievement_damagedealer_1" style="width:63px; height:63px; background-image: url(./do_img/global/achievements/achievement_damagedealer_1_63x63.png?__cv=0ac0421882270e3aa0086e73fd2d6500); background-repeat: no-repeat;" class="recentAchievements"
                         onmouseover="showAchievementTooltip('general', 'achievement_damagedealer_1');"
                         onmouseout ="hideAchievementTooltip('achievement_damagedealer_1');">
                    </div>

                    <div id="tooltip_achievement_damagedealer_1" class="achievement_overview_tooltip">
                        <div class="achievement_icon_tooltip" style="background-image: url(./do_img/global/achievements/achievement_damagedealer_1_63x63.png?__cv=0ac0421882270e3aa0086e73fd2d6500);">
                        </div>
                        <div style="float: left;">
                            <div class="tooltipHeader">Take that!</div>
                            <div class="tooltipContent">Cause a total damage of 5.000.000.</div>
                        </div>
                    </div>
                    <div id="achievement_collect_bonusboxes_1" style="width:63px; height:63px; background-image: url(./do_img/global/achievements/achievement_collect_bonusboxes_1_63x63.png?__cv=f9b4275bc3aeb8597ce22054147f9b00); background-repeat: no-repeat;" class="recentAchievements"
                         onmouseover="showAchievementTooltip('general', 'achievement_collect_bonusboxes_1');"
                         onmouseout ="hideAchievementTooltip('achievement_collect_bonusboxes_1');">
                    </div>

                    <div id="tooltip_achievement_collect_bonusboxes_1" class="achievement_overview_tooltip">
                        <div class="achievement_icon_tooltip" style="background-image: url(./do_img/global/achievements/achievement_collect_bonusboxes_1_63x63.png?__cv=f9b4275bc3aeb8597ce22054147f9b00);">
                        </div>
                        <div style="float: left;">
                            <div class="tooltipHeader">Small fortune</div>
                            <div class="tooltipContent">Collect 100 bonus boxes.</div>
                        </div>
                    </div>
                    <div id="achievement_experience_2" style="width:63px; height:63px; background-image: url(./do_img/global/achievements/achievement_experience_2_63x63.png?__cv=d4abc5cd87afab0474bd89cb23523f00); background-repeat: no-repeat;" class="recentAchievements"
                         onmouseover="showAchievementTooltip('general', 'achievement_experience_2');"
                         onmouseout ="hideAchievementTooltip('achievement_experience_2');">
                    </div>

                    <div id="tooltip_achievement_experience_2" class="achievement_overview_tooltip">
                        <div class="achievement_icon_tooltip" style="background-image: url(./do_img/global/achievements/achievement_experience_2_63x63.png?__cv=d4abc5cd87afab0474bd89cb23523f00);">
                        </div>
                        <div style="float: left;">
                            <div class="tooltipHeader">Veteran</div>
                            <div class="tooltipContent">Earn 1.000.000 experience points.</div>
                        </div>
                    </div>
                    <div id="achievement_discover_distance_2" style="width:63px; height:63px; background-image: url(./do_img/global/achievements/achievement_discover_distance_2_63x63.png?__cv=c28910cef65d0721c3055bc2f2901d00); background-repeat: no-repeat;" class="recentAchievements"
                         onmouseover="showAchievementTooltip('general', 'achievement_discover_distance_2');"
                         onmouseout ="hideAchievementTooltip('achievement_discover_distance_2');">
                    </div>

                    <div id="tooltip_achievement_discover_distance_2" class="achievement_overview_tooltip">
                        <div class="achievement_icon_tooltip" style="background-image: url(./do_img/global/achievements/achievement_discover_distance_2_63x63.png?__cv=c28910cef65d0721c3055bc2f2901d00);">
                        </div>
                        <div style="float: left;">
                            <div class="tooltipHeader">Last minute</div>
                            <div class="tooltipContent">Complete 1.000.000 routes.</div>
                        </div>
                    </div>
                    <div id="achievement_quest_quests-deathless_2" style="width:63px; height:63px; background-image: url(./do_img/global/achievements/achievement_quest_quests-deathless_2_63x63.png?__cv=e8b415a2f46d9e0b50d87ea457189800); background-repeat: no-repeat;" class="recentAchievements"
                         onmouseover="showAchievementTooltip('general', 'achievement_quest_quests-deathless_2');"
                         onmouseout ="hideAchievementTooltip('achievement_quest_quests-deathless_2');">
                    </div>

                    <div id="tooltip_achievement_quest_quests-deathless_2" class="achievement_overview_tooltip">
                        <div class="achievement_icon_tooltip" style="background-image: url(./do_img/global/achievements/achievement_quest_quests-deathless_2_63x63.png?__cv=e8b415a2f46d9e0b50d87ea457189800);">
                        </div>
                        <div style="float: left;">
                            <div class="tooltipHeader">Indestructible</div>
                            <div class="tooltipContent">Complete 10 missions without dying.</div>
                        </div>
                    </div>
                    <div id="achievement_quest_quests_1" style="width:63px; height:63px; background-image: url(./do_img/global/achievements/achievement_quest_quests_1_63x63.png?__cv=f53d5386d3005b86e8f5917861ef8c00); background-repeat: no-repeat;" class="recentAchievements"
                         onmouseover="showAchievementTooltip('general', 'achievement_quest_quests_1');"
                         onmouseout ="hideAchievementTooltip('achievement_quest_quests_1');">
                    </div>

                    <div id="tooltip_achievement_quest_quests_1" class="achievement_overview_tooltip">
                        <div class="achievement_icon_tooltip" style="background-image: url(./do_img/global/achievements/achievement_quest_quests_1_63x63.png?__cv=f53d5386d3005b86e8f5917861ef8c00);">
                        </div>
                        <div style="float: left;">
                            <div class="tooltipHeader">Rookie</div>
                            <div class="tooltipContent">Complete 5 missions.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="overviewNextAchievements">
                <div id="overviewNextAchievementsLabel" style="background: url(do_img/global/text_tf.esg?l=en&s=10&t=label_achievement_next&f=eurostyle_tmed&color=yellow&bgcolor=grey);height:13px;background-repeat: no-repeat;margin:5px 0 0 5px;"></div>
                <div id="overviewNextAchievementsBorder">
                    <div id="achievement_quest_quests_2" class="nextAchievements" style="width:63px; height:63px; background-image: url(./do_img/global/achievements/achievement_quest_quests_2_63x63.png?__cv=bc93d08b48f2c7ebc7ed076fa4aa3400); background-repeat: no-repeat;"
                         onmouseover="showAchievementTooltip('general', 'achievement_quest_quests_2');"
                         onmouseout ="hideAchievementTooltip('achievement_quest_quests_2');">
                    </div>

                    <div id="tooltip_achievement_quest_quests_2" class="achievement_overview_tooltip">
                        <div class="achievement_icon_tooltip" style="background-image: url(./do_img/global/achievements/achievement_quest_quests_2_63x63.png?__cv=bc93d08b48f2c7ebc7ed076fa4aa3400);">
                        </div>
                        <div style="float: left;">
                            <div class="tooltipHeader">All-rounder</div>
                            <div class="tooltipContent">Complete 20 missions.</div>
                        </div>
                    </div>
                    <div id="achievement_player-cloaked_3" class="nextAchievements" style="width:63px; height:63px; background-image: url(./do_img/global/achievements/achievement_player-cloaked_3_63x63.png?__cv=68d46cf64dd9751875343e3d6bfddc00); background-repeat: no-repeat;"
                         onmouseover="showAchievementTooltip('general', 'achievement_player-cloaked_3');"
                         onmouseout ="hideAchievementTooltip('achievement_player-cloaked_3');">
                        <img style="margin-left: -4px; margin-top: -1px;" src="./do_img/global/achievements/achievement_title_icon_63x63.png?__cv=9cd010b4ed75aa554a0ddbab6e2b3f00">
                    </div>

                    <div id="tooltip_achievement_player-cloaked_3" class="achievement_overview_tooltip">
                        <div class="achievement_icon_tooltip" style="background-image: url(./do_img/global/achievements/achievement_player-cloaked_3_63x63.png?__cv=68d46cf64dd9751875343e3d6bfddc00);">
                            <img src="./do_img/global/achievements/achievement_title_icon_63x63.png?__cv=9cd010b4ed75aa554a0ddbab6e2b3f00">
                        </div>
                        <div style="float: left;">
                            <div class="tooltipHeader">Ninja Master</div>
                            <div class="tooltipContent">You're cloaked for 600 minutes.</div>
                        </div>
                    </div>
                    <div id="achievement_collect_credits_4" class="nextAchievements" style="width:63px; height:63px; background-image: url(./do_img/global/achievements/achievement_collect_credits_4_63x63.png?__cv=5a148583fdce464677bcbf2c3e11be00); background-repeat: no-repeat;"
                         onmouseover="showAchievementTooltip('general', 'achievement_collect_credits_4');"
                         onmouseout ="hideAchievementTooltip('achievement_collect_credits_4');">
                    </div>

                    <div id="tooltip_achievement_collect_credits_4" class="achievement_overview_tooltip">
                        <div class="achievement_icon_tooltip" style="background-image: url(./do_img/global/achievements/achievement_collect_credits_4_63x63.png?__cv=5a148583fdce464677bcbf2c3e11be00);">
                        </div>
                        <div style="float: left;">
                            <div class="tooltipHeader">Money, money, money!</div>
                            <div class="tooltipContent">Collect 15.500.000 Credits.</div>
                        </div>
                    </div>
                    <div id="achievement_discover_distance_3" class="nextAchievements" style="width:63px; height:63px; background-image: url(./do_img/global/achievements/achievement_discover_distance_3_63x63.png?__cv=ab2f5ba4bd4a8681fc8f774641f8c500); background-repeat: no-repeat;"
                         onmouseover="showAchievementTooltip('general', 'achievement_discover_distance_3');"
                         onmouseout ="hideAchievementTooltip('achievement_discover_distance_3');">
                    </div>

                    <div id="tooltip_achievement_discover_distance_3" class="achievement_overview_tooltip">
                        <div class="achievement_icon_tooltip" style="background-image: url(./do_img/global/achievements/achievement_discover_distance_3_63x63.png?__cv=ab2f5ba4bd4a8681fc8f774641f8c500);">
                        </div>
                        <div style="float: left;">
                            <div class="tooltipHeader">Seven-league boots</div>
                            <div class="tooltipContent">Complete 10.000.000 routes.</div>
                        </div>
                    </div>
                    <div id="achievement_misc_whizzed_1" class="nextAchievements" style="width:63px; height:63px; background-image: url(./do_img/global/achievements/achievement_misc_whizzed_1_63x63.png?__cv=3a0e28dfd4b04efa2501c2f9ce577f00); background-repeat: no-repeat;"
                         onmouseover="showAchievementTooltip('general', 'achievement_misc_whizzed_1');"
                         onmouseout ="hideAchievementTooltip('achievement_misc_whizzed_1');">
                    </div>

                    <div id="tooltip_achievement_misc_whizzed_1" class="achievement_overview_tooltip">
                        <div class="achievement_icon_tooltip" style="background-image: url(./do_img/global/achievements/achievement_misc_whizzed_1_63x63.png?__cv=3a0e28dfd4b04efa2501c2f9ce577f00);">
                        </div>
                        <div style="float: left;">
                            <div class="tooltipHeader">Whizzed</div>
                            <div class="tooltipContent">Use WIZ rockets to be transformed into all possible forms.</div>
                        </div>
                    </div>
                    <div id="achievement_event_winterevent2013-space-grinch_5" class="nextAchievements" style="width:63px; height:63px; background-image: url(./do_img/global/achievements/achievement_event_winterevent2013-space-grinch_5_63x63.png?__cv=189a40f1c1b768aaffa80957f7fafe00); background-repeat: no-repeat;"
                         onmouseover="showAchievementTooltip('general', 'achievement_event_winterevent2013-space-grinch_5');"
                         onmouseout ="hideAchievementTooltip('achievement_event_winterevent2013-space-grinch_5');">
                        <img style="margin-left: -4px; margin-top: -1px;" src="./do_img/global/achievements/achievement_title_icon_63x63.png?__cv=9cd010b4ed75aa554a0ddbab6e2b3f00">
                    </div>

                    <div id="tooltip_achievement_event_winterevent2013-space-grinch_5" class="achievement_overview_tooltip">
                        <div class="achievement_icon_tooltip" style="background-image: url(./do_img/global/achievements/achievement_event_winterevent2013-space-grinch_5_63x63.png?__cv=189a40f1c1b768aaffa80957f7fafe00);">
                            <img src="./do_img/global/achievements/achievement_title_icon_63x63.png?__cv=9cd010b4ed75aa554a0ddbab6e2b3f00">
                        </div>
                        <div style="float: left;">
                            <div class="tooltipHeader">Space Grinch</div>
                            <div class="tooltipContent">Destroy 10 Santa 1100101s.</div>
                        </div>
                    </div>
                    <div id="achievement_misc_destroy-npc-all-types_1" class="nextAchievements" style="width:63px; height:63px; background-image: url(./do_img/global/achievements/achievement_misc_destroy-npc-all-types_1_63x63.png?__cv=967470fe499e10d03655781f0a3e6c00); background-repeat: no-repeat;"
                         onmouseover="showAchievementTooltip('general', 'achievement_misc_destroy-npc-all-types_1');"
                         onmouseout ="hideAchievementTooltip('achievement_misc_destroy-npc-all-types_1');">
                    </div>

                    <div id="tooltip_achievement_misc_destroy-npc-all-types_1" class="achievement_overview_tooltip">
                        <div class="achievement_icon_tooltip" style="background-image: url(./do_img/global/achievements/achievement_misc_destroy-npc-all-types_1_63x63.png?__cv=967470fe499e10d03655781f0a3e6c00);">
                        </div>
                        <div style="float: left;">
                            <div class="tooltipHeader">Wow, so many different types of aliens</div>
                            <div class="tooltipContent">Destroy each type of alien at least once.</div>
                        </div>
                    </div>
                </div>
            </div>
            ]]></cmd><cmd cmd="js">SjQuery('.scroll-pane').jScrollPane({showArrows: true, autoReinitialise: true})</cmd></xjx>
    <?php
} elseif (isset($_POST['xjxfun']) && $_POST['xjxfun'] == "nanoTechFactoryShowApis") {
    $total = 45;
    $he = 235;
    header("Content-Type:text/xml");
    if (strpos($_POST['xjxargs'][0], 'N4') !== false) {
        $cO = 10;
        $parts = $factory->getDroneParts('resource_blueprint_zeus-part');
        $tPrice = 1500000;
        $leftPrice = $tPrice - (($tPrice / $total) * $parts);
        $cl = round(($cO / $total) * $parts);
        ?>
        <xjx><cmd cmd="as" id="buffcontainer" prop="innerHTML"><![CDATA[S
                <style  type="text/css">
                    #ntf_drone_name {
                        background-repeat: no-repeat;
                        height: 15px;
                        width: 250px;
                    }
                </style>

                <div id="ntf_center_factory">
                    <div id="ntf_drone_name">
                        <center><img src="./text?t=Drone Construction&w=17&s=12&color=yellow&b=grey" /></center>
                    </div>
                    <div id="ntf_factory_scroll">Occasionally you can find sections of the Zeus drone blueprints in the pirate booty. Once you have all the sections, you can build the drone. You can also build the drone instantly but this requires Uridium. Each piece of the blueprints that you find reduces the price of instantly building the drone.</div>
                    <div id="ntf_drone_parts_zeusPart_<?php echo $cl; ?>" class="ntf_drone_parts"></div>
                    <div id="ntf_drone_build_instant"><div id="<?php if ($leftPrice > $Users->DataRow['uri']): echo "button_build_instant_inactive";
        else: echo "button_build_instant";
        endif; ?>"><a class="but_build_instant_a" onfocus="this.blur()" href="indexInternal.es?action=internalPayment"><span class="<?php if ($leftPrice > $Users->DataRow['uri']): echo "buildlink_inactive";
        else: echo "buildlink";
        endif; ?>">PRODUCE INSTANTLY</span><br /><span class="fliess10px font_info buildlink_inactive"><?php echo number_format($leftPrice); ?> Uridium</span></a></div></div>
                    <div id="ntf_drone_build"><div id="<?php if ($parts < 45): echo "button_build_inactive";
        else: echo "button_build";
        endif; ?>"><strong class="<?php if ($parts < 45): echo "buildlink_inactive";
        else: echo "buildlink";
        endif; ?>">PRODUCE</strong></div></div>
                </div>
        <?php if ($leftPrice > $Users->DataRow['uri']): ?><div id="errorMessage"><div id="errorMessageDroneAlreadyInUse"><div id="errorText">You do not have enough Uridium or parts to construct the Zeus drone.</div><br /></div></div><?php endif; ?>]]></cmd><cmd cmd="as" id="factory_progress_main" prop="innerHTML"><![CDATA[S<div id="factory_progress_bar" style="height:<?php echo (100 / $total) * $parts; ?>%; top:<?php echo $he - (($he / $total) * $parts); ?>px;"></div>]]></cmd><cmd cmd="as" id="factory_progress_count" prop="style.backgroundImage"><![CDATA[Surl(../do_img/global/text.esg?l=de&s=9&t=0&f=eurostyle_thea&color=white&bgcolor=grey)]]></cmd><cmd cmd="as" id="ntf_right_factory" prop="style.display">Sblock</cmd></xjx>
        <?php
    }else {
        $cO = 10;
        $parts = $factory->getDroneParts('resource_blueprint_apis-part');
        $tPrice = 1100000;
        $leftPrice = $tPrice - (($tPrice / $total) * $parts);
        $cl = round(($cO / $total) * $parts);
        ?>
        <xjx><cmd cmd="as" id="buffcontainer" prop="innerHTML"><![CDATA[S
                <style  type="text/css">
                    #ntf_drone_name {
                        background-repeat: no-repeat;
                        height: 15px;
                        width: 250px;
                    }
                </style>

                <div id="ntf_center_factory">
                    <div id="ntf_drone_name">
                        <center><img src="./text?t=Drone Construction&w=17&s=12&color=yellow&b=grey" /></center>
                    </div>
                    <div id="ntf_factory_scroll">Every now and then you can find sections of the Apis drone blueprints in pirate booty. Once you have all the sections, you can build the drone. You can also build the drone instantly but this requires Uridium. Each part of the blueprints you find reduces the price of instantly building the drone.</div>
                    <div id="ntf_drone_parts_apisPart_<?php echo $cl; ?>" class="ntf_drone_parts"></div>
                    <div id="ntf_drone_build_instant"><div id="<?php if ($leftPrice > $Users->DataRow['uri']): echo "button_build_instant_inactive";
        else: echo "button_build_instant";
        endif; ?>"><a class="but_build_instant_a" onfocus="this.blur()" href="indexInternal.es?action=internalPayment"><span class="<?php if ($leftPrice > $Users->DataRow['uri']): echo "buildlink_inactive";
        else: echo "buildlink";
        endif; ?>">PRODUCE INSTANTLY</span><br /><span class="fliess10px font_info buildlink_inactive"><?php echo number_format($leftPrice); ?> Uridium</span></a></div></div>
                    <div id="ntf_drone_build"><div id="<?php if ($parts < 45): echo "button_build_inactive";
        else: echo "button_build";
        endif; ?>"><strong class="<?php if ($parts < 45): echo "buildlink_inactive";
        else: echo "buildlink";
        endif; ?>">PRODUCE</strong></div></div>
                </div>
                <?php if ($leftPrice > $Users->DataRow['uri']): ?><div id="errorMessage"><div id="errorMessageDroneAlreadyInUse"><div id="errorText">You do not have enough Uridium or parts to construct the Apis drone.</div><br /></div></div><?php endif; ?>]]></cmd><cmd cmd="as" id="factory_progress_main" prop="innerHTML"><![CDATA[S<div id="factory_progress_bar" style="height:<?php echo (100 / $total) * $parts; ?>%; top:<?php echo $he - (($he / $total) * $parts); ?>px;"></div>]]></cmd><cmd cmd="as" id="factory_progress_count" prop="style.backgroundImage"><![CDATA[Surl(../do_img/global/text.esg?l=de&s=9&t=0&f=eurostyle_thea&color=white&bgcolor=grey)]]></cmd><cmd cmd="as" id="ntf_right_factory" prop="style.display">Sblock</cmd></xjx>
                <?php
            }
        }elseif (isset($_POST['xjxfun']) && $_POST['xjxfun'] == "nanoTechFactoryShowBuff") {
            $s = $_POST['xjxargs'][0];
            $hall = $factory->getTimes();
            $progress = $unity->cPT($hall[$s]);

            $reso = $factory->getPrices($s);
            $myLogfiles = $factory->getItemsRequired('resource_logfile');
            $mySeprom = $factory->getItemsRequired('resource_ore_seprom');
            if ($reso['logdisk'] <= $myLogfiles && $reso['c'] <= $Users->DataRow['credits'] && $reso['seprom'] <= $mySeprom) {
                $inCLS = "";
            } else {
                $inCLS = "_inactive";
            }
            if ($Users->DataRow['uri'] > $reso['buyn']) {
                $inCLS2 = "";
                $inCLS2A = "_active";
            } else {
                $inCLS2 = "_inactive";
                $inCLS2A = "_inactive";
            }
            if (isset($_POST['xjxargs'][2])) {
                $char = substr($_POST['xjxargs'][2], -1);
                $del = "<![CDATA[SindexInternal.es?action=internalNanoTechFactory&subaction=deleteAllBuffs&slot=$char&reloadToken=a3fc7a4e41c47c74f3808840b7314307]]>";
            } else {
                $del = "*";
            }
            header("Content-Type:text/xml");
            ?>
    <xjx><cmd cmd="as" id="buffcontainer" prop="innerHTML"><![CDATA[S<div id="ntf_center">
                <div id="ntf_buff_scroll">
                    <div id="ntf_buff_name">Name: <span id="ntf_singleBuff_name"><?php echo $factory->l($s . "name"); ?></span></div>
                    <div class="ntf_seperator"></div>
                    <div id="ntf_buff_descr"><?php echo $factory->l($s . "info"); ?></div>
                    <div class="ntf_seperator"></div>
                    <div id="ntf_buff_cost">
                        <table id="ntf_table_cost">
                            <tr>
                                <td><strong>Cost:</strong></td>
                                <td class="ntf_center"><strong><?php echo number_format($reso['c']); ?></strong></td>
                                <td class="ntf_center"><strong><?php echo $reso['seprom']; ?></strong></td>
                                <td class="ntf_center"><strong><?php echo $reso['logdisk']; ?></strong></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="ntf_center">Credits</td>
                                <td class="ntf_center">Seprom</td>
                                <td class="ntf_center">Log-disks</td>
                            </tr>
                            <tr>
                                <td><strong>Available:</strong></td>
                                <td class="ntf_center"><strong><span <?php if ($reso['c'] > $Users->DataRow['credits']): echo 'class="ntf_resource_fail" title="Not enough Credits available"';
            else: echo 'class="ntf_resource_ok" title=""';
            endif; ?>><?php echo number_format($Users->DataRow['credits']); ?></span></strong></td>
                                <td class="ntf_center"><strong><span <?php if ($reso['seprom'] > $mySeprom): echo 'class="ntf_resource_fail" title="Not enough Seprom available"';
            else: echo 'class="ntf_resource_ok" title=""';
            endif; ?>><?php echo $mySeprom; ?></span></strong></td>
                                <td class="ntf_center"><strong><span <?php if ($reso['logdisk'] > $myLogfiles): echo 'class="ntf_resource_fail" title="Not enough Log-Disks available"';
            else: echo 'class="ntf_resource_ok" title=""';
            endif; ?>><?php echo $myLogfiles; ?></span></strong></td>
                            </tr>
                        </table>
                    </div>
                    <div class="ntf_seperator"></div>
                    <div id="ntf_buff_info"><table id="ntf_table_info"><tr><td>Effect:</td><td><?php echo $factory->l($s . "effect"); ?></td></tr><tr><td>Duration:</td><td><?php echo $factory->l($s . "duration"); ?></td></tr><tr><td>Cooldown:</td><td><?php echo $factory->l($s . "cooldown"); ?></td></tr></tr></table><br />
                    </div>
                </div>
                <div id="ntf_buff_build_instant"><div id="button_build_instant<?php echo $inCLS; ?>"><?php if ($inCLS != "_inactive"): ?><a class="but_build_instant_a" onfocus="this.blur()" href="indexInternal.es?action=internalNanoTechFactory&subaction=buildBuff&buff=<?php echo $s; ?>&instant=1"> <?php endif; ?><strong class="buildlink<?php echo $inCLS; ?>">PRODUCE INSTANTLY</strong><?php if ($inCLS != "_inactive"): ?><br/><span class="fliess10px font_info"><?php echo number_format($reso['instant']); ?> Uridium</span> <?php endif; ?><?php if ($inCLS != "_inactive"): ?></a><?php endif; ?></div></div>

    <?php
    if (isset($_POST['xjxargs'][2])) {
        if ($progress) {
            ?>
                        <div id="ntf_buff_build"><div id="button_build"><a class="but_build_instant_a" onfocus="this.blur()" href="indexInternal.es?action=internalNanoTechFactory&subaction=cancelProductin&buff=<?php echo $s; ?>&slot=<?php echo $char; ?>">Cancel<br>production<br></a></div></div>
            <?php
        } else {
            ?>
                        <div id="ntf_buff_build"><div id="button_build"><a class="but_build_instant_a" id="deleteTechs">Delete tech items<br /></a></div></div>
            <?php
        }
    } else {
        ?>
                    <div id="ntf_buff_build">
                    <div id="button_build<?php echo $inCLS; ?>">
                    <?php if ($inCLS2 != "_inactive"): ?>
                        <a class="but_build_instant_a" onfocus="this.blur()" href="indexInternal.es?action=internalNanoTechFactory&subaction=buildBuff&buff=<?php echo $s; ?>"> 
                            <?php endif; ?>
                            <strong class="buildlink<?php echo $inCLS; ?>">PRODUCE</strong><br />
                            <?php echo $factory->convertSeconds($reso['producetime']); ?>
                            <?php if ($inCLS2 != "_inactive"): ?>
                        </a>
                    <?php endif; ?>
                    </div>
</div>
        <?php
    }
    ?>

                <div id="ntf_buff_buy">
                <div id="button_buy<?php echo $inCLS2; ?>">
                <?php if ($inCLS2 != "_inactive"): ?>
                    <a class="but_build_instant_a" onfocus="this.blur()" href="indexInternal.es?action=internalNanoTechFactory&subaction=buynow&buff=<?php echo $s; ?>">
                        <?php endif; ?>
                        <strong class="buildlink<?php echo $inCLS; ?>">BUY NOW</strong>
                        <?php if ($inCLS2 != "_inactive"): ?><br />
                        <span class="fliess10px font_info">
                        <?php echo number_format($reso['buyn']); ?> Uridium</span>
                        <?php endif; ?><?php if ($inCLS != "_inactive"): ?>
                    </a>
                <?php endif; ?>
                </div>
                </div>
            </div>]]></cmd><cmd cmd="js">SjQuery('#ntf_buff_scroll').jScrollPane({showArrows: true, autoReinitialise: true})</cmd><cmd cmd="jc" func="updateConfirm"><xjxobj><e><k>N0</k><v><?php echo $del; ?></v></e></xjxobj></cmd></xjx>
    <?php
}else {
    
}
?>