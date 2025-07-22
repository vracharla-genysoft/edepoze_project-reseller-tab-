<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'superadmin') {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
    <meta content="text/javascript" http-equiv="Content-Script-Type" />
    <title>User Hierarchy</title>
    <link type="text/css" href="/EDEPOZE_PROJECT/sandbox.edepoze.com/Application/_includes/backend/asset/css/AdminLTE.min.css" rel="stylesheet" />
    <link type="text/css" href="/EDEPOZE_PROJECT/sandbox.edepoze.com/Application/_includes/backend/asset/css/custom-admin.css" rel="stylesheet" />
    <link type="text/css" href="/EDEPOZE_PROJECT/sandbox.edepoze.com/Application/_includes/backend/css/fonts.css" rel="stylesheet" />
    <!--[if IE 7]><link  type="text/css" href="/Application/_includes/backend/css/common-ie7.css" rel="stylesheet" /><![endif]-->
    <link type="text/css" href="/EDEPOZE_PROJECT/sandbox.edepoze.com/Application/_includes/backend/css/common.css" rel="stylesheet" />
    <link type="text/css" href="/EDEPOZE_PROJECT/sandbox.edepoze.com/Application/_includes/backend/css/superadmin.css" rel="stylesheet" />
    <link type="text/css" href="/EDEPOZE_PROJECT/sandbox.edepoze.com/Framework/_engine/web/js/colorpicker/js_color_picker_v2.css" rel="stylesheet" />
    <link type="text/css" href="/EDEPOZE_PROJECT/sandbox.edepoze.com/Framework/_engine/web/js/imgeditor/imgeditor.css" rel="stylesheet" />
    <link type="text/css" href="/EDEPOZE_PROJECT/sandbox.edepoze.com/Application/_includes/backend/css/jquery-ui-1.11.0.min.css" rel="stylesheet" />
    <script type="text/javascript" src="/EDEPOZE_PROJECT/sandbox.edepoze.com/Framework/_engine/web/js/controls.js"></script>
    <script type="text/javascript" src="/EDEPOZE_PROJECT/sandbox.edepoze.com/Application/_includes/common/js/popup.js"></script>
    <script type="text/javascript" src="/EDEPOZE_PROJECT/sandbox.edepoze.com/Framework/_engine/web/js/ajax.js"></script>
    <script type="text/javascript" src="/EDEPOZE_PROJECT/sandbox.edepoze.com/Framework/_engine/web/js/jquery/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="/EDEPOZE_PROJECT/sandbox.edepoze.com/Framework/_engine/web/js/polyfills.js"></script>
    <script type="text/javascript" src="/EDEPOZE_PROJECT/sandbox.edepoze.com/Application/_includes/backend/js/sha1.js"></script>
    <script type="text/javascript" src="/EDEPOZE_PROJECT/sandbox.edepoze.com/Application/_includes/backend/js/country_toggle.js"></script>
    <script type="text/javascript" src="/EDEPOZE_PROJECT/sandbox.edepoze.com/Framework/_engine/web/js/colorpicker/js_color_picker_v2.js"></script>
    <script type="text/javascript" src="/EDEPOZE_PROJECT/sandbox.edepoze.com/Framework/_engine/web/js/raphael.js"></script>
    <script type="text/javascript" src="/EDEPOZE_PROJECT/sandbox.edepoze.com/Framework/_engine/web/js/imgeditor/imgeditor.js"></script>
    <script type="text/javascript" src="/EDEPOZE_PROJECT/sandbox.edepoze.com/Framework/_engine/web/js/validators.js"></script>
    <script type="text/javascript" src="/EDEPOZE_PROJECT/sandbox.edepoze.com/Application/_includes/common/js/customddb.js"></script>
    <script type="text/javascript" src="/EDEPOZE_PROJECT/sandbox.edepoze.com/Framework/_engine/web/js/jquery/jquery-ui-1.11.0.min.js"></script>
    <script type="text/javascript" src="/EDEPOZE_PROJECT/sandbox.edepoze.com/Application/_includes/common/js/datetime.js"></script>
    <script type="text/javascript" src="/EDEPOZE_PROJECT/sandbox.edepoze.com/Framework/_engine/web/js/uploadbutton.js"></script>
    <style>
        /* Style for selected rows */
        .selected-row {
            background-color: #e0e0e0 !important; /* Lighter gray to indicate selection */
        }
        /* Basic styling for sort arrows */
        .sortable-header .sort {
            display: inline-block;
            width: 0;
            height: 0;
            margin-left: 5px;
            vertical-align: middle;
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            opacity: 0.5;
        }
        .sortable-header .sort.sort_top {
            border-bottom: 4px solid #000; /* Up arrow */
        }
        .sortable-header .sort.sort_bottom {
            border-top: 4px solid #000; /* Down arrow */
        }
        .sortable-header .sort.active {
            opacity: 1;
        }
    </style>
</head>

<body runat="server" data-fullid="page" id="page687e22311f404">
    <div id="header">
        <div id="custom_logo">
            <a href="/admin">eDepoze</a>
        </div>

        <div id="buttons-container">
            <a href="https://app-sandbox.edepoze.com" target="_blank" class="buttonBlue">
                <span class="buttonBlue_r">Go to Web App</span>
            </a>
        </div>

        <div id="actions">
            <div id="dd" class="wrapper-dropdown" tabindex="1">
                <div class="userprofile">
                    <div class="profileImage">
                        <p>S</p>
                        <span>Super</span>
                    </div>
                </div>
                <ul class="dropdown">
                    <li>
                        <a href="#">
                            <i class="icon-remove"></i>
                            <div href="javascript:void(0);" class="logout" onclick="ajax.doit('->logout'); _paq.push(['trackEvent', 'User', 'Logout', 'Logout Clicked'])">
                                <span>Logout</span>
                                <div class="logout_sign">
                                    <div class="logout_sign_2"></div>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="myMarquee">
        <div class="header-banner">
            <span><img src="/EDEPOZE_PROJECT/sandbox.edepoze.com/Application/_includes/backend/img/gl-illustration.svg" alt="" /> &nbsp;&nbsp;Help us improve eDepoze! (Paid activity) &nbsp;&nbsp;
                <a id="myAnchor" href="https://calendly.com/nguerrero90/globallink-research-session" target="_blank">Reserve your
                spot</a>
            </span>
        </div>
    </div>
    <div class="main_wrapper_other">
        <div id="menuTabBar" class="tab_menu">
            <ul>
                <li>
                    <a href="/EDEPOZE_PROJECT/sandbox.edepoze.com/sbvrr1/superadmin.php" class="active">
                        Resellers</a>
                </li>
                <li>
                    <a href=" /admin/clients" class="">
                        Clients</a>
                    <ul class="tab_menu_sub">
                        <li>
                            <a href=" /admin/clients">
                                Enterprise Clients</a>
                        </li>
                        <li>
                            <a href=" /admin/courtclients">
                                Court Clients</a>
                        </li>
                        <li>
                            <a href=" /admin/tpauth/users">
                                TPAuth Clients | Users</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href=" /admin/reports/user" class="">
                        Reports</a>
                    <ul class="tab_menu_sub">
                        <li>
                            <a href=" /admin/reports/user">
                                User Report</a>
                        </li>
                        <li>
                            <a href=" /admin/report/commission">
                                Commission Report</a>
                        </li>
                        <li>
                            <a href=" /admin/reports">
                                Usage Report</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href=" /admin/notifications" class="">
                        Notify Users</a>
                </li>
                <li>
                    <a href=" /admin/admins" class="">
                        Admins</a>
                </li>
                <li>
                    <a href=" /admin/myaccount" class="">
                        My Account</a>
                </li>
            </ul>
            <div class="dropshadow"></div>
        </div>
        <div class="menuPlug"></div>
        <div runat="server" data-fullid="confirmPopup" style="display:none;" class="popup" id="confirmPopup687e22311f9b1">
            <div class="shadow-popup"></div>
            <div class="wrap-popup">
                <div class="popup">
                    <div class="top">
                        <div class="right">
                            <div class="middle"></div>
                        </div>
                    </div>
                    <div class="popupcenter">
                        <div class="right">
                            <div class="middle">
                                <h3 class="title">&nbsp;</h3>
                                <div class="data">
                                    <div class="row p_t22">
                                        <h4 class="sub_title"></h4>
                                    </div>
                                    <div class="row">
                                        <p class="warning_content"></p>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="option_chooser_wrapper">
                                        <div class="option_chooser">
                                            <input runat="server" data-fullid="confirmPopup.btnCancel" class="big-button gray" onclick="popup.hide('confirmPopup687e22311f9b1');" name="btnCancel" value="Cancel" type="button" id="btnCancel687e22311fd87" />
                                            <input runat="server" data-fullid="confirmPopup.btnOK" class="big-button red" name="btnOK" type="button" id="btnOK687e22311fe43" /> </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bottom">
                        <div class="right">
                            <div class="middle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div runat="server" data-fullid="noticePopup" style="display:none;" class="popup" id="noticePopup687e223120179">
            <div class="popup-notice">
                <div class="shadow-popup"></div>
                <div class="wrap-popup">
                    <div class="popup">

                        <div class="popupcenter">
                            <div class="right">
                                <div class="middle">
                                    <h3 class="title"></h3>
                                    <div class="data">
                                        <div class="row p_t22">
                                            <h4 class="sub_title"></h4>
                                        </div>
                                        <div class="row">
                                            <p class="warning_content"></p>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="option_chooser_wrapper">
                                            <div class="option_chooser">
                                                <input runat="server" data-fullid="noticePopup.btnCancel" class="big-button gray" onclick="popup.hide('noticePopup687e223120179');" name="btnCancel" value="Close" type="button" id="btnCancel687e22312047f" />
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div runat="server" data-fullid="tutorialPopup" style="display:none;" class="popup" id="tutorialPopup687e2231205f0">
            <div class="shadow-popup z120"></div>
            <div class="wrap-popup viewTutorial thin filePopup">
                <div class="popup">
                    <div class="top">
                        <div class="right">
                            <div class="middle"></div>
                        </div>
                    </div>
                    <div class="popupcenter">
                        <div class="right">
                            <div class="middle">
                                <h3 class="title">&nbsp;</h3>
                                <div class="btnClose" onclick="closeTutorialPlayer();"></div>
                                <div class="data">
                                    <div id="tutorialContainer">
                                        <video id="tutorial_player" class="stopOnHide" controls="controls" preload="auto" autoplay="autoplay" width="100%">
                                            <source src="" type="video/mp4"></source>
                                            Your browser does not support video playback.
                                        </video>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bottom">
                        <div class="right">
                            <div class="middle"></div>
                        </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                function closeTutorialPlayer() {
                    var videoPlayer = document.getElementById('tutorial_player');
                    videoPlayer.pause();
                    videoPlayer.src = '';
                    videoPlayer.load();
                    popup.hide('tutorialPopup687e2231205f0');
                }
            </script>
        </div>
        <div runat="server" data-fullid="mainform" class="content_top" id="mainform687e22311f15b">
            <div class="main">
                <div class="content_header">
                    <h2>User Hierarchy</h2>
                </div>
                <div class="clear"></div>
                <div runat="server" data-fullid="mainform.userlist" id="userlist687e223120ba7">
                    <div class="panel_control" style="margin-top: 5px;">
                        <div runat="server" data-fullid="mainform.userlist.nav2" id="nav2687e223120ff2">
                            <div class="paginator" name="paginator">
                                <p class="go_to_page_caption">Go to Page:</p>
                                <input id="page_nav2687e223120ff2" type="text" class="go_to_page" onkeypress="if (event.keyCode == 13) ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClientUserList@userlist687e223120ba7->__set', 'pos', this.value - 1);" />
                                <a class="btn_go_to_page" onclick="ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClientUserList@userlist687e223120ba7->__set', 'pos', document.getElementById('page_nav2687e223120ff2').value - 1); _paq.push(['trackEvent', 'Search Page', 'Go to page', 'Go Clicked'])"
                                    href="javascript:;"><span>Go</span></a>

                                <a href="javascript:;" class="previous_page" onclick="ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClientUserList@userlist687e223120ba7->__set', 'pos', 0);">
                                    <span class="first_page"><span>First</span></span>
                                </a>

                                <a href="javascript:;" onclick="ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClientUserList@userlist687e223120ba7->__set', 'pos', 0);"><span>1</span></a><a href="javascript:;" onclick="ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClientUserList@userlist687e223120ba7->__set', 'pos', 1);"><span>2</span></a>
                                <a
                                    href="javascript:;" onclick="ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClientUserList@userlist687e223120ba7->__set', 'pos', 2);"><span>3</span></a>
                                    <a href="javascript:;"><span class="active_page">4</span></a>
                            </div>
                        </div>
                        <div class="showing">
                            <div style="font-weight:bold;padding-right:5px;">Showing</div>
                            <!-- THIS IS THE LINE THAT WAS MODIFIED -->
                            <div class="dynamic-global-count-top">Loading... &nbsp; &nbsp; | &nbsp; &nbsp;</div>
                            <div class="display">Display</div>
                        </div>
                        <div id="container_pageSize687e2231211cc" class="custom-select small" style="width:47px;margin-left: 7px;z-index: 2;"><span id="select_pageSize687e2231211cc" class="arrow button" onclick="cddb.open('pageSize687e2231211cc',event)"></span>
                            <div id="val_pageSize687e2231211cc" class="field" style="width:20px;" onclick="cddb.open('pageSize687e2231211cc',event)">30</div>
                            <ul id="list_pageSize687e2231211cc" style="display:none;width:45px;" class="_custom_select_list">
                                <li onclick="cddb.select('pageSize1687e2231211cc', '10', this.innerHTML);ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClientUserList@userlist687e223120ba7->__set', 'pos', this.innerHTML);">10</li>
                                <li onclick="cddb.select('pageSize1687e2231211cc', '20', this.innerHTML);ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClientUserList@userlist687e223120ba7->__set', 'pos', this.innerHTML);">20</li>
                                <li onclick="cddb.select('pageSize1687e2231211cc', '30', this.innerHTML);ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClientUserList@userlist687e223120ba7->__set', 'pos', this.innerHTML);">30</li>
                            </ul><select runat="server" data-fullid="mainform.userlist.pageSize" style="display:none;" name="pageSize" id="pageSize687e2231211cc"><option value="10">10</option><option value="20">20</option><option value="30" selected="selected">30</option></select></div>
                        </div>
                        <div>
                            <div style="float:left; width: 33%;background: white" class="table-container" id="resellerList">
                                <table class="tbl_info">
                                    <thead>
                                        <tr class="reseller-header">
                                            <th width="10">&nbsp;</th>
                                            <th width="90"><span style="cursor:pointer;" class="sortable-header" data-column="ID" data-table="resellerList">ID<span class="sort" id="resellerIDSort"></span></span></th>
                                            <th><span style="cursor:pointer;" class="sortable-header" data-column="Reseller Name" data-table="resellerList">Reseller Name<span class="sort" id="resellerNameSort"></span></span></th>
                                            <th width="140">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody id="resellersTableBody">
                                        <tr><td colspan="4" style="text-align: center;">Loading resellers...</td></tr>
                                    </tbody>
                                </table>
                            </div>

                            <div style="float:left; width: 33%;background: white;" class="table-container" id="clientList">
                                <table class="tbl_info">
                                    <thead>
                                        <tr>
                                            <th width="10">&nbsp;</th>
                                            <th width="60"><span style="cursor:pointer;" class="sortable-header" data-column="ID" data-table="clientList">ID<span class="sort" id="clientAdminIDSort"></span></span></th>
                                            <th><span style="cursor:pointer;" class="sortable-header" data-column="name" data-table="clientList">Client Admin<span class="sort" id="clientAdminNameSort"></span></span></th>
                                            <th width="140">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody id="clientAdminsTableBody">
                                        <tr><td colspan="4" class="t_a_c"><strong>Please Select Reseller</strong></td></tr>
                                    </tbody>
                                </table>
                            </div>


                            <div style="float:left; width: 34%;background: white;" class="table-container" id="userList">
                                <table class="tbl_info">
                                    <thead>
                                        <tr>
                                            <th width="10">&nbsp;</th>
                                            <th width="60"><span style="cursor:pointer;" class="sortable-header" data-column="ID" data-table="userList">ID<span class="sort" id="clientUserIDSort"></span></span></th>
                                            <th><span style="cursor:pointer;" class="sortable-header" data-column="username" data-table="userList">Client User<span class="sort" id="clientUserNameSort"></span></span></th>
                                            <th width="140">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody id="clientUsersTableBody">
                                        <tr><td colspan="4" class="t_a_c"><strong>Please Select Client Admin</strong></td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="clear"></div>

                        <div class="panel_paginator">
                            <div runat="server" data-fullid="mainform.userlist.nav" id="nav687e223121642">
                                <div class="paginator" name="paginator">
                                    <p class="go_to_page_caption">Go to Page:</p>
                                    <input id="page_nav687e223121642" type="text" class="go_to_page" onkeypress="if (event.keyCode == 13) ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClientUserList@userlist687e223120ba7->__set', 'pos', this.value - 1);" />
                                    <a class="btn_go_to_page" onclick="ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClientUserList@userlist687e223120ba7->__set', 'pos', document.getElementById('page_nav2687e223120ff2').value - 1); _paq.push(['trackEvent', 'Search Page', 'Go to page', 'Go Clicked'])"
                                        href="javascript:;"><span>Go</span></a>

                                    <a href="javascript:;" class="previous_page" onclick="ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClientUserList@userlist687e223120ba7->__set', 'pos', 0);">
                                        <span class="first_page"><span>First</span></span>
                                    </a>

                                    <a href="javascript:;" onclick="ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClientUserList@userlist687e223120ba7->__set', 'pos', 0);"><span>1</span></a><a href="javascript:;" onclick="ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClientUserList@userlist687e223120ba7->__set', 'pos', 1);"><span>2</span></a>
                                    <a
                                        href="javascript:;" onclick="ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClientUserList@userlist687e223120ba7->__set', 'pos', 2);"><span>3</span></a>
                                        <a href="javascript:;"><span class="active_page">4</span></a>
                                </div>
                            </div>
                            <div class="showing">
                                <div style="font-weight:bold;padding-right:5px;">Showing</div>
                                <!-- THIS IS THE LINE THAT WAS MODIFIED -->
                                <div class="dynamic-global-count-bottom">Loading... &nbsp; &nbsp; | &nbsp; &nbsp;</div>
                                <div class="display">Display</div>
                            </div>
                            <div id="container_pageSize1687e2231217e2" class="custom-select small" style="width:47px;"><span id="select_pageSize1687e2231217e2" class="arrow button" onclick="cddb.open('pageSize1687e2231217e2',event)"></span>
                                <div id="val_pageSize1687e2231217e2" class="field" style="width:20px;" onclick="cddb.open('pageSize1687e2231217e2',event)">30</div>
                                <ul id="list_pageSize1687e2231217e2" style="display:none;width:45px;" class="_custom_select_list">
                                    <li onclick="cddb.select('pageSize1687e2231217e2', '10', this.innerHTML);ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClientUserList@userlist687e223120ba7->__set', 'pageSize', this.innerHTML);">10</li>
                                    <li onclick="cddb.select('pageSize1687e2231217e2', '20', this.innerHTML);ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClientUserList@userlist687e223120ba7->__set', 'pageSize', this.innerHTML);">20</li>
                                    <li onclick="cddb.select('pageSize1687e2231217e2', '30', this.innerHTML);ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClientUserList@userlist687e223120ba7->__set', 'pageSize', this.innerHTML);">30</li>
                                </ul><select runat="server" data-fullid="mainform.userlist.pageSize1" style="display:none;" name="pageSize1" id="pageSize1687e2231217e2"><option value="10">10</option><option value="20">20</option><option value="30" selected="selected">30</option></select></div>
                            <div class="clear"></div>
                        </div>

                        <hr class="bottom_line" />
                        <div class="clear"></div>

                        <script type="text/javascript">
                            // This callback seems to be for a server-side framework, keep it as is.
                            widgetClientCallback = 'ClickBlocks\\Web\\UI\\POM\\WidgetClientUserList@userlist687e223120ba7';

                            function activateAccount(id, confirm) {
                                if (confirm) {
                                    ajax.doit(widgetClientCallback + '->activateAccount', id);
                                } else {
                                    ajax.doit(widgetClientCallback + '->confirmActivateAccount', id);
                                }
                            }

                            // This function is for navigating, keep it as is.
                            function rowClick(event, link) {
                                var target = event.target || event.srcElement;
                                if (target.tagName != 'A' && target.tagName != 'SPAN') {
                                    document.location = link;
                                }
                            }

                            // This function is for highlighting rows, keep it as is.
                            function highlight_selected_row(clickedTableId) {
                                // Clear all active classes from all rows in all three tables
                                $('#resellersTableBody tr').removeClass('selected-row');
                                $('#clientAdminsTableBody tr').removeClass('selected-row');
                                $('#clientUsersTableBody tr').removeClass('selected-row');

                                // Add active class to the clicked row within its specific table
                                $(event.currentTarget).addClass('selected-row');
                            }

                            // --- NEW/MODIFIED FUNCTIONS FOR DATA LOADING ---

                            // Function to load Resellers
                            function loadResellers() {
                                const tableBody = $('#resellersTableBody');
                                // Select the second div within the .showing class for both top and bottom
                                const topShowingDiv = $('.panel_control .showing'); // Directly target the .showing within .panel_control
                                const bottomShowingDiv = $('.panel_paginator .showing'); // Directly target the .showing within .panel_paginator

                                const globalCountDisplayTop = topShowingDiv.find('div:nth-child(2)'); 
                                const globalCountDisplayBottom = bottomShowingDiv.find('div:nth-child(2)'); 
                                
                                tableBody.empty().append('<tr><td colspan="4" style="text-align: center;">Loading resellers...</td></tr>');
                                globalCountDisplayTop.text('Loading... \u00A0 \u00A0 | \u00A0 \u00A0'); // Initial state for top global display
                                globalCountDisplayBottom.text('Loading... \u00A0 \u00A0 | \u00A0 \u00A0'); // Initial state for bottom global display

                                resetClientAdminsTable(); // Clear client admins and users when loading new resellers

                                $.ajax({
                                    url: '/EDEPOZE_PROJECT/sandbox.edepoze.com/admin/get_resellers.php', // Path to your get_resellers.php
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function(response) {
                                        tableBody.empty(); // Clear loading message
                                        if (response.status === 'success' && response.data.length > 0) {
                                            const totalRecords = response.data.length;
                                            // Update both global count displays
                                            globalCountDisplayTop.text(`1 - ${totalRecords} of ${totalRecords} \u00A0 \u00A0 | \u00A0 \u00A0`);
                                            globalCountDisplayBottom.text(`1 - ${totalRecords} of ${totalRecords} \u00A0 \u00A0 | \u00A0 \u00A0`);

                                            response.data.forEach(function(reseller) {
                                                const row = `
                                                    <tr data-reseller-id="${reseller.ID}">
                                                        <td>&nbsp;</td>
                                                        <td>${reseller.ID}</td>
                                                        <td><div class="to_e" title="${reseller['Reseller Name']}" style="width:200px;">${reseller['Reseller Name']}</div></td>
                                                        <td>
                                                            <div class="hide_links">
                                                                <a href="javascript:void(0);" onclick="loadClientAdmins(${reseller.ID});">View Admins</a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                `;
                                                tableBody.append(row);
                                            });
                                            // Attach click handler to newly added rows for highlighting
                                            $('#resellersTableBody tr').on('click', function() {
                                                highlight_selected_row('resellerList');
                                            });

                                        } else {
                                            tableBody.append('<tr><td colspan="4" style="text-align: center;">No resellers found.</td></tr>');
                                            globalCountDisplayTop.text('0 - 0 of 0 \u00A0 \u00A0 | \u00A0 \u00A0');
                                            globalCountDisplayBottom.text('0 - 0 of 0 \u00A0 \u00A0 | \u00A0 \u00A0');
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.error("AJAX Error loading resellers:", status, error);
                                        tableBody.empty().append('<tr><td colspan="4" style="text-align: center; color: red;">Failed to load resellers.</td></tr>');
                                        globalCountDisplayTop.text('0 - 0 of 0 \u00A0 \u00A0 | \u00A0 \u00A0');
                                        globalCountDisplayBottom.text('0 - 0 of 0 \u00A0 \u00A0 | \u00A0 \u00A0');
                                    }
                                });
                            }


                            // Function to load Client Admins for a given Reseller ID
                            function loadClientAdmins(resellerID) {
                                const tableBody = $('#clientAdminsTableBody');
                                const countDisplay = $('#clientAdminCountDisplay'); // This is the individual table count, keep it.
                                tableBody.empty().append('<tr><td colspan="4" style="text-align: center;">Loading client admins...</td></tr>');
                                countDisplay.text('0 - 0 of 0'); // Reset count display

                                resetClientUsersTable(); // Clear client users when loading new admin list

                                // Highlight the selected reseller row
                                $('#resellersTableBody tr').removeClass('selected-row');
                                $(`#resellersTableBody tr[data-reseller-id="${resellerID}"]`).addClass('selected-row');


                                $.ajax({
                                    url: `/EDEPOZE_PROJECT/sandbox.edepoze.com/Resellers/get_client_admins.php?reseller_id=${resellerID}`, // Path to your get_client_admins.php
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function(response) {
                                        tableBody.empty(); // Clear loading message
                                        if (response.status === 'success' && response.data.length > 0) {
                                            const totalRecords = response.data.length;
                                            countDisplay.text(`1 - ${totalRecords} of ${totalRecords}`); // Update individual table count

                                            response.data.forEach(function(admin) {
                                                const row = `
                                                    <tr data-client-admin-id="${admin.ID}">
                                                        <td>&nbsp;</td>
                                                        <td>${admin.ID}</td>
                                                        <td><div class="to_e" title="${admin.name}" style="width:200px;">${admin.name}</div></td>
                                                        <td>
                                                            <div class="hide_links">
                                                                <a href="javascript:void(0);" onclick="loadClientUsers(${admin.ID});">View Users</a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                `;
                                                tableBody.append(row);
                                            });
                                            // Attach click handler to newly added rows for highlighting
                                            $('#clientAdminsTableBody tr').on('click', function() {
                                                highlight_selected_row('clientList');
                                            });

                                        } else {
                                            tableBody.append('<tr><td colspan="4" style="text-align: center;">No client admins found for this reseller.</td></tr>');
                                            countDisplay.text('0 - 0 of 0');
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.error("AJAX Error loading client admins:", status, error);
                                        tableBody.empty().append('<tr><td colspan="4" style="text-align: center; color: red;">Failed to load client admins.</td></tr>');
                                        countDisplay.text('0 - 0 of 0');
                                    }
                                });
                            }

                            // Function to load Client Users for a given Client Admin ID
                            function loadClientUsers(clientAdminID) {
                                const tableBody = $('#clientUsersTableBody');
                                const countDisplay = $('#clientUserCountDisplay'); // This is the individual table count, keep it.
                                tableBody.empty().append('<tr><td colspan="4" style="text-align: center;">Loading client users...</td></tr>');
                                countDisplay.text('0 - 0 of 0'); // Reset count display

                                // Highlight the selected client admin row
                                $('#clientAdminsTableBody tr').removeClass('selected-row');
                                $(`#clientAdminsTableBody tr[data-client-admin-id="${clientAdminID}"]`).addClass('selected-row');

                                $.ajax({
                                    url: `/EDEPOZE_PROJECT/sandbox.edepoze.com/Resellers/get_client_users.php?client_admin_id=${clientAdminID}`, // Path to your get_client_users.php
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function(response) {
                                        tableBody.empty(); // Clear loading message
                                        if (response.status === 'success' && response.data.length > 0) {
                                            const totalRecords = response.data.length;
                                            countDisplay.text(`1 - ${totalRecords} of ${totalRecords}`); // Update individual table count

                                            response.data.forEach(function(user) {
                                                const row = `
                                                    <tr data-client-user-id="${user.ID}">
                                                        <td>&nbsp;</td>
                                                        <td>${user.ID}</td>
                                                        <td><div class="to_e" title="${user.username}" style="width:200px;">${user.username}</div></td>
                                                        <td>
                                                            <div class="hide_links">
                                                                <a href="/admin/clientuser/edit?ID=${user.ID}">View/Edit</a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                `;
                                                tableBody.append(row);
                                            });
                                            // Attach click handler to newly added rows for highlighting
                                            $('#clientUsersTableBody tr').on('click', function() {
                                                highlight_selected_row('userList');
                                            });

                                        } else {
                                            tableBody.append('<tr><td colspan="4" style="text-align: center;">No client users found for this admin.</td></tr>');
                                            countDisplay.text('0 - 0 of 0');
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.error("AJAX Error loading client users:", status, error);
                                        tableBody.empty().append('<tr><td colspan="4" style="text-align: center; color: red;">Failed to load client users.</td></tr>');
                                        countDisplay.text('0 - 0 of 0');
                                    }
                                });
                            }

                            // Function to reset the Client Admins table to its initial state
                            function resetClientAdminsTable() {
                                const tableBody = $('#clientAdminsTableBody');
                                const countDisplay = $('#clientAdminCountDisplay');
                                tableBody.empty().append('<tr><td colspan="4" class="t_a_c"><strong>Please Select Reseller</strong></td></tr>');
                                countDisplay.text('0 - 0 of 0');
                                $('#resellersTableBody tr').removeClass('selected-row'); // Clear selected reseller row
                                resetClientUsersTable(); // Also reset client users when admins are reset
                            }

                            // Function to reset the Client Users table to its initial state
                            function resetClientUsersTable() {
                                const tableBody = $('#clientUsersTableBody');
                                const countDisplay = $('#clientUserCountDisplay');
                                tableBody.empty().append('<tr><td colspan="4" class="t_a_c"><strong>Please Select Client Admin</strong></td></tr>');
                                countDisplay.text('0 - 0 of 0');
                                $('#clientAdminsTableBody tr').removeClass('selected-row'); // Clear selected admin row
                            }


                            // Universal sorting logic
                            var sortingOrders = {
                                'resellerList': {},
                                'clientList': {},
                                'userList': {}
                            };

                            function sortColumn(column, tableId) {
                                const table = document.querySelector(`#${tableId} table`);
                                const tbody = table.querySelector('tbody');
                                // Exclude the first row (header) from sorting if it's dynamically added
                                let rows = Array.from(tbody.querySelectorAll('tr:not(.reseller-header)'));

                                // Get current sorting order for this table and column
                                let currentOrder = sortingOrders[tableId][column] || 'asc';
                                let newOrder = (currentOrder === 'asc') ? 'desc' : 'asc';
                                sortingOrders[tableId][column] = newOrder;

                                rows.sort(function(a, b) {
                                    let x, y;
                                    let columnIndex = -1;

                                    // Determine the column index based on the column name for each table
                                    if (tableId === 'resellerList') {
                                        if (column === 'ID') columnIndex = 1;
                                        else if (column === 'Reseller Name') columnIndex = 2;
                                    } else if (tableId === 'clientList') {
                                        if (column === 'ID') columnIndex = 1;
                                        else if (column === 'name') columnIndex = 2; // 'name' for client admins
                                    } else if (tableId === 'userList') {
                                        if (column === 'ID') columnIndex = 1;
                                        else if (column === 'username') columnIndex = 2; // 'username' for client users
                                    }

                                    if (columnIndex !== -1) {
                                        x = a.cells[columnIndex].textContent.trim();
                                        y = b.cells[columnIndex].textContent.trim();

                                        // Handle numeric sorting for ID, and string sorting for names
                                        if (column === 'ID') {
                                            x = parseInt(x);
                                            y = parseInt(y);
                                            return (newOrder === 'asc') ? x - y : y - x;
                                        } else {
                                            return (newOrder === 'asc') ? x.localeCompare(y) : y.localeCompare(x);
                                        }
                                    }
                                    return 0; // Should not happen if column name is correct
                                });

                                // Clear existing rows (except the header) and re-append sorted rows
                                $(tbody).empty(); // Clear all rows in tbody
                                // Re-append the header row if it's managed by JS and not in <thead>
                                // For this structure, the <thead> is fixed, so just append sorted rows.
                                rows.forEach(function(row) {
                                    tbody.appendChild(row);
                                });

                                // Update sort arrow visuals
                                $(`#${tableId} .sortable-header .sort`).removeClass('sort_top sort_bottom active'); // Clear all arrows
                                const currentSortArrow = $(`#${tableId} .sortable-header[data-column="${column}"] .sort`);
                                if (newOrder === 'asc') {
                                    currentSortArrow.addClass('sort_top active');
                                } else {
                                    currentSortArrow.addClass('sort_bottom active');
                                }
                            }

                            // Initial load when the document is ready
                            $(document).ready(function() {
                                loadResellers(); // Load initial reseller data

                                // Initialize popups (from your existing code)
                                popup.initialize('tutorialPopup687e2231205f0', 0);
                                popup.initialize('noticePopup687e223120179', 0);
                                popup.initialize('confirmPopup687e22311f9b1', 0);
                                ajax.initViewStates();

                                // Attach click handlers to sortable headers using event delegation
                                $('.table-container').on('click', '.sortable-header', function() {
                                    const column = $(this).data('column');
                                    const tableId = $(this).data('table');
                                    sortColumn(column, tableId);
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer">
            <div class="footer_data">
                <p class="copyright">Copyright &copy; 2025 eDepoze,LLC </p>
            </div>
        </div>
        <script type="text/javascript">
            (function($) {
                $(document).ready(function() {
                    $(window).scroll(function() {
                        if ($(this).scrollTop() > 124) {
                            $('#menuTabBar').addClass('small');
                            $('.menuPlug').show();
                        } else {
                            $('#menuTabBar').removeClass('small');
                            $('.menuPlug').hide();
                        }
                    });
                });
            })(jQuery);


            /*Matomo Integration*/
            var _paq = window._paq = window._paq || [];
            (function() {
                $.ajax({
                    async: false,
                    url: '/Application/_includes/backend/js/matomo_config.php',
                    datatype: "json",
                    crossDomain: true,
                    success: function(matomositeid_json) {
                        var u = "https://techops-analytics.transperfect.com/";
                        _paq.push(['setTrackerUrl', u + 'matomo.php']);
                        _paq.push(['setSiteId', JSON.parse(matomositeid_json)]);
                        var d = document,
                            g = d.createElement('script'),
                            s = d.getElementsByTagName('script')[0];
                        g.async = true;
                        g.src = u + 'matomo.js';
                        s.parentNode.insertBefore(g, s);
                    },
                    error: function(error) {
                        // Changed alert to console.error for better practice
                        console.error('Matomo error: ' + error.responseText);
                    }
                })
            })();
            _paq.push(['trackPageView']);
            _paq.push(['enableLinkTracking']);
        </script>
        <!-- jQuery if needed -->

        <script type="text/javascript">
            function DropDown(el) {
                this.dd = el;
                this.initEvents();
            }
            DropDown.prototype = {
                initEvents: function() {
                    var obj = this;
                    obj.dd.on('click', function(event) {
                        $(this).addClass('active');
                        event.stopPropagation();
                    });
                }
            }
            $(function() {
                var dd = new DropDown($('#dd'));
                $(document).click(function() {
                    // all dropdowns
                    $('.wrapper-dropdown').removeClass('active');
                });
            });
        </script>

        <script type="text/javascript">
            cddb.initialize('pageSize1687e2231217e2');
            cddb.initialize('pageSize687e2231211cc');
            popup.initialize('tutorialPopup687e2231205f0', 0);
            popup.initialize('noticePopup687e223120179', 0);
            popup.initialize('confirmPopup687e22311f9b1', 0);
            ajax.initViewStates();
        </script>
    </body>

</html>
