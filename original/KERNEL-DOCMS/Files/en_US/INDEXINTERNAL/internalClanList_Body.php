<?php
$clan->setId($Users->DataRow['ID'], $Users->DataRow['playerID']);
$clans = $clan->getClans(null, '?action=internalClanList&tpl=internalClanList');
$range = $clan->getRange();
$cuPage = $clan->getCurrentPage();
$total = $clan->getTotalOfResults();
$tPage = $clan->getTotalOfPages();
if (isset($_GET['sort'])) {
    function cust_sort($a, $b) {
        return strtolower($a[$_GET['sort']]) > strtolower($b[$_GET['sort']]);
    }
    usort($clans, 'cust_sort');
}
?>
<body style="background-image: url(/do_img/global/clan/bg_popup_clanliste.jpg);">

<div style="text-align:left;margin-left:30px;height:29px;vertical-align:bottom;"><img src="/text?t=Clan search&w=12&s=11&color=white&b=grey" style="margin-top:15px;"></div>
<div style="text-align:left;margin-left:30px;height:27px;">
    <div>
        <?php echo $clan->paginate('clanlist_navi'); ?>
    </div>
</div>

<div style="margin-left:33px;width:422px;height:220px;overflow:auto;text-align:left;padding:10px 0">
    <table class="fliess11px-weiss" align="left">
     <tbody>
          <?php
                                                if ($total != 0) {
                                                    if ($cuPage == 1) {
                                                        $start = 0;
                                                        if($total<$range):
                                                            $end = $total;
                                                            else:                                                            
                                                            $end = $range;
                                                        endif;
                                                    } else {
                                                        $start = ($cuPage - 1) * $range;
                                                        if ($cuPage != $tPage) {
                                                            $end = $cuPage * $range;
                                                        } else {
                                                            $end = $total;
                                                        }
                                                    }
                                                    for ($i = $start; $i < $end; $i++) {
                                                        if($clans[$i]['recruiting']==1):
                                                                $re = "recruiting";
                                                                $ro = "Recruiting";
                                                            elseif($clans[$i]['recruiting']==0):
                                                                 $re = "notRecruiting";
                                                                 $ro = "Closed";
                                                            elseif($clans[$i]['recruiting']==2):
                                                                 $re = "recruiting";
                                                                 $ro = "Fully elite";
                                                            else:
                                                              $re = "recruiting";
                                                              $ro = "";
                                                        endif;
                                                        if (strpos($clans[$i]['members'], '|') !== false) {
                                                            $v = explode("|", $clans[$i]['members']);
                                                            $num = count($v);
                                                        } else {
                                                            $num = 1;
                                                        }

                                                        $aff = strtoupper($clans[$i]['company']);
                                                  echo '<tr>
                                                        <td><a href="javascript:void(0);" onclick="getClaninfo(11033)">['.$clans[$i]['tagName'].']</a></td>
                                                        <td><a href="javascript:void(0);" onclick="getClaninfo(11033)">' . $clans[$i]['clanName'] . '</a></td>
                                                      </tr>';
                                                    }
                                                } else {
                                                    echo 
                                                    '<tr>
                                                        <td><a href="javascript:void(0);" onclick="getClaninfo(11033)"></a></td>
                                                        <td><a href="javascript:void(0);" onclick="getClaninfo(11033)">There are no clans on the list</a></td>
                                                      </tr>';
                                                }
                                                ?>
     
    
        </tbody></table>
</div>

<div style="margin-top:15px;">
    <div id="sendclantext" style="width:99px;height:15px;background-image:url(./do_img/global/clan/bg_button.gif?__cv=64bbe91ffda8d3988dd016c99cf47800);text-align:center;margin:auto;" class="fliess10px-white">
        <a href="javascript:void(0);" onclick="self.close();" style="display:block;">Close</a>
    </div>
</div>


</body>