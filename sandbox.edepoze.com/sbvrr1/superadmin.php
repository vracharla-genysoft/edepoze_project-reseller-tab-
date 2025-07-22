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
    <title>Reseller Management</title>

    <link type="text/css" href="/EDEPOZE_PROJECT/sandbox.edepoze.com/Application/_includes/backend/asset/css/AdminLTE.min.css" rel="stylesheet" />
    <link type="text/css" href="/EDEPOZE_PROJECT/sandbox.edepoze.com/Application/_includes/backend/asset/css/custom-admin.css" rel="stylesheet" />
    <link type="text/css" href="/EDEPOZE_PROJECT/sandbox.edepoze.com/Application/_includes/backend/css/fonts.css" rel="stylesheet" />
    <link type="text/css" href="/EDEPOZE_PROJECT/sandbox.edepoze.com/Application/_includes/backend/css/common.css" rel="stylesheet" />
    <link type="text/css" href="/EDEPOZE_PROJECT/sandbox.edepoze.com/Application/_includes/backend/css/superadmin.css" rel="stylesheet" />

    <script type="text/javascript" src="/EDEPOZE_PROJECT/sandbox.edepoze.com/Framework/_engine/web/js/controls.js"></script>
    <script type="text/javascript" src="/EDEPOZE_PROJECT/sandbox.edepoze.com/Application/_includes/common/js/popup.js"></script>
    <script type="text/javascript" src="/EDEPOZE_PROJECT/sandbox.edepoze.com/Framework/_engine/web/js/ajax.js"></script>
    <script type="text/javascript" src="/EDEPOZE_PROJECT/sandbox.edepoze.com/Framework/_engine/web/js/jquery/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="/EDEPOZE_PROJECT/sandbox.edepoze.com/Framework/_engine/web/js/polyfills.js"></script>
    <script type="text/javascript" src="/EDEPOZE_PROJECT/sandbox.edepoze.com/Application/_includes/common/js/customddb.js"></script>
</head>

<body runat="server" data-fullid="page" id="page687a0a70cddc4">
    <div id="header" style="">
        <div id="custom_logo">
            <a href="/admin" style="">eDepoze</a>
        </div>

        <div id="buttons-container">
            <a href="https://app-sandbox.edepoze.com" target="_blank" class="buttonBlue">
                <span class="buttonBlue_r">Go to Web App</span>
            </a>
        </div>

        <div id="actions">
            <div id="dd" class="wrapper-dropdown" tabindex="1">
                <div class="userprofile" style="display: block;">
                    <div class="profileImage">
                        <p>S</p>
                        <span>Super</span>
                    </div>
                </div>
                <ul class="dropdown">
                    <li>
                        <a href="#">
                            <i class="icon-remove"></i>
                            <div href="javascript:void(0);" class="logout" onclick="ajax.doit('->logout'); _paq.push(['trackEvent', 'User', 'Logout', 'Logout Clicked'])" style="">
                                <span style="">Logout</span>
                                <div class="logout_sign" style="">
                                    <div class="logout_sign_2" style=""></div>
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
        <div runat="server" data-fullid="confirmPopup" style="display:none;" class="popup" id="confirmPopup687a0a70ce5d7">
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
                                <h3 class="title" id="confirmPopupTitle">Confirmation</h3>
                                <div class="data">
                                    <div class="row p_t22">
                                        <h4 class="sub_title" id="confirmPopupSubTitle"></h4>
                                    </div>
                                    <div class="row">
                                        <p class="warning_content" id="confirmPopupContent"></p>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="option_chooser_wrapper">
                                        <div class="option_chooser">
                                            <input runat="server" data-fullid="confirmPopup.btnCancel" class="big-button gray" onclick="popup.hide('confirmPopup687a0a70ce5d7');" name="btnCancel" value="Cancel" type="button" id="btnCancel687a0a70cea0f" />
                                            <input runat="server" data-fullid="confirmPopup.btnOK" class="big-button red" name="btnOK" type="button" value="Confirm" id="btnOK687a0a70cead4" />
                                        </div>
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
        <div runat="server" data-fullid="noticePopup" style="display:none;" class="popup" id="noticePopup687a0a70cecae">
            <div class="popup-notice">
                <div class="shadow-popup"></div>
                <div class="wrap-popup">
                    <div class="popup">

                        <div class="popupcenter">
                            <div class="right">
                                <div class="middle">
                                    <h3 class="title" id="noticePopupTitle"></h3>
                                    <div class="data">
                                        <div class="row p_t22">
                                            <h4 class="sub_title" id="noticePopupSubTitle"></h4>
                                        </div>
                                        <div class="row">
                                            <p class="warning_content" id="noticePopupContent"></p>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="option_chooser_wrapper">
                                            <div class="option_chooser">
                                                <input runat="server" data-fullid="noticePopup.btnCancel" class="big-button gray" onclick="popup.hide('noticePopup687a0a70cecae');" name="btnCancel" value="Close" type="button" id="btnCancel687a0a70cefff" />
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
        <div runat="server" data-fullid="tutorialPopup" style="display:none;" class="popup" id="tutorialPopup687a0a70cf17e">
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
                    popup.hide('tutorialPopup687a0a70cf17e');
                }
            </script>
        </div>
        <div runat="server" data-fullid="mainform" class="content_top" id="mainform687a0a70cda1a">
            <div runat="server" data-fullid="mainform.createTPAuthUser" style="display:none;" class="popup" id="createTPAuthUser687a0a70cf6c6">
                <div class="shadow-popup"></div>
                <div class="wrap-popup" style="height: 500px;width: 1000px;">
                    <div class="popup">
                        <div class="top">
                            <div class="right">
                                <div class="middle"></div>
                            </div>
                        </div>
                        <div class="popupcenter">
                            <div class="right">
                                <div class="middle" style="overflow-x:hidden;overflow-y:visible;overflow:visible;">
                                    <h3 class="title">User Information For TPAuth Registration</h3>
                                    <div class="data" style="margin: 0px 13%; width: 75%;">
                                        <div class="jumbotron">
                                            <h1 style="font-weight: bolder;">Important Note:</h1>
                                            <p>We are moving info most secure and modern process.</p>
                                            <p>We required your valid and unique email. This email will be use on forgot and reset password.
                                            </p>
                                        </div>
                                        <br />
                                        <div class="row">
                                            <div class="col-md-6 col-md-offset-3">
                                                <div class="form-group row">
                                                    <label class="col-4 col-form-label" for="firstname">First Name:</label>
                                                    <div class="col-8">
                                                        <input type="text" readonly="readonly" runat="server" data-fullid="mainform.createTPAuthUser.firstname" class="w_100p form-control" name="firstname" type="text" id="firstname687a0a70cfae4" />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="lastname" class="col-4 col-form-label">Last Name:</label>
                                                    <div class="col-8">
                                                        <input type="text" readonly="readonly" runat="server" data-fullid="mainform.createTPAuthUser.lastname" class="w_100p form-control" name="lastname" type="text" id="lastname687a0a70cfc09" />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="email" class="col-4 col-form-label">Email:</label>
                                                    <div class="col-8">
                                                        <input type="text" runat="server" data-fullid="mainform.createTPAuthUser.email" class="w_100p form-control" name="email" type="text" id="email687a0a70cfd22" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="option_chooser_wrapper">
                                        <div class="option_chooser">
                                            <a runat="server" data-fullid="mainform.createTPAuthUser.btnCancel" class="big-button gray" onclick="popup.hide('createTPAuthUser687a0a70cf6c6');" href="/admin/userlogout" id="btnCancel687a0a70cfe61"></a>
                                            <input runat="server" data-fullid="mainform.createTPAuthUser.btnOK" class="big-button blue" name="btnOK" value="Save" type="button" id="btnOK687a0a70cff2a" />
                                        </div>
                                    </div>
                                    <div class="clear"></div>
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

                <script>
                    function createUser() {
                        var firstname = $("#firstname687a0a70cfae4").val();
                        var lastname = $("#lastname687a0a70cfc09").val();
                        var email = $("#email687a0a70cfd22").val();
                        $.ajax({
                            url: '/admin/user_registration', // Replace with the actual path to your PHP script
                            type: 'POST',
                            data: {
                                'FirstName': firstname,
                                'LastName': lastname,
                                'Email': email,
                                'Clients': ["ReefExhibitQA_IdP"]
                            },
                            success: function(response) {
                                var data = JSON.parse(response);
                                if (data.error) {
                                    console.error("Error: " + data.message);
                                } else {
                                    console.log("Success:", data.data);
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error("AJAX Error:", error);
                            }
                        });
                    }
                </script>
            </div>
            <div class="main">
                <div class="content_header">
                    <h2>Reseller Management</h2>
                    <div class="option_block">
                        <div style="float:left;padding-top:2px;margin-right:20px;">
                            <div class="search_wrapper" style="padding-right:0;">
                                <div class="search_input">
                                    <input type="text" runat="server" data-fullid="mainform.searchText" style="height: 30px;width:210px;padding:1px 0 0 33px;font-size:14px;line-height:14px;" onkeypress="clickSearch(event);" name="searchText" type="text" id="searchText687a0a70d01e6" />
                                </div>
                                <input class="search_btn" type="button" name="go" value="Go" onclick="searchValue(); _paq.push(['trackEvent', 'Search List', 'Search', 'Go Clicked'])" />
                            </div>
                        </div>
                        <a href="/EDEPOZE_PROJECT/sandbox.edepoze.com/Resellers/addresellers.php" class="btn_blue option_btn" target="_blank" onclick="_paq.push(['trackEvent', 'Resellers page', 'Add Reseller', 'Add Reseller Clicked'])">
                            <span class="btn_blue_r" style="margin-right:10px;">Add Reseller</span>
                        </a>

                        <a href="/EDEPOZE_PROJECT/sandbox.edepoze.com/Resellers/userlist.php" class="btn_blue option_btn">
                            <span class="btn_blue_r">User Hierarchy</span>
                        </a>
                    </div>
                </div>
                <div class="clear"></div>
                <div runat="server" data-fullid="mainform.clients" id="clients687a0a70d04db">
                    <div class="panel_control" style="margin-top: 5px;">
                        <div runat="server" data-fullid="mainform.clients.nav2" id="nav2687a0a70d0bb7">
                            <div class="paginator" name="paginator">
                                <p class="go_to_page_caption">Go to Page:</p>
                                <input id="page_nav2687a0a70d0bb7" type="text" class="go_to_page" onkeypress="if (event.keyCode == 13) ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClients@clients687a0a70d04db->__set', 'pos', this.value - 1);" />
                                <a class="btn_go_to_page" onclick="ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClients@clients687a0a70d04db->__set', 'pos', document.getElementById('page_nav2687a0a70d0bb7').value - 1); _paq.push(['trackEvent', 'Search Page', 'Go to page', 'Go Clicked'])"
                                    href="javascript:;"><span>Go</span></a>
                                <a href="javascript:;"><span class="active_page">1</span></a>
                                <a href="javascript:;" onclick="ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClients@clients687a0a70d04db->__set', 'pos', 1);"><span>2</span></a><a href="javascript:;" onclick="ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClients@clients687a0a70d04db->__set', 'pos', 2);"><span>3</span></a>
                                <a href="javascript:;" onclick="ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClients@clients687a0a70d04db->__set', 'pos', 3);"><span>4</span></a>
                                <a href="javascript:;"><span>...</span></a>
                                <a href="javascript:;" onclick="ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClients@clients687a0a70d04db->__set', 'pos', 9);"><span>10</span></a>

                                <a href="javascript:;" class="next_page" onclick="ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClients@clients687a0a70d04db->__set', 'pos', 9);">
                                    <span class="last_page"><span>Last</span></span>
                                </a>
                            </div>
                        </div>
                        <div class="showing">
                            <div style="font-weight:bold;padding-right:5px;">Showing</div>
                            <div class="dynamic-reseller-count">Loading... &nbsp; &nbsp; | &nbsp; &nbsp;</div>
                            <div class="display">Display</div>
                        </div>
                        <div id="container_pageSize687a0a70d0dc0" class="custom-select small" style="width:47px;"><span id="select_pageSize687a0a70d0dc0" class="arrow button" onclick="cddb.open('pageSize687a0a70d0dc0',event)"></span>
                            <div id="val_pageSize687a0a70d0dc0" class="field" style="width:20px;" onclick="cddb.open('pageSize687a0a70d0dc0',event)">10</div>
                            <ul id="list_pageSize687a0a70d0dc0" style="display:none;width:45px;" class="_custom_select_list">
                                <li onclick="cddb.select('pageSize687a0a70d0dc0', '10', this.innerHTML);ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClients@clients687a0a70d04db-&gt;__set', 'pageSize', this.innerHTML);">10</li>
                                <li onclick="cddb.select('pageSize687a0a70d0dc0', '20', this.innerHTML);ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClients@clients687a0a70d04db-&gt;__set', 'pageSize', this.innerHTML);">20</li>
                                <li onclick="cddb.select('pageSize687a0a70d0dc0', '30', this.innerHTML);ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClients@clients687a0a70d04db-&gt;__set', 'pageSize', this.innerHTML);">30</li>
                            </ul><select runat="server" data-fullid="mainform.clients.pageSize" style="display:none;" name="pageSize" id="pageSize687a0a70d0dc0"><option value="10" selected="selected">10</option><option value="20">20</option><option value="30">30</option></select></div>
                        </div>
                        <table class="tbl_info">
                            <thead>
                                <tr>
                                    <th width="10">&nbsp;</th>
                                    <th width="60"><span style="cursor:pointer;" onclick="ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClients@clients687a0a70d04db-&amp;gt;sort', 1);">ID</span></th>
                                    <th><span style="cursor:pointer;" onclick="ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClients@clients687a0a70d04db-&amp;gt;sort', -2);">Reseller Name</span><span class="sort" onclick="ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClients@clients687a0a70d04db-&gt;sort', -2);"></span></th>
                                    <th width="80"><span style="cursor:pointer;" onclick="ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClients@clients687a0a70d04db-&amp;gt;sort', 9);">Type</span></th>
                                    <th width="80"><span style="cursor:pointer;" onclick="ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClients@clients687a0a70d04db-&amp;gt;sort', 8);">Level</span></th>
                                    <th width="200"><span style="cursor:pointer;" onclick="ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClients@clients687a0a70d04db-&amp;gt;sort', 4);">Primary Contact</span></th>
                                    <th width="110"><span style="cursor:pointer;" onclick="ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClients@clients687a0a70d04db-&amp;gt;sort', 5);">Reseller Since</span></th>
                                    <th width="80"><span style="cursor:pointer;" onclick="ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClients@clients687a0a70d04db-&amp;gt;sort', 6);">Status</span></th>
                                    <th width="100"><span style="cursor:pointer;" onclick="ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClients@clients687a0a70d04db-&amp;gt;sort', 10);">Video Conf</span></th>
                                    <th width="140">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody id="resellersTableBody">
                                </tbody>
                        </table>
                        <div class="panel_paginator">
                            <div runat="server" data-fullid="mainform.clients.nav" id="nav687a0a70d1503">
                                <div class="paginator" name="paginator">
                                    <p class="go_to_page_caption">Go to Page:</p>
                                    <input id="page_nav687a0a70d1503" type="text" class="go_to_page" onkeypress="if (event.keyCode == 13) ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClients@clients687a0a70d04db->__set', 'pos', this.value - 1);" />
                                    <a class="btn_go_to_page" onclick="ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClients@clients687a0a70d04db->__set', 'pos', document.getElementById('page_nav2687a0a70d0bb7').value - 1); _paq.push(['trackEvent', 'Search Page', 'Go to page', 'Go Clicked'])"
                                        href="javascript:;"><span>Go</span></a>
                                    <a href="javascript:;"><span class="active_page">1</span></a>
                                    <a href="javascript:;" onclick="ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClients@clients687a0a70d04db->__set', 'pos', 1);"><span>2</span></a><a href="javascript:;" onclick="ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClients@clients687a0a70d04db->__set', 'pos', 2);"><span>3</span></a>
                                    <a href="javascript:;" onclick="ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClients@clients687a0a70d04db->__set', 'pos', 3);"><span>4</span></a>
                                    <a href="javascript:;"><span>...</span></a>
                                    <a href="javascript:;" onclick="ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClients@clients687a0a70d04db->__set', 'pos', 9);"><span>10</span></a>

                                    <a href="javascript:;" class="next_page" onclick="ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClients@clients687a0a70d04db->__set', 'pos', 9);">
                                        <span class="last_page"><span>Last</span></span>
                                    </a>
                                </div>
                            </div>
                            <div class="showing">
                                <div style="font-weight:bold;padding-right:5px;">Showing</div>
                                <div class="dynamic-reseller-count-bottom">1 - 10 of 96 &nbsp; &nbsp; | &nbsp; &nbsp;</div>
                                <div class="display">Display</div>
                            </div>
                            <div id="container_pageSize1687a0a70d16de" class="custom-select small" style="width:47px;"><span id="select_pageSize1687a0a70d16de" class="arrow button" onclick="cddb.open('pageSize1687a0a70d16de',event)"></span>
                                <div id="val_pageSize1687a0a70d16de" class="field" style="width:20px;" onclick="cddb.open('pageSize1687a0a70d16de',event)">10</div>
                                <ul id="list_pageSize1687a0a70d16de" style="display:none;width:45px;" class="_custom_select_list">
                                    <li onclick="cddb.select('pageSize1687a0a70d16de', '10', this.innerHTML);ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClients@clients687a0a70d04db-&gt;__set', 'pageSize', this.innerHTML);">10</li>
                                    <li onclick="cddb.select('pageSize1687a0a70d16de', '20', this.innerHTML);ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClients@clients687a0a70d04db-&gt;__set', 'pageSize', this.innerHTML);">20</li>
                                    <li onclick="cddb.select('pageSize1687a0a70d16de', '30', this.innerHTML);ajax.doit('ClickBlocks\\Web\\UI\\POM\\WidgetClients@clients687a0a70d04db-&gt;__set', 'pageSize', this.innerHTML);">30</li>
                                </ul><select runat="server" data-fullid="mainform.clients.pageSize1" style="display:none;" name="pageSize1" id="pageSize1687a0a70d16de"><option value="10" selected="selected">10</option><option value="20">20</option><option value="30">30</option></select></div>
                            <div class="clear"></div>
                        </div>

                        <hr class="bottom_line" />
                        <div class="clear"></div>

                        <script type="text/javascript">
                            widgetClientCallback = 'ClickBlocks\\Web\\UI\\POM\\WidgetClients@clients687a0a70d04db';

                            // MODIFIED activateAccount function to use the existing confirmPopup
                            function activateAccount(id, currentStatus) {
                                const newStatusValue = currentStatus === 'Active' ? 0 : 1; // 0 for Deactive, 1 for Active
                                const actionVerb = newStatusValue === 1 ? 'activate' : 'deactivate';
                                const confirmPopupId = 'confirmPopup687a0a70ce5d7';
                                const btnOKId = 'btnOK687a0a70cead4';

                                // Set popup content
                                $('#confirmPopupTitle').text('Confirm Action');
                                $('#confirmPopupSubTitle').text(`Are you sure you want to ${actionVerb} this reseller?`);
                                $('#confirmPopupContent').text(`This action will change the status of reseller ID ${id} to ${actionVerb === 'activate' ? 'Active' : 'Deactive'}.`);
                                // Set button text
                                $('#' + btnOKId).val(actionVerb.charAt(0).toUpperCase() + actionVerb.slice(1)); // Capitalize first letter

                                // Remove any previous click handlers from btnOK to prevent multiple executions
                                $('#' + btnOKId).off('click');

                                // Attach new click handler for the OK button on the popup
                                $('#' + btnOKId).on('click', function() {
                                    popup.hide(confirmPopupId); // Hide the confirmation popup first
                                    performStatusUpdate(id, newStatusValue); // Call the function to perform the actual AJAX update
                                });

                                // Show the confirmation popup
                                popup.show(confirmPopupId);
                            }

                            // New function to handle the actual AJAX call for status update
                            function performStatusUpdate(id, newStatus) {
                                console.log(`Attempting to update reseller ID: ${id} to status: ${newStatus}`);

                                $.ajax({
                                    url: '/EDEPOZE_PROJECT/sandbox.edepoze.com/Resellers/update_reseller_status.php', // This path needs to be correct
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        id: id,
                                        status: newStatus
                                    },
                                    success: function(response) {
                                        if (response.status === 'success') {
                                            // Use the existing noticePopup for success messages
                                            $('#noticePopupTitle').text('Success');
                                            $('#noticePopupSubTitle').text(response.message);
                                            $('#noticePopupContent').text(''); // Clear any previous warning
                                            popup.show('noticePopup687a0a70cecae');

                                            loadResellers(); // Reload the table to reflect the changes
                                        } else {
                                            // Use the existing noticePopup for error messages
                                            $('#noticePopupTitle').text('Error');
                                            $('#noticePopupSubTitle').text('Failed to update status.');
                                            $('#noticePopupContent').text(response.message || 'An unknown error occurred.'); // Display message from PHP or generic
                                            popup.show('noticePopup687a0a70cecae');
                                            console.error("Error updating status:", response.message);
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        // Use the existing noticePopup for AJAX errors
                                        $('#noticePopupTitle').text('Network Error');
                                        $('#noticePopupSubTitle').text('Could not connect to the server.');
                                        $('#noticePopupContent').text(`Status: ${status}, Error: ${error}. Please check your internet connection or try again later.`);
                                        popup.show('noticePopup687a0a70cecae');
                                        console.error("AJAX Error:", status, error, xhr.responseText); // Log full response for detailed error
                                    }
                                });
                            }

                            function rowClick(event, link) {
                                var target = event.target || event.srcElement;
                                if (target.tagName != 'A' && target.tagName != 'SPAN') {
                                    document.location = link;
                                }
                            }
                        </script>
                    </div>
                </div>

                <script type="text/javascript">
                    clientCallback = '@';

                    function clickSearch(e) {
                        if ((e || event).keyCode === 13) {
                            searchValue();
                        }
                    }

                    function searchValue() {
                        ajax.doit('->search');
                    }

                    // Function to load reseller data via AJAX
                    function loadResellers() {
                        const tableBody = $('#resellersTableBody');
                        // Select the second div within the .showing class for both top and bottom
                        const globalCountDisplayTop = $('.showing:eq(0) div:eq(1)');
                        const globalCountDisplayBottom = $('.showing:eq(1) div:eq(1)');

                        tableBody.empty().append('<tr><td colspan="10" style="text-align: center;">Loading resellers...</td></tr>');
                        globalCountDisplayTop.text('Loading... \u00A0 \u00A0 | \u00A0 \u00A0'); // Initial state for top global display
                        globalCountDisplayBottom.text('Loading... \u00A0 \u00A0 | \u00A0 \u00A0'); // Initial state for bottom global display

                        $.ajax({
                            url: '/EDEPOZE_PROJECT/sandbox.edepoze.com/admin/get_resellers.php', // This path needs to be correct
                            type: 'GET',
                            dataType: 'json', // Expecting a JSON response
                            success: function(response) {
                                if (response.status === 'success') {
                                    const resellers = response.data;
                                    tableBody.empty(); // Clear existing rows

                                    if (resellers.length > 0) {
                                        const totalRecords = resellers.length;
                                        // Update both global count displays
                                        globalCountDisplayTop.text(`1 - ${totalRecords} of ${totalRecords} \u00A0 \u00A0 | \u00A0 \u00A0`);
                                        globalCountDisplayBottom.text(`1 - ${totalRecords} of ${totalRecords} \u00A0 \u00A0 | \u00A0 \u00A0`);

                                        resellers.forEach(reseller => {
                                            const actionText = reseller.Status === 'Active' ? 'Deactivate' : 'Activate';
                                            const row = `
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td>${reseller.ID}</td>
                                                    <td>${reseller['Reseller Name']}</td>
                                                    <td>${reseller.Type}</td>
                                                    <td>${reseller.Level}</td>
                                                    <td>${reseller['Primary Contact']}</td>
                                                    <td>${reseller['Reseller Since']}</td>
                                                    <td>${reseller.Status}</td>
                                                    <td>${reseller['Video Conf']}</td>
                                                    <td>
                                                        <div class="hide_links">
                                                            <a href="/EDEPOZE_PROJECT/sandbox.edepoze.com/Resellers/addresellers.php?ID=${reseller.ID}" onclick="_paq.push(['trackEvent', 'Reseller/Client Management', 'View/Edit', 'View/Edit Clicked'])">View/Edit</a>
                                                            <a href="javascript:void(0)" onclick="activateAccount(${reseller.ID}, '${reseller.Status}');">
                                                                ${actionText}
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            `;
                                            tableBody.append(row);
                                        });
                                    } else {
                                        tableBody.append('<tr><td colspan="10" style="text-align: center;">No resellers found.</td></tr>');
                                        globalCountDisplayTop.text('0 - 0 of 0 \u00A0 \u00A0 | \u00A0 \u00A0');
                                        globalCountDisplayBottom.text('0 - 0 of 0 \u00A0 \u00A0 | \u00A0 \u00A0');
                                    }
                                } else {
                                    console.error("Error loading resellers:", response.message);
                                    $('#resellersTableBody').empty().append('<tr><td colspan="10" style="text-align: center; color: red;">Error loading data: ' + (response.message || 'Unknown error') + '</td></tr>');
                                    globalCountDisplayTop.text('0 - 0 of 0 \u00A0 \u00A0 | \u00A0 \u00A0');
                                    globalCountDisplayBottom.text('0 - 0 of 0 \u00A0 \u00A0 | \u00A0 \u00A0');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error("AJAX Error:", status, error, xhr.responseText);
                                $('#resellersTableBody').empty().append('<tr><td colspan="10" style="text-align: center; color: red;">Failed to fetch data from server. (Check console for details)</td></tr>');
                                globalCountDisplayTop.text('0 - 0 of 0 \u00A0 \u00A0 | \u00A0 \u00A0');
                                globalCountDisplayBottom.text('0 - 0 of 0 \u00A0 \u00A0 | \u00A0 \u00A0');
                            }
                        });
                    }

                    // Call loadResellers when the document is ready
                    $(document).ready(function() {
                        // Load resellers data when the page loads, assuming the Resellers tab is default active
                        loadResellers();
                    });
                </script>

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
                url: '/EDEPOZE_PROJECT/sandbox.edepoze.com//Application/_includes/backend/js/matomo_config.php',
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
                    console.error('Matomo error: ' + error.responseText);
                }
            })
        })();
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
    </script>
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
                $('.wrapper-dropdown').removeClass('active');
            });
        });
    </script>

    <script type="text/javascript">
        cddb.initialize('pageSize1687a0a70d16de');
        cddb.initialize('pageSize687a0a70d0dc0');
        popup.initialize('createTPAuthUser687a0a70cf6c6', 0);
        popup.initialize('tutorialPopup687a0a70cf17e', 0);
        popup.initialize('noticePopup687a0a70cecae', 0);
        popup.initialize('confirmPopup687a0a70ce5d7', 0);
        ajax.initViewStates();
    </script>
</body>

</html>