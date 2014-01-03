<div class="row landing-animate-frame" name="landing-animation-frame-4">
            <nav class="navbar navbar-default">
                <div class="navbar-header">
                    <button class="navbar-toggle" data-target=
                    ".navbar-collapse" data-toggle="collapse" type=
                    "button"></button> <a class="navbar-brand" href="#">Project
                    name</a>
                </div>

                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-left">
                        <li><a data-pjax="true" href="<? echo base_url(); ?>">Home</a></li>
                        <li><a data-pjax="true" href="<?echo base_url();?>/loadLevel">PLAY</a></li>
                        <li><a data-pjax="true" href="<?echo base_url();?>instruction">INSTRUCTION</a></li>
                        <li><a data-pjax="true" href="<?echo base_url();?>comments">FORUM</a></li>
                        
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                    <?
                        if($logged_in)
                        {
                    ?>
                     <li name="k-connect-modal"><a data-toggle="modal" href=
                        "#loginModal" class="k-login-button" style="display:none;"><span font-samarkan font-samarkan-size>k!</span> Login</a></li>
                        <li name="k-connect-profile" class="dropdowns">
                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                                <span name="fullname"><? if($logged_in) { ?><img src="<?php echo encode_base64_image(gravatar($log->email, array('s' => 20, 'd' => 'wavatar'))); ?>"><? } ?> <? echo $log->fullname; ?> <small>(<? echo $log->kid; ?>)</small></span><b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="<? echo base_url(); ?>profile/<? echo $log->profilename; ?>">Profile</a></li>
                                <!-- <li><a href="#">Change Password</a></li> -->
                                <li class="divider"></li>
                                <li><a href="javascript:void(0)" name="attempt-logout">Logout</a></li>
                            </ul>
                        </li>
                    <?
                        }
                        else
                        {
                    ?>
                       <li name="k-connect-modal"><a data-toggle="modal" class="k-login-button" href=
                        "#loginModal"><span font-samarkan font-samarkan-size>k!</span> Login</a></li>
                        <li name="k-connect-profile" class="dropdowns" style="display:none;">
                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                                <span name="fullname"><? if($logged_in) { ?><img src="<?php echo encode_base64_image(gravatar($log->email, array('s' => 20, 'd' => 'wavatar'))); ?>"><? } ?> <? echo $log->fullname; ?> <small>(<? echo $log->kid; ?>)</small></span><b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="<? echo base_url(); ?>profile">Profile</a></li>
                                <!-- <li><a href="#">Change Password</a></li> -->
                                <li class="divider"></li>
                                <li><a href="javascript:void(0)" name="attempt-logout">Logout</a></li>
                            </ul>
                        </li>
                    <?
                        }
                    ?>
                    </ul>
                </div>
            </nav>
        </div>
        
       
        <div class="row">
            &nbsp;
        </div>


    <div class="modal" id="loginModal">
        <div class="modal-dialog">
            <div class="col-lg-12">
                <div class="row">
                    <div id="loginform">
                        <div id="facebook" name="attempt-facebook">
                            <i class="fa fa-facebook"></i>
                            <div id="connect">Connect with Facebook</div>
                        </div>
                        <div id="mainlogin">
                            <div id="or">or</div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <a href="javascript:void(0)" class="pull-right" name="close-button">Close <i class="fa fa-times-circle-o"></i></a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <h1><span font-samarkan>k!</span> Login</h1>
                                </div>
                                <div class="col-lg-6">
                                    <h3>or <a data-toggle="modal" href="#registerModal"><span font-samarkan>k!</span> Register</a></h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div name="login-message"></div>
                                </div>
                            </div>
                            <div class="row">
                                <form name="loginform" role="form" action="javascript:void(0)" method="POST" accept-charset="UTF-8">
                                    <input type="email" name="emailaddress" placeholder="Email Address" required>
                                    <input type="password" name="password" placeholder="Password" required>
                                    <button type="submit"  name="attempt-login"><i class="fa fa-arrow-right"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="registerModal">
        <div class="modal-dialog">
            <div id="loginform">
                <div id="registerlogin">
                    <a href="javascript:void(0)" class="pull-right" name="close-button">Close <i class="fa fa-times-circle-o"></i></a>
                    <div class="row">
                        <div class="col-lg-12">
                            <h1><span font-samarkan>k!</span> Register</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div name="register-message"></div>
                        </div>
                    </div>
                    <div class="row">
                        <form name="registerform" role="form" action="javascript:void(0)" method="POST" accept-charset="UTF-8">
                            <input type="email" name="email" value="<?echo set_value('email');?>" placeholder="Email Address" required>
                            <input type="password" name="password"  value="<?echo set_value('password');?>" placeholder="Password" required>
                            <input type="password" name="spassword"  value="<?echo set_value('spassword');?>" placeholder="Confirm Password" required>
                            <button type="submit"  name="attempt-register"><i class="fa fa-arrow-right"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <? echo "\r\n"; ?>